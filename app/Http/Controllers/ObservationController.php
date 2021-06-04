<?php

namespace App\Http\Controllers;

use App\Models\Observation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class ObservationController extends Controller
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
         return Observation::orderBy('id', 'DESC')->get();
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
            'action' => 'required',
            'location' => 'required',
            'report' => 'required',
        ]);

        if($validator->fails()){

           return response()->json([
               'success' => false,
           'error' => $validator->errors()]);
        }

           $fields= array(

            'user_id' => $request->user_id,
            'project_id' => $request->project_id,
            'observation_description' => $request->observation_description,
            'location' => $request->location,
            'action' => $request->action,
            'attachments' => $request->attachments,
            'report' => $request->report

        );

        if(!empty($request->attachments))
            {
                $type = explode(",", $request->attachments);
                $filename = 'attach_'.uniqid().'.'.$type[0] ?? '';
                if (!file_exists(public_path('uploads/observations/'))) {
                    mkdir(public_path('uploads/observations/'), 0777, true);
                }
                $ifp = fopen( public_path('uploads/observations/'.$filename), 'wb' );
                fwrite( $ifp, base64_decode($type[1]));
                fclose( $ifp );
                $fields['attachments'] = asset('uploads/observations/'.$filename);
            }

         $success = Observation::create($fields);
        list($status,$data) = $success ? [true, Observation::find($success->id)] : [false, ''];

         return ['success' => $status, 'data' => $data];



         } catch (Exception $e)

         {
            return response()->json($e->errorInfo[2] ?? 'unknown error');
         }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Observation  $observation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         return Observation::find($id);
    }

    public function observation_by_project($id)
    {
          return Observation::where('project_id', $id)->get();
    }


    public function update(Request $request, $id)
    {

        try {

       $validator = Validator::make($request->all(),[

            'user_id' => 'required',
            'project_id' => 'required',
            'action' => 'required',
            'location' => 'required',
            'report' => 'required',
        ]);

        if($validator->fails()){

           return response()->json([
               'success' => false,
           'error' => $validator->errors()]);
        }

           $fields= array(

            'user_id' => $request->user_id,
            'project_id' => $request->project_id,
            'observation_description' => $request->observation_description,
            'location' => $request->location,
            'action' => $request->action,
            'report' => $request->report

        );

        if(!empty($request->attachments))
            {
                $type = explode(",", $request->attachments);
                $filename = 'attach_'.uniqid().'.'.$type[0] ?? '';
                if (!file_exists(public_path('uploads/observations/'))) {
                    mkdir(public_path('uploads/observations/'), 0777, true);
                }
                $ifp = fopen( public_path('uploads/observations/'.$filename), 'wb' );
                fwrite( $ifp, base64_decode($type[1]));
                fclose( $ifp );
                $fields['attachments'] = asset('uploads/observations/'.$filename);
            }

         $success = Observation::where('id', $id)->update($fields);
        list($status,$data) = $success ? [true, Observation::find($id)] : [false, ''];

         return ['success' => $status, 'data' => $data];



         } catch (Exception $e)

         {
            return response()->json($e->errorInfo[2] ?? 'unknown error');
         }


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Observation  $observation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $find=Observation::find($id);
            return  $find->delete()
                ? ['response_status' => true, 'message' => "Record has been deleted"]
                : ['response_status' => false, 'message' => "Record has not been deleted"];
    }
}
