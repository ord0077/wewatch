<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use App\Models\User;
use App\Models\Project;
use App\Models\Zone;
use Exception;

class UserController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth:sanctum');
	}
    public function index()
    {
        return User::whereNotIn('role_id', [1])->get();
    }

    public function store(Request $request)
    {
        try {
            //code...
       
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'role_id' => 'required',
            // 'project_name' => 'required',
            // 'project_logo' => 'required',
            // 'location' => 'required',
            // 'start_date' => 'required',
            // 'end_date' => 'required'   
        ]);
        if ($validator->fails()) {
            return response()->json([ 
                'success' => false, 
                'errors' => $validator->errors() 
                ]); 
        }
        // avc

        $fields = array(
            'role_id'=>$request->role_id,
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=> $request->password,
            'isactive' => $request->isActive
        );        

    
        $create = User::create($fields);
        // $p_fields = array(
        //     'user_id'=>$create->id,
        //     'project_name'=>$request->project_name,
        //     'location'=>$request->location,
        //     'start_date'=>$request->start_date,
        //     'end_date'=>$request->end_date
        // );
        // if($request->hasFile('project_logo')){

        //     $attach = $request->project_logo;
            
        //     $img = $attach->getClientOriginalName();
        //     $attach->move(public_path('uploads/logos/'),$img);
        //     $p_fields['project_logo'] = asset('uploads/logos/' . $img);
        // }        
        // $project = Project::create($p_fields);
        list($status,$data) = $create ? [ true , User::find($create->id) ] : [ false , ''];
        return ['success' => $status,'data' => $data];

    } catch (Exception $e) {
        return response()->json($e->errorInfo[2] ?? 'unknown error');
     }
    }

    public function show($id)
    {
        $user = User::find($id);
        return $user?['success' => true,'data' => $user]:['success' => false,'data' => ''];
    }

    public function get_users_by_id($role_id)
    {
       
        $users = User::where('role_id',$role_id)->get();
        return $users?['success' => true,'data' => $users]:['success' => false,'data' => ''];
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'confirm_password' => 'same:password',
            'role_id' => 'required'  
        ]);
        if ($validator->fails()) {
            return response()->json([ 
                'success' => false, 
                'errors' => $validator->errors() 
                ]); 
        }

        $fields = array(
            'name'=>$request->name, 
            'email' => $request->email,
            'isactive' => $request->isActive,  
            'role_id' => $request->role_id
        );
        if($request->password){
            $fields['password'] = $request->password;
        }
        
        $update = User::where('id', $id)->update($fields);
        list($status,$data) = $update ? [ true , User::find($id) ] : [ false , ''];
        return ['success' => $status,'data' => $data];
    }

    public function change_password(Request $request,$id)
    {
    $validator = Validator::make($request->all(), [ 
    'change_password' => 'required'
    ]); 
    if ($validator->fails()) { 
        return response()->json([ 'success' => false, 'errors' => $validator->errors() ]); 
    }
    $response = false;
    $update = User::where('id', $id)->update(['password' => $request->change_password]);
    $response = ($update) ?  true : false ;
    return response()->json(['success' => $response] );
    }

    public function destroy($id)
    {
        $find = User::find($id);
        return $find->delete() ? [ 'response_status' => true, 'message' => 'user has been deleted' ] : [ 'response_status' => false, 'message' => 'user cannot delete' ];
    }
}
