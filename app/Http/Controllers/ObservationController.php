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
         return Observation::all();
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
            'attachments' => 'required'
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
            'action' => $request->action,
            'attachments' => $request->attachments
            
        );

        if($request->hasfile('attachments'))
        {
            $attach = $request->attachments;
            $img = $attach->getClientOriginalName();
            $attach->move(public_path('uploads/obserations/'),$img);
            $fields['attachments']=asset('uploads/obserations/'.$img);
          
        
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
