<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Project;
use App\Models\DHR;
use App\Models\DSR;
use App\Models\Zone;
use App\Models\User;
use App\Models\Allocation;
use App\Models\ProjectDetail;
use App\Models\BulidActivity;
use App\Models\ProjectHealthCompliance;
use App\Models\HazardIdentify;
use App\Models\NearMissReporting;
use App\Models\CovidCompliance;
use App\Models\AccidentIncident;
use App\Models\Covid;
use App\Models\DailySecurityReport;
use App\Models\DailyVisitorsRegister;
use App\Models\HseReport;
use App\Models\Observation;
use App\Models\Recipient;
use App\Models\TrainingInduction;
use DB;
class ProjectController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth:sanctum');
    }



    public function index()
    {
        return Project::where('is_active',1)->orderBy('id','desc')->get();
    }
    public function archive_projects()
    {
        return Project::where('is_active',0)->orderBy('id','desc')->get();
    }
    public function do_archive($id)
    {
        $project = Project::where('id',$id)->update(['is_active'=>0]);
        list($status,$data) = $project ? [ true , Project::find($id) ] : [ false , ''];
        return ['success' => $status,'data' => $data];
    }
    public function do_active($id)
    {
        $project = Project::where('id',$id)->update(['is_active'=>1]);
        list($status,$data) = $project ? [ true , Project::find($id) ] : [ false , ''];
        return ['success' => $status,'data' => $data];
    }
    // public function index(Request $req)
    // {
    //       return Project::orderBy('id','desc')->paginate($req->per_page);

    // }

    public function projectbyuserid($id,Request $req)
    {
         return Project::where('user_id',$id)->orderBy('id','desc')->get();
    }



    public function projectbymanagerid($id, Request $req)
    {
        $allocations = Allocation::orderBy('id','desc')->select('id','manager_ids as member_ids','project_id')->get();

        $ids = [];

        foreach ($allocations as $allocation) {

            if(in_array($id,json_decode($allocation->member_ids))){

                if($allocation->project){

                    $ids[] =  $allocation->project->id;

                }

            }

        }

        return Project::whereIn('id',$ids)->get();
    }

    public function CheckProjectWithAllocation()
    {

        return Project::without('user','zones')
                    ->select('id','project_name')
                    ->whereNotIn('id', Allocation::distinct('project_id')->pluck('project_id'))
                    ->get();

    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'project_name' => 'required|unique:projects|max:100|min:3',
            'location' => 'required|max:100|min:3',
            'zones' => 'required|numeric|min:1|max:50'
        ]);

        if(!$request->hasFile('project_logo')){
            return [
                'errors' => $validator->errors()->add('project_logo', 'project logo field is required')
            ];

        }
            if ($validator->fails()) {
                return [ 'success' => false, 'errors' => $validator->errors()
                ];
            }

        $fields = [
            'user_id'=>$request->user_id,
            'project_name'=>$request->project_name,
            'location'=>$request->location,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date
        ];


        if($request->hasFile('project_logo')){

            $img =  $request->project_logo->getClientOriginalName();

            $request->project_logo->move(public_path('uploads/logos/'),$img);

            $fields['project_logo'] = asset('uploads/logos/' . $img);
        }
        $project = Project::create($fields);
        $zones = $request->zones;
        for($i = 1; $i<=$zones; $i++){
            $z_fields = array('project_id'=>$project->id, 'zone_name'=>'Zone '.$i);
            $zone = Zone::create($z_fields);
        }
        list($status,$data) = $project ? [ true , Project::find($project->id) ] : [ false , ''];
        return ['success' => $status,'data' => $data];
    }

    public function update_project_logo(Request $request,$id)
    {
        if(!$request->hasFile('project_logo')){

            return [
                    'success' => false,
                    'errors' => [ 'project_logo' => [ 'project logo field is required' ] ]
                ];
        }
        if($request->hasFile('project_logo')){

            $img =  $request->project_logo->getClientOriginalName();

            $request->project_logo->move(public_path('uploads/logos/'),$img);

            $project = Project::where('id',$id)->update([ 'project_logo'=>asset('uploads/logos/' . $img) ]);
            list($status,$data) = $project ? [ true , Project::find($id) ] : [ false , ''];
            return ['success' => $status,'data' => $data];

        }

    }
    public function show($id){
        $project = Project::with([
            // 'dhr',
            'AI',
            'allocation',
            'covid',
            'dailysecurityreport',
            'dvr',
            // 'DSR',
            'hsereport',
            'observation',
            'recipient',
            'traininginduction'
            ])->find($id);

            $project->dhr = DHR::where('project_id', $id)
                    ->with(['projectdetail',
                    'bulidactivity',
                    'projecthealthcompliance',
                    'hazardidentify',
                    'nearmissreporting',
                    'covidcompliance'])->get();
            $project->dsr = DSR::where('project_id', $id)
                    ->with(['projectdetail',
                    'bulidactivity',
                    'projecthealthcompliance',
                    'hazardidentify',
                    'nearmissreporting',
                    'covidcompliance'])->get();
            $filename = str_replace(" ", "-", $project->project_name);
            // return $project;
            return response(json_encode($project))
                            ->withHeaders([
                                'Content-Type' => 'text/plain',
                                'Cache-Control' => 'no-store, no-cache',
                                'Content-Disposition' => 'attachment; filename='.$filename.'.txt',
                            ]);
    
    }
        public function update(Request $request,$id)
        {

            $val_arr = [
                'user_id' => 'required',
                'location' => 'required|max:100|min:3',
                'zones' => 'required|numeric|min:1|max:50',
            ];

                $existing_project = Project::find($id) ?? '';

                if($request->project_name !== $existing_project->project_name){

                    $val_arr = [
                        'project_name' => 'required|unique:projects|max:100|min:3',
                    ];
            }

            $validator = Validator::make($request->all(), $val_arr);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                    ]);
            }

            $fields = array(
                'user_id'=>$request->user_id,
                'project_name'=>$request->project_name,
                'location'=>$request->location,
                'start_date'=>$request->start_date,
                'end_date'=>$request->end_date
            );
            // return ['success' => true,'data' => $request->all()];



            $project = Project::where('id',$id)->update($fields);

            Zone::where('project_id',$id)->delete();

            for($i = 1; $i<= $request->zones; $i++){

                Zone::where('project_id' ,$id)->create([
                'project_id'=>$id, 'zone_name'=>'Zone '.$i
                ]);

            }
            list($status,$data) = $project ? [ true , Project::find($id) ] : [ false , ''];
            return ['success' => $status,'data' => $data];

    }


    public function destroy($id)
    {
        $find = Project::find($id);
        Zone::where('project_id',$id)->delete();

        return $find->delete() ? [ 'response_status' => true, 'message' => 'Project has been deleted' ] : [ 'response_status' => false, 'message' => 'Project cannot delete' ];
    }

    public function import_project(Request $request){
        $contents = file_get_contents($request->project);
        $project = json_decode($contents);
        if(isset($project->id)){
            $p_fields = array(
                "user_id" => $project->user_id,
                "project_name" => $project->project_name,
                "project_logo" => $project->project_logo,
                "location" => $project->location,
                "start_date" => $project->start_date,
                "end_date" => $project->end_date,
                "is_active" => $project->is_active
            );
            $p_create = Project::create($p_fields);
            if($p_create){
                if($project->dhr){
                    foreach($project->dhr as $dhr){
                        $dhr_fields = array(
                            "project_id" => $p_create->id,
                            "user_id" => $dhr->user_id,
                            "date" => $dhr->date,
                            "description_confidential" => $dhr->description_confidential,
                            "daily_situation_summary" => $dhr->daily_situation_summary,
                            "project_key_meeting" => $dhr->project_key_meeting,
                            "toolbox_talk" => $dhr->toolbox_talk,
                            "procurement_request" => $dhr->procurement_request,
                            "red_flag" => $dhr->red_flag,
                        );
                        $dhr_create = DHR::create($dhr_fields);
                        foreach($dhr->projectdetail as $projectdetail){
                            $pd_fields = array(
                                'd_h_r_id' => $dhr_create->id,
                                'weather' => $projectdetail->weather,
                                'wind_strength' => $projectdetail->wind_strength,
                                'weather_wind_remarks' => $projectdetail->weather_wind_remarks,  
                                'design_build_time' => $projectdetail->design_build_time,
                                'daily_operation_man_hour' => $projectdetail->daily_operation_man_hour,
                                'design_time_hour_remarks' => $projectdetail->design_time_hour_remarks,
                                'contractors' => json_encode($projectdetail->contractors),
                                'type_contractors' => json_encode($projectdetail->type_contractors),
                                'total_man_days' => $projectdetail->total_man_days,
                                'total_man_hours' => $projectdetail->total_man_hours,
                                'total_lost_work_hours' => $projectdetail->total_lost_work_hours
                            );
                            DB::table('project_details')->insert($pd_fields);
                        }
                        foreach($dhr->bulidactivity as $bulidactivity){
                            unset($bulidactivity->id);
                            $bulidactivity->d_h_r_id = $dhr_create->id;
                            $ba_fields = (array)$bulidactivity;
                            DB::table('bulid_activities')->insert($ba_fields);
                        }
                        foreach($dhr->projecthealthcompliance as $projecthealthcompliance){
                            unset($projecthealthcompliance->id);
                            $projecthealthcompliance->d_h_r_id = $dhr_create->id;
                            $phc_fields = (array)$projecthealthcompliance;
                            DB::table('project_health_compliances')->insert($phc_fields);
                        }
                        foreach($dhr->hazardidentify as $hazardidentify){
                            unset($hazardidentify->id);
                            $hazardidentify->d_h_r_id = $dhr_create->id;
                            $hi_fields = (array)$hazardidentify;
                            DB::table('hazard_identifies')->insert($hi_fields);
                        }
                        foreach($dhr->nearmissreporting as $nearmissreporting){
                            unset($nearmissreporting->id);
                            $nearmissreporting->d_h_r_id = $dhr_create->id;
                            $nmr_fields = (array)$nearmissreporting;
                            DB::table('near_miss_reportings')->insert($nmr_fields);  
                        }
                        foreach($dhr->covidcompliance as $covidcompliance){
                            unset($covidcompliance->id);
                            $covidcompliance->d_h_r_id = $dhr_create->id;
                            $cc_fields = (array)$covidcompliance;
                            DB::table('covid_compliances')->insert($cc_fields);
                        }
                    }
                }
                if($project->dsr){
                    foreach($project->dsr as $dsr){
                        $dsr_fields = array(
                            "project_id" => $p_create->id,
                            "user_id" => $dsr->user_id,
                            "date" => $dsr->date,
                            "description_confidential" => $dsr->description_confidential,
                            "daily_situation_summary" => $dsr->daily_situation_summary,
                            "project_key_meeting" => $dsr->project_key_meeting,
                            "toolbox_talk" => $dsr->toolbox_talk,
                            "procurement_request" => $dsr->procurement_request,
                            "security_management_plan" => $dsr->security_management_plan,
                            "country_travel_security" => $dsr->country_travel_security,
                            "significant_acts_terrorism" => $dsr->significant_acts_terrorism,
                            "red_flag" => $dsr->red_flag,
                        );
                        $dsr_create = DSR::create($dsr_fields);
                        foreach($dsr->projectdetail as $projectdetail){
                            $pd_fields = array(
                                'd_s_r_id' => $dsr_create->id,
                                'weather' => $projectdetail->weather,
                                'wind_strength' => $projectdetail->wind_strength,
                                'weather_wind_remarks' => $projectdetail->weather_wind_remarks,  
                                'design_build_time' => $projectdetail->design_build_time,
                                'daily_operation_man_hour' => $projectdetail->daily_operation_man_hour,
                                'design_time_hour_remarks' => $projectdetail->design_time_hour_remarks,
                                'contractors' => json_encode($projectdetail->contractors),
                                'type_contractors' => json_encode($projectdetail->type_contractors),
                                'total_man_days' => $projectdetail->total_man_days,
                                'total_man_hours' => $projectdetail->total_man_hours,
                                'total_lost_work_hours' => $projectdetail->total_lost_work_hours
                            );
                            DB::table('project_details')->insert($pd_fields);
                        }
                        foreach($dsr->bulidactivity as $bulidactivity){
                            unset($bulidactivity->id);
                            $bulidactivity->d_s_r_id = $dsr_create->id;
                            $ba_fields = (array)$bulidactivity;
                            DB::table('bulid_activities')->insert($ba_fields);
                        }
                        foreach($dsr->projecthealthcompliance as $projecthealthcompliance){
                            unset($projecthealthcompliance->id);
                            $projecthealthcompliance->d_s_r_id = $dsr_create->id;
                            $phc_fields = (array)$projecthealthcompliance;
                            DB::table('project_health_compliances')->insert($phc_fields);
                        }
                        foreach($dsr->hazardidentify as $hazardidentify){
                            unset($hazardidentify->id);
                            $hazardidentify->d_s_r_id = $dsr_create->id;
                            $hi_fields = (array)$hazardidentify;
                            DB::table('hazard_identifies')->insert($hi_fields);
                        }
                        foreach($dsr->nearmissreporting as $nearmissreporting){
                            unset($nearmissreporting->id);
                            $nearmissreporting->d_s_r_id = $dsr_create->id;
                            $nmr_fields = (array)$nearmissreporting;
                            DB::table('near_miss_reportings')->insert($nmr_fields);  
                        }
                        foreach($dsr->covidcompliance as $covidcompliance){
                            unset($covidcompliance->id);
                            $covidcompliance->d_s_r_id = $dsr_create->id;
                            $cc_fields = (array)$covidcompliance;
                            DB::table('covid_compliances')->insert($cc_fields);
                        }
                    }
                }
                if($project->a_i){
                    foreach($project->a_i as $ai){
                        $ai_fields = array(
                            "user_id" => $ai->user_id,
                            "project_id" => $p_create->id,
                            "location" => $ai->location,
                            "reported_date" => $ai->reported_date,
                            "reported_time" => $ai->reported_time,
                            "category_incident" => $ai->category_incident,
                            "type_injury" => $ai->type_injury,
                            "type_incident" => $ai->type_incident,
                            "other" => $ai->other,
                            "fatality" => $ai->fatality,
                            "describe_incident" => $ai->describe_incident,
                            "immediate_action" => $ai->immediate_action,
                            "attachment" => $ai->attachment,
                        );
                        $ai_create = AccidentIncident::create($ai_fields);
                    }
                }
                if($project->allocation){
                    foreach($project->allocation as $allocation){
                        $al_fields = array(
                            "project_id" => $p_create->id,
                            "user_ids" => $allocation->user_ids,
                            "manager_ids" => $allocation->manager_ids,
                            "guard_ids" => $allocation->guard_ids,
                        );
                        $al_create = Allocation::create($al_fields);
                    }
                }
                if($project->covid){
                    foreach($project->covid as $covid){
                        $c_fields = array(
                            "project_id" => $p_create->id,
                            "user_id" => $covid->user_id,
                            "temperature" => $covid->temperature,
                            "staff_name" => $covid->staff_name,
                            "company" => $covid->company,
                            "remarks" => $covid->remarks,
                            "image" => $covid->image,
                        );
                        $c_create = Covid::create($c_fields);
                    }
                }
                if($project->dailysecurityreport){
                    foreach($project->dailysecurityreport as $dailysecurityreport){
                        unset($dailysecurityreport->id);
                        $dailysecurityreport->project_id = $p_create->id;  
                        $dsr_fields = (array)$dailysecurityreport;                      
                        $dsr_create = DailySecurityReport::create($dsr_fields);
                    }
                }
                if($project->dvr){
                    foreach($project->dvr as $dvr){
                        unset($dvr->id);
                        $dvr->project_id = $p_create->id;   
                        $dvr_fields = (array)$dvr;                     
                        $dvr_create = DailyVisitorsRegister::create($dvr_fields);
                    }
                }
                if($project->hsereport){
                    foreach($project->hsereport as $hsereport){
                        unset($hsereport->id);
                        $hsereport->project_id = $p_create->id;  
                        $hr_fields = (array)$hsereport;                      
                        $hr_create = HseReport::create($hr_fields);
                    }
                }
                if($project->observation){
                    foreach($project->observation as $observation){
                        unset($observation->id);
                        unset($observation->project);
                        $observation->project_id = $p_create->id;  
                        $o_fields = (array)$observation;                      
                        $o_create = Observation::create($o_fields);
                    }
                }
                if($project->recipient){
                    foreach($project->recipient as $recipient){
                        unset($recipient->id);
                        $recipient->project_id = $p_create->id;    
                        $r_fields = (array)$recipient;                    
                        $r_create = Recipient::create($r_fields);
                    }
                }
                if($project->traininginduction){
                    foreach($project->traininginduction as $traininginduction){
                        unset($traininginduction->id);
                        unset($traininginduction->project);
                        $traininginduction->project_id = $p_create->id;  
                        $ti_fields = (array)$traininginduction;                      
                        $ti_create = TrainingInduction::create($ti_fields);
                    }
                }
                return ['success' => true, 'msg' => 'success'];
            }
            else{
                return ['success' => false, 'msg' => 'project create failed!'];
            }
        }
        else{
            return ['success' => false, 'msg' => 'no record found!'];
        }
    }
}
