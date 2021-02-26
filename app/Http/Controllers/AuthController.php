<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use Validator;
class AuthController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth:sanctum',['only' => 'me']);
    }
    
    public function register(Request $request)
    {
        // $array = [
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        //     'api_token' => 'my_secret_token'
        // ];

        // $registered = User::create($array);

        // return $registered 
        
        // ? ['user' => $registered , 'success' => true] 
        
        // : ['succes' => false,'error' => 'not registered'];
    }

    public function login(Request $request){ 

       

        $user = User::where('email', $request->email)->first();

        // dd($user);

        if (! $user || ! Hash::check($request->password, $user->password)) {
            
            return response()->json(['error'=>'email or password is incorrect'], 422); 
        }

            return response()->json([
                'token' => $user->createToken('myApp')->plainTextToken,
                'user'=> $user,
                'user_type' => $user->role->role ?? ''
                ]);
        
    }

    public function master_login(Request $request){ 

        $user = User::where('email', $request->email)->where('role_id',1)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            
            return response()->json(['error' => 'email or password is incorrect'], 422); 
        }

            return response()->json([
                'token' => $user->createToken('myApp')->plainTextToken,
                'user'=> $user,
                'user_type' => 'master'
                ]);
        
    }



    public function me(Request $request){
        
        return response()->json([ 'user' => Auth::user() ],200); 

    }
}
