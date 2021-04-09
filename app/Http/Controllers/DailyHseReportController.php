<?php

namespace App\Http\Controllers;

use App\Models\DHR;
use App\Models\ProjectDetail as PD;
use App\Models\BulidActivity as BA;
use App\Models\ProjectHealthCompliance as PHC;
use App\Models\HazardIdentify as HI;
use App\Models\NearMissReporting as NMR;
use App\Models\CovidCompliance as CC;
use App\Models\Project as P;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use DB;

class DailyHseReportController extends Controller
{
  
    public function index()
    {
         return DHR::orderBy('id', 'DESC')  
            ->with([
                'project',
                'projectdetail',
                'bulidactivity',
                'projecthealthcompliance',
                'hazardidentify',
                'nearmissreporting',
                'covidcompliance'
                ])
            ->get();     

    }

    public function store(Request $request)
    {
      
            $validator = Validator::make($request->all(),[

                'project_id' => 'required',
                'user_id' => 'required',
                'date' => 'required'

            ]);

            if($validator->fails()){ 
                    return  ['success' => false, 'error' =>  $validator->errors()];
            }

  

            // DB::table('bulid_activities')->insert($bafields);   
            // DB::table('project_health_compliances')->insert($phcfields);    
            // DB::table('project_details')->insert($pfields);   
            // DB::table('hazard_identifies')->insert($hifields);   
            // DB::table('near_miss_reportings')->insert($nmrfields);   
            // DB::table('covid_compliances')->insert($ccfields);   


            DB::beginTransaction();

            try {
            

                $hsefields = array(

                    'project_id' => $request->project_id,
                    'user_id' => $request->user_id,
                    'date' => $request->date,
                    'description_confidential' => $request->description_confidential,
                    'daily_situation_summary' => $request->daily_situation_summary,
                    'project_key_meeting' => $request->project_key_meeting,
                    'toolbox_talk' => $request->toolbox_talk,
                    'procurement_request' => $request->procurement_request,
                    'red_flag' => $request->red_flag,
                
                    );
    
            $success = DHR::create($hsefields);
    
            $pfields = array(
                'd_h_r_id' => $success->id,
                'weather' => $request->weather,
                'wind_strength' => $request->wind_strength,
                'weather_wind_remarks' => $request->weather_wind_remarks,  
                'design_build_time' => $request->design_build_time,
                'daily_operation_man_hour' => $request->daily_operation_man_hour,
                'design_time_hour_remarks' => $request->design_time_hour_remarks,
                'contractors' => $request->contractors,
                'staff_numbers' => $request->staff_numbers,
                'shift_pattern' => $request->shift_pattern,
                'daily_man_hours' => $request->daily_man_hours,
                'type_contractors' => $request->type_contractors,
                'total_man_days' => $request->total_man_days,
                'total_man_hours' => $request->total_man_hours,
                'total_lost_work_hours' => $request->total_lost_work_hours
    
            );
    
            $bafields = array(
    
                'd_h_r_id' => $success->id,
               'activites' => $request->activites,
                'occurrence' => $request->occurrence,
               'remarks' => $request->remarks
    
    
            );
    
            $phcfields = array(
    
                'd_h_r_id' => $success->id,
                'project_health_activites' => $request->project_health_activites,
               'project_health_occurrence' =>  $request->project_health_occurrence,
                'project_health_remarks' =>  $request->project_health_remarks
            );
    
            $hifields =array(
    
               'd_h_r_id' => $success->id,
             'hazard_identify_activites' => $request->hazard_identify_activites,
               'hazard_identify_occurrence' => $request->hazard_identify_occurrence,
               'hazard_identify_remarks' => $request->hazard_identify_remarks
            );
    
            $nmrfields =array(
    
               'd_h_r_id' => $success->id,
               'near_miss_activites' => $request->near_miss_activites,
                'near_miss_occurrence' => $request->near_miss_occurrence,
                'near_miss_remarks' => $request->near_miss_remarks
            );
    
            $ccfields = array(
    
                'd_h_r_id' => $success->id,
                'covid_compliance_activites' => $request->covid_compliance_activites,
                'covid_compliance_occurrence' => $request->covid_compliance_occurrence, 
                'covid_compliance_remarks' => $request->covid_compliance_remarks
            );

            DB::table('bulid_activities')->insert($bafields);   
            DB::table('project_health_compliances')->insert($phcfields);    
            DB::table('project_details')->insert($pfields);   
            DB::table('hazard_identifies')->insert($hifields);   
            DB::table('near_miss_reportings')->insert($nmrfields);   
            DB::table('covid_compliances')->insert($ccfields);   
           // $id = DB::table('d_h_r_s')->insertGetId($hsefields);   
        
          
            list($status,$data) = $success ? [true, $success] : [false, ''];
            return ['success' => $status,'data' => $data];

            DB::commit();
            // all good
            } catch (Exception $e) {
              DB::rollback();
            // something went wrong
            return response()->json($e->errorInfo ?? 'unknown error');
            }


    
      
       

    }

    public function show($id)
    {

        return DHR::with([
            'project',
            'projectdetail',
            'bulidactivity',
            'projecthealthcompliance',
            'hazardidentify',
            'nearmissreporting',
            'covidcompliance'
            ])
            ->find($id);
    }

    public function destroy($id)
    {
        return DHR::find($id)->delete() 
       ? ['response_status' => true, 'message' => "Record has been deleted"] 
       : ['response_status' => false, 'message' => "Record has been deleted" ];
    }
}
