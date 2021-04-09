<?php

namespace App\Http\Controllers;

use App\Models\DSR;
use App\Models\ProjectDetail as PD;
use App\Models\NearMissReporting as NMR;
use App\Models\Project as P;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use DB;

class DSRController extends Controller
{
  
    public function index()
    {
         return DSR::orderBy('id', 'DESC')  
            ->with([
                'project',
                'projectdetail',
                'nearmissreporting'
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
                'security_management_plan' => $request->security_management_plan,
                'country_travel_security' => $request->country_travel_security,
                'significant_acts_terrorism' => $request->significant_acts_terrorism
            
                );

        $success = DSR::create($hsefields);

        $pfields = array(
                'd_s_r_id' => $success->id,
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

        $nmrfields =array(

            'd_s_r_id' => $success->id,
            'near_miss_activites' => $request->near_miss_activites,
            'near_miss_occurrence' => $request->near_miss_occurrence,
            'near_miss_remarks' => $request->near_miss_remarks

        );



            DB::beginTransaction();

            try {
            

         
               
            DB::table('project_details')->insert($pfields); 
            DB::table('near_miss_reportings')->insert($nmrfields);  

            DB::commit();
            
            list($status,$data) = $success ? [true, $this->show($success->id)] : [false, ''];
            return ['success' => $status,'data' => $data];

            // all good
            } catch (Exception $e) {
              DB::rollback();
            // something went wrong
         
            return response()->json($e->errorInfo ?? 'unknown error');
            }


        // }
      
       

    }

    public function show($id)
    {

        return DSR::with([
            'project',
            'projectdetail',
            'nearmissreporting',
            ])
            ->find($id);
    }

    public function destroy($id)
    {
        return DSR::find($id)->delete() 
       ? ['response_status' => true, 'message' => "Record has been deleted"] 
       : ['response_status' => false, 'message' => "Record has been deleted" ];
    }
}
