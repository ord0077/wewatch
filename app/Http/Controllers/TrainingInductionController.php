<?php

namespace App\Http\Controllers;

use App\Models\TrainingInduction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TrainingInductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

     

    public function index()
    {
        return TrainingInduction::orderBy('id', 'DESC')->get();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'project_id' => 'required',
            'session_type' => 'required',
            'subject' => 'required',
            'no_attendees' => 'required',
            'attachments' => 'required',

            
            
        ]);
        if ($validator->fails()) {
            return response()->json([ 
                'success' => false, 
                'errors' => $validator->errors() 
                ]); 
        }

        $fields = array(
            'user_id'=>$request->user_id,
            'project_id' => $request->project_id,
            'session_type'=>$request->session_type,
            'subject'=>$request->subject,
            'no_attendees'=>$request->no_attendees,
            'attachments'=>$request->attachments,
            
        );

        if($request->hasFile('attachments')){
            $attach = $request->attachments;
            $img = $attach->getClientOriginalName();
            $attach->move(public_path('uploads/trainingInduction/'),$img);
            $fields['attachments'] = asset('uploads/trainingInduction/' . $img);
        }        
        $ti = TrainingInduction::create($fields);

        list($status,$data) = $ti ? [ true , TrainingInduction::find($ti->id) ] : [ false , ''];
        return ['success' => $status,'data' => $data];

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrainingInduction  $training_induction
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // dd($training_induction);
        return TrainingInduction::find($id);
    }

    


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrainingInduction  $training_induction
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $find = TrainingInduction::find($id);
        return $find->delete() ? ['response_status' => true, 'message'=> 'Recod has been deleted'] : ['response_status' => false, 'message' => 'Recod has not been deleted']; 
    }
}
