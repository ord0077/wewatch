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
use Mail;
use PDF;
use App\Mail\sendmail;
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
                'contractors' => json_encode($request->contractors),
                'type_contractors' => json_encode($request->type_contractors),
                'total_man_days' => $request->total_man_days,
                'total_man_hours' => $request->total_man_hours,
                'total_lost_work_hours' => $request->total_lost_work_hours
    
            );    
                    
          DB::table('project_details')->insert($pfields); 
    
          
            $buildacts = $request->build_activities;
            foreach($buildacts as $build){
                $bafields = array(
                    'd_h_r_id' => $success->id,
                   'activites' => $build["activites"],
                    'occurrence' => $build["occurrence"],
                   'remarks' => $build["remarks"]
                );
                DB::table('bulid_activities')->insert($bafields);
            }
            
            $project_healths = $request->project_health;
            foreach($project_healths as $project_health){
                $phcfields = array(
                    'd_h_r_id' => $success->id,
                    'project_health_activites' => $project_health["project_health_activites"],
                   'project_health_occurrence' =>  $project_health["project_health_occurrence"],
                    'project_health_remarks' =>  $project_health["project_health_remarks"]
                );
                  DB::table('project_health_compliances')->insert($phcfields);
            }

          
            $hazard_identifies = $request->hazard_identify;
            foreach($hazard_identifies as $hazard_identify){
                $hifields =array(
                    'd_h_r_id' => $success->id,
                    'hazard_identify_activites' => $hazard_identify["hazard_identify_activites"],
                    'hazard_identify_occurrence' => $hazard_identify["hazard_identify_occurrence"],
                    'hazard_identify_remarks' => $hazard_identify["hazard_identify_remarks"]
                    ); 
                   
                DB::table('hazard_identifies')->insert($hifields);  
            }    

         

            $near_miss_activities = $request->near_miss_activities;
            foreach($near_miss_activities as $near_miss_activity){
            $nmrfields =array(
                'd_h_r_id' => $success->id,
                'near_miss_activites' => $near_miss_activity["near_miss_activites"],
                 'near_miss_occurrence' => $near_miss_activity["near_miss_occurrence"],
                 'near_miss_remarks' => $near_miss_activity["near_miss_remarks"]
             );
          
            DB::table('near_miss_reportings')->insert($nmrfields);  
            }

           

            $covid_compliances = $request->covid_compliance;
            foreach($covid_compliances as $covid_compliance){
                $ccfields = array(
    
                    'd_h_r_id' => $success->id,
                    'covid_compliance_activites' => $covid_compliance["covid_compliance_activites"],
                    'covid_compliance_occurrence' => $covid_compliance["covid_compliance_occurrence"], 
                    'covid_compliance_remarks' => $covid_compliance["covid_compliance_remarks"]
                );
              
                DB::table('covid_compliances')->insert($ccfields);   
            }

           
        
           $data = ['hse'=> $this->show($success->id)]; 
           $pdf = PDF::loadView('emails.dailyhsepdf', $data);
           $sendto = $request->emails;

        //    return $sendto;

        //    $sendto = array((object)array("email"=>"ali@gmail.com"),(object)array("email"=>"john@gmail.com"));
           $cc = '';
           $bcc = '';
           foreach($sendto as $to){
             $this->send_email($to['email'],$cc,$bcc,$data,$pdf);
           }

            DB::commit();

            list($status,$data) = $success ? [true, $this->show($success->id)] : [false, ''];
            return ['success' => $status,'data' => $data];
           // all good
          } catch (Exception $e) {
               DB::rollback();
            // // something went wrong
            return response()->json($e ?? 'unknown error');
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
    public function send_email($to=null,$cc=null,$bcc=null,$data=null,$pdf=null){
     
            $subject = 'Daily HSE Report';
            $view = 'emails.dailyhse';
            $pdfname = 'dailyhsereport.pdf';
            return Mail::to($to)->send(new sendmail($subject,$data,$view,$pdf,$pdfname));

    }
}
