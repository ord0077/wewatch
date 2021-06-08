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
        'attachment' => ''
    );




            if(!empty($request->attachment))
            {
                $type = explode(",", $request->attachment);
                $filename = 'attach_'.uniqid().'.'.$type[0] ?? '';
                if (!file_exists(public_path('uploads/accidentincident/'))) {
                    mkdir(public_path('uploads/accidentincident/'), 0777, true);
                }
                $ifp = fopen( public_path('uploads/accidentincident/'.$filename), 'wb' );
                fwrite( $ifp, base64_decode($type[1]));
                fclose( $ifp );
                $fields['attachment'] = asset('uploads/accidentincident/'.$filename);
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


    public function accidentincident_by_project($id,Request $req)
    {
          return AI::where('project_id', $id)->paginate($req->per_page);
    }

    public function update(Request $request, $id)
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
    );




            if(!empty($request->attachment))
            {
                $type = explode(",", $request->attachment);
                $filename = 'attach_'.uniqid().'.'.$type[0] ?? '';
                if (!file_exists(public_path('uploads/accidentincident/'))) {
                    mkdir(public_path('uploads/accidentincident/'), 0777, true);
                }
                $ifp = fopen( public_path('uploads/accidentincident/'.$filename), 'wb' );
                fwrite( $ifp, base64_decode($type[1]));
                fclose( $ifp );
                $fields['attachment'] = asset('uploads/accidentincident/'.$filename);
            }

             $success= AI::where('id', $id)->update($fields);

           list($status,$data) = $success ? [true, AI::find($id)] : [false, ''];
           return ['success' => $status,'data' => $data];

         } catch (Exception $e) {

            return response()->json($e->errorInfo ?? 'unknown error');
        }
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
