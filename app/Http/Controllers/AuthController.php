<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Allocation;
use App\Models\Project;

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
        $allocations = [];
        $project = '';

        $project_id = 0;
      
        if($user && $user->role_id == 4) {
            $allocations = Allocation::select('manager_ids','project_id')->pluck('manager_ids');
            
        }
        else if ($user && $user->role_id == 5){
            $allocations = Allocation::select('user_ids','project_id')->pluck('user_ids');
        }

        else if ($user && $user->role_id == 7){
            $allocations = Allocation::select('guard_ids','project_id')->pluck('guard_ids');
        }

        $isAssigned = false;
      
        foreach($allocations as $allocation){

            $isAssigned = in_array($user->id,$allocation) ? true : false;

            if($isAssigned){
                $project = Project::where('user_id',$user->id)->first();
            }

        }
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            
            return response()->json(['error'=>'email or password is incorrect'], 422); 
        }
        else if (!$isAssigned && ($user->role_id == 4 || $user->role_id == 5 || $user->role_id == 7)){
            return response()->json(['error'=>'You are not assigned to any project by the Admin'], 422); 
        }

        else if (!$user->isactive){
            return response()->json(['error'=>'Admin has blocked you. Please contact to your admin.'], 422); 
        }

         $user->user_type = $user->role->role ?? '';

            return response()->json([
                'token' => $user->createToken('myApp')->plainTextToken,
                'user'=> $user,
                'project' => $project,
                'user_id' => $user->id
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
        $user = Auth::user();
        $user->user_type = $user->role->role ?? '';
        return response()->json([ 'user' => Auth::user() ],200); 

    }
}
