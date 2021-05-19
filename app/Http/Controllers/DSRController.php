<?php

namespace App\Http\Controllers;

use App\Models\DSR;
use App\Models\ProjectDetail as PD;
use App\Models\NearMissReporting as NMR;
use App\Models\Project as P;
use App\Models\Recipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use DB;
use Mail;
use PDF;
use App\Mail\sendmail;
use App\Mail\TestMail;
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
        // return (public_path().'/fonts/AR.ttf');

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
                                'contractors' => json_encode($request->contractors),
                                'type_contractors' => json_encode($request->type_contractors),
                                'total_man_days' => $request->total_man_days,
                                'total_man_hours' => $request->total_man_hours,
                                'total_lost_work_hours' => $request->total_lost_work_hours

                                );
                        DB::table('project_details')->insert($pfields);

                        $near_miss_activities = $request->near_miss_activities;
                        foreach($near_miss_activities as $near_miss_activity){
                        $nmrfields =array(
                                'd_s_r_id' => $success->id,
                                'near_miss_activites' => $near_miss_activity["near_miss_activites"],
                                'near_miss_occurrence' => $near_miss_activity["near_miss_occurrence"],
                                'near_miss_remarks' => $near_miss_activity["near_miss_remarks"]
                                 );

                        DB::table('near_miss_reportings')->insert($nmrfields);
                        }







           $data = ['security'=> $this->show($success->id)
             ];
           $pdf = PDF::loadView('emails.dailysecuritypdf', $data);
           $sendto = Recipient::where('project_id',$request->project_id)->select('email')->get();
          $cc = '';
           $bcc = '';
           if($sendto){
                foreach($sendto as $to){
                    $this->send_email($to->email,$cc,$bcc,$data,$pdf);
                }
            }

            DB::commit();

            list($status,$data) = $success ? [true, $this->show($success->id)] : [false, ''];
            return ['success' => $status,'data' => $data];

            // all good
            } catch (Exception $e) {
              DB::rollback();
            // something went wrong

            // return response()->json($e->errorInfo ?? 'unknown error');
            return response()->json($e);
            }


        // }



    }

    public function show($id)
    {

        $show = DSR::with([
            'project',
            'projectdetail',
            'nearmissreporting',
            ])
            ->find($id);
        return $show;
        //return view('emails.dailysecuritypdf',['security'=>$show]);
        //Mail::to('aizazkalwar46@gmail.com')->send(new TestMail($data=''));
    }

    public function destroy($id)
    {
        return DSR::find($id)->delete()
       ? ['response_status' => true, 'message' => "Record has been deleted"]
       : ['response_status' => false, 'message' => "Record has been deleted" ];
    }

    public function send_email($to=null,$cc=null,$bcc=null,$data=null,$pdf=null){

        $subject = 'Daily Security Report';
           $view = 'emails.dailysecurity';
           $pdfname = 'dailysecurityreport.pdf';
        return Mail::to($to)->send(new sendmail($subject,$data,$view,$pdf,$pdfname));

}
}
