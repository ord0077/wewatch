<?php

namespace App\Http\Controllers;

use App\Models\AccidentIncident as AI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class AccidentIncidentController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth:sanctum');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AI::all();
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

        'user_id' => 'required',
        'project_id' => 'required',
        'location' => 'required',
        'reported_date' => 'required',
        'reported_time' => 'required',
        'category_incident' => 'required',
        'type_injury' => 'required',
        'type_incident' => 'required'
        
        
        ]);



       

        if($validator->fails()){
            return  ['success' => false,
            'error' =>  $validator->errors()];
          }



        $fields = array(

        'user_id' => $request->user_id,
        'project_id' => $request->project_id,
        'location' => $request->location,
        'reported_date' => $request->reported_date,
        'reported_time' => $request->reported_time,
        'category_incident' => $request->category_incident,
        'type_injury' => $request->type_injury,
        'type_incident' => $request->type_incident,
        'other' => $request->other,
        'fatality' => $request->fatality,
        'describe_incident' => $request->describe_incident,
        'immediate_action' => $request->immediate_action,
        'attachment' => $request->attachment
            
            );

        
           

            if($request->hasfile('attachment'))
            {
                $attach = $request->attachment;
                $img = $attach->getClientOriginalName();
                $attach->move(public_path('uploads/iccidentincident/'),$img);
                $fields['attachment']=asset('uploads/iccidentincident/'.$img);
                

            }


             $success= AI::create($fields);
          
           list($status,$data) = $success ? [true, AI::find($success->id)] : [false, ''];
           return ['success' => $status,'data' => $data];

         } catch (Exception $e) {
             
            return response()->json($e->errorInfo ?? 'unknown error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AccidentIncident  $accidentIncident
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       return AI::find($id);
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccidentIncident  $accidentIncident
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $find = AI::find($id);
      return $find->delete()
       ? ['response_status' => true, 'message' => "Record has been deleted"]
       : ['response_status' => false, 'message' => 'Record has not been  deleted'];
    }
}
