<?php

namespace App\Http\Controllers;

use App\Models\TrainingInduction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TrainingInductionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

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

        if(!empty($request->attachments))
            {
                $type = explode(",", $request->attachments);
                $filename = 'attach_'.uniqid().'.'.$type[0] ?? '';
                if (!file_exists(public_path('uploads/traininginduction/'))) {
                    mkdir(public_path('uploads/traininginduction/'), 0777, true);
                }
                $ifp = fopen( public_path('uploads/traininginduction/'.$filename), 'wb' );
                fwrite( $ifp, base64_decode($type[1]));
                fclose( $ifp );
                $fields['attachments'] = asset('uploads/traininginduction/'.$filename);
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


    public function traininginduction_by_project($id,Request $req)
    {
          return TrainingInduction::where('project_id', $id)->paginate($req->per_page);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'project_id' => 'required',
            'session_type' => 'required',
            'subject' => 'required',
            'no_attendees' => 'required'
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
            'no_attendees'=>$request->no_attendees

        );

        if(!empty($request->attachments))
            {
                $type = explode(",", $request->attachments);
                $filename = 'attach_'.uniqid().'.'.$type[0] ?? '';
                if (!file_exists(public_path('uploads/traininginduction/'))) {
                    mkdir(public_path('uploads/traininginduction/'), 0777, true);
                }
                $ifp = fopen( public_path('uploads/traininginduction/'.$filename), 'wb' );
                fwrite( $ifp, base64_decode($type[1]));
                fclose( $ifp );
                $fields['attachments'] = asset('uploads/traininginduction/'.$filename);
            }
        $ti = TrainingInduction::where('id', $id)->update($fields);

        list($status,$data) = $ti ? [ true , TrainingInduction::find($id) ] : [ false , ''];
        return ['success' => $status,'data' => $data];

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
