<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use App\Models\User;
class UserController extends Controller
{
    // public function __construct()
	// {
	// 	$this->middleware('auth:sanctum');
	// }
    public function index()
    {
        return User::whereNotIn('role_id', [1])->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'role_id' => 'required|not_in:null'   
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
            'password'=>bcrypt($request->password)
        );        
        $create = User::create($fields);
        list($status,$data) = $create ? [ true , User::find($create->id) ] : [ false , ''];
        return ['success' => $status,'data' => $data];
    }

    public function show($id)
    {
        $user = User::find($id);
        return $user?['success' => true,'data' => $user]:['success' => false,'data' => ''];
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'confirm_password' => 'same:password',
            'role_id' => 'required|not_in:null'  
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
            'isactive' => $request->isactive?'1':'0',  
            'role_id' => $request->role_id
        );
        if($request->password){
            $fields['password'] = bcrypt($request->password);
        }
        
        $update = User::where('id', $id)->update($fields);
        list($status,$data) = $update ? [ true , User::find($id) ] : [ false , ''];
        return ['success' => $status,'data' => $data];
    }

    public function destroy($id)
    {
        $find = User::find($id);
        return $find->delete() ? [ 'response_status' => true, 'message' => 'user has been deleted' ] : [ 'response_status' => false, 'message' => 'user cannot delete' ];
    }
}
