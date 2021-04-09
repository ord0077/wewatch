<?php

namespace App\Http\Controllers;

use App\Models\DailyHseReport as DHR;
use App\Models\ProjectDetail as PD;
use App\Models\BulidActivity as BA;
use App\Models\ProjectHealthCompliance as PHC;
use App\Models\HazardIdentify as HI;
use App\Models\NearMissReporting as NMR;
use App\Models\CovidCompliance as CC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class DailyHseReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DHR::orderBy('id', 'DESC')
        // ->with(['projectdetail'])
        ->with(['project','projectdetail','bulidactivity','projecthealthcompliance','hazardidentify','nearmissreporting','covidcompliance'])
        // ->select('id')
        ->get();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {


       $validator = Validator::make($request->all(),[

        'project_id' => 'required',
        'user_id' => 'required',
        'date' => 'required'

       ]);

       if($validator->fails()){
        return  ['success' => false,
        'error' =>  $validator->errors()];
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
     
        );

        $success = DHR::create($hsefields);

        $pfields = array(
            'daily_hse_report_id' => $success->id,
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

            'daily_hse_report_id' => $success->id,
           'activites' => $request->activites,
            'occurrence' => $request->occurrence,
           'remarks' => $request->remarks


        );

        $phcfields = array(

            'daily_hse_report_id' => $success->id,
            'project_health_activites' => $request->project_health_activites,
           'project_health_occurrence' =>  $request->project_health_occurrence,
            'project_health_remarks' =>  $request->project_health_remarks
        );

        $hifields =array(

           'daily_hse_report_id' => $success->id,
         'hazard_identify_activites' => $request->hazard_identify_activites,
           'hazard_identify_occurrence' => $request->hazard_identify_occurrence,
           'hazard_identify_remarks' => $request->hazard_identify_remarks
        );

        $nmrfields =array(

           'daily_hse_report_id' => $success->id,
           'near_miss_activites' => $request->near_miss_activites,
            'near_miss_occurrence' => $request->near_miss_occurrence,
            'near_miss_remarks' => $request->near_miss_remarks
        );

        $ccfields = array(

           'daily_hse_report_id' => $success->id,
           'covid_compliance_activites' => $request->covid_compliance_activites,
            'covid_compliance_occurrence' => $request->covid_compliance_occurrence, 
            'covid_compliance_remarks' => $request->covid_compliance_remarks
        );



        //    list($status,$data) = $success ? [true, DHR::find($success->id)] : [false, ''];
        //    return ['success' => $status,'data' => $data];

        $pd = PD::create($pfields);

        $ba = BA::create($bafields);

        $phc = PHC::create($phcfields); 

        $hi = HI::create($hifields);

        $nmr = NMR::create($nmrfields);

        $cc = CC::create($ccfields);
          
        //    list($status,$data) = $success ? [true, DHR::find($cc->id)] : [false, ''];
        //    return ['success' => $status,'data' => $data];

        } catch (Exception $e) {
             
            return response()->json($e->errorInfo ?? 'unknown error');
        }

       

      
        $success= DHR::create($hsefields);
          
           list($status,$data) = $success ? [true, DHR::find($success->id)] : [false, ''];
           return ['success' => $status,'data' => $data];
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DailyHseReport  $dailyHseReport
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return DHR::with(['project','projectdetail','bulidactivity','projecthealthcompliance','hazardidentify','nearmissreporting','covidcompliance'])
        ->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DailyHseReport  $dailyHseReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DailyHseReport $dailyHseReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DailyHseReport  $dailyHseReport
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return DHR::find($id)->delete() 
       ? ['response_status' => true, 'message' => "Record has been deleted"] 
       : ['response_status' => false, 'message' => "Record has been deleted" ];
    }
}
