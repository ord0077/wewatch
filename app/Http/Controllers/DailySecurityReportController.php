<?php

namespace App\Http\Controllers;

use App\Models\DailySecurityReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DailySecurityReportController extends Controller
{

    public function __construct(){

        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return DailySecurityReport::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator =Validator::make($request->all(),[
            
            'user_id' => 'required',
            'project_id' => 'required',
            'daily_report_elements' => 'required',
            'guard_organization' => 'required',
            'no_staff' => 'required',
            'no_incidents_daily' => 'required',
            'no_visitors' => 'required',
            'inspections' => 'required',
            'observations' => 'required',
            'travel_security_updates' => 'required',
            'attachments' => 'required'

        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()

            ]);

        }

       $fields =array(
            'user_id' => $request->user_id,
            'project_id' => $request->project_id,
            'daily_report_elements' => $request->daily_report_elements,
            'guard_organization' => $request->guard_organization,
            'no_staff' => $request->no_staff,
            'no_incidents_daily' => $request->no_incidents_daily,
            'no_visitors' => $request->no_visitors,
            'inspections' => $request->inspections,
            'observations' => $request->observations,
            'travel_security_updates' => $request->travel_security_updates,
            'red_flag' => $request->red_flag,
            'attachments' => $request->attachments
 
        );

        if($request->hasFile('attachments'))
        {
           $attach = $request->attachments;
           $img = $attach->getClientOriginalName();
           $attach->move(public_path('uploads/dailysecurityreport/'),$img);
           $fields['attachments']= asset('uploads/dailysecurityreport/'. $img);
        }

        $success = DailySecurityReport::create($fields);

       list($status,$data) = $success ? [true, DailySecurityReport::find($success->id)] : [false, ''];
       return ['success' => $status,'data' => $data];

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DailySecurityReport  $dailySecurityReport
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       return  DailySecurityReport::find($id);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DailySecurityReport  $dailySecurityReport
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $find = DailySecurityReport::find($id); 
      return $find->delete() 
      ? ['response_status' => true, 'message' => "Record has been deleted"] 
      : ['response_status' => false, 'message' => "Record has been deleted" ];
    }
}
