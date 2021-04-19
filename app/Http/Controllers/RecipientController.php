<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Models\Project;
use App\Models\Recipient;
class RecipientController extends Controller
{
    public function index()
    {
        return Recipient::all();
    }

    public function store(Request $request)
    {
        try {
    
            $validator = Validator::make($request->all(), [
                    'project_id' => 'required',
                    'emails' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json([ 
                    'success' => false, 
                    'errors' => $validator->errors() 
                    ]); 
            }
            $arr = array();
            $save = null;
            $emails = $request->emails;
            foreach($emails as $email){
                if($email['email'] != null){
                    $mailin = Recipient::where('project_id',$request->project_id)->where('email', $email['email'])->first();
                    if($mailin){
                        $arr[] = $email['email'];
                    }
                    else{
                        $fields = array(
                            'project_id' => $request->project_id,
                            'email'=> $email['email']
                        );
                        $save = Recipient::create($fields);
                    }
                }
            }  
    
            list($status,$data) = $save ? [ true , $this->show($request->project_id) ] : [ false , ''];
            return ['success' => $status,'data' => $data, 'exists'=>$arr];
                   
    
            } catch (Exception $e) {
    
                 return response()->json($e->errorInfo[2] ?? 'unknown error');
            }
    }

    public function show($id)
    {
        return Recipient::where('project_id',$id)->get();
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([ 
                'success' => false, 
                'errors' => $validator->errors() 
                ]); 
        }
        $email = $request->email;
            $fields = array(
                'email'=>$email,
            );
            
        $update = Recipient::where('id', $id)->update($fields);
        
            list($status,$data) = $update ? [ true , Recipient::find($id) ] : [ false , ''];
            return ['success' => $status,'data' => $data];
                   
    
            } catch (Exception $e) {
    
                 return response()->json($e->errorInfo[2] ?? 'unknown error');
            }
    }

    public function destroy($id)
    {
        return Recipient::find($id)->delete() 
       ? ['response_status' => true, 'message' => "Record has been deleted"] 
       : ['response_status' => false, 'message' => "Record has been deleted" ];
    }
}
