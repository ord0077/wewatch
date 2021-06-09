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
		$this->middleware('auth:sanctum',['only' => ['me','getAssignedProjects']]);
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


        $user = User::where('email', $request->email)->whereIn('role_id',[4,5,7])->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {

            return response()->json(['error'=>'email or password is incorrect'], 422);
        }

        else if (!$user->isactive){

            return response()->json(['error'=>'Admin has blocked you. Please contact to your admin.'], 422);
        }

        $allocations = Allocation::orderBy('id','desc')->select('id','manager_ids','user_ids','guard_ids','project_id')->get();



        $ids = [];
        // echo '<pre>';

        foreach ($allocations as $allocation) {

                if(in_array($user->id,$allocation->manager_ids) || in_array($user->id,$allocation->guard_ids) || in_array($user->id,$allocation->user_ids)){


                    if($allocation->project){

                        // print_r($allocation->project);

                        $ids[] =  $allocation->project->id;

                    }

                }

            }
            // dd($ids);
        if (count($ids) == 0){
            return response()->json(['error'=>'You are not assigned to any project by the Admin'], 422);
        }

        $project = Project::withOut(['zones','user']);

        $project = $user->role_id == 4 ?  $project->whereIn('id',$ids)->get() : $project->take(1)->get();

         $user->user_type = $user->role->role ?? '';

            return response()->json([
                'token' => $user->createToken('myApp')->plainTextToken,
                'user'=> $user,
                'project' => $project,
                'user_id' => $user->id
                ]);

    }

    public function master_login(Request $request){

        $user = User::where('email', $request->email)->whereIn('role_id',[1,2,4])->first();
        $allocations = [];

        if($user && $user->role_id == 4) {
            $allocations = Allocation::orderBy('id','desc')->select('id','manager_ids as member_ids','project_id')->get();

        }

        $ids = [];

        foreach ($allocations as $allocation) {

            $mid = json_decode($allocation->member_ids);

            if(in_array($user->id,$mid)){

                if($allocation->project){

                    // print_r($allocation->project);

                    $ids[] =  $allocation->project->id;

                }
            }



        }

        if (! $user || ! Hash::check($request->password, $user->password)) {

            return response()->json(['error' => 'email or password is incorrect'], 422);
        }

        else if (count($ids) == 0 && $user->role_id == 4 ){
            return response()->json(['error'=>'You are not assigned to any project by the Admin'], 422);
        }

        else if (!$user->isactive){
            return response()->json(['error'=>'Admin has blocked you. Please contact to your admin.'], 422);
        }

         $user->user_type = $user->role->role ?? '';

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


    public function getAssignedProjects($id){


        $user = User::findOrFail($id);

        $allocations = [];

        if($user && $user->role_id == 4) {
            $allocations = Allocation::orderBy('id','desc')->select('id','manager_ids as member_ids','project_id')->get();

        }
        else if ($user && $user->role_id == 5){

            $allocations = Allocation::orderBy('id','desc')->select('id','user_ids as member_ids','project_id')
            ->take(1)->get();

        }

        else if ($user && $user->role_id == 7){

            $allocations = Allocation::orderBy('id','desc')->select('id','guard_ids as member_ids','project_id')
            ->take(1)->get();

        }


        $project = [];

        foreach ($allocations as $allocation) {

            if(in_array($user->id,json_decode($allocation->member_ids)) ? true : false){

                $project[] = Project::withOut(['zones','user'])->where('id',$allocation->project->id)->select('id as project_id','project_name','location')->first();
            }

        }

        return [ 'project' => $project ];


    }

    public function logout(){

        return Auth::user();
        Auth::user()->tokens->each(function($token, $key) {
            $token->delete();
        });

        return response()->json([
            'logout' => true,
            'message' => 'logout successfully'
            ]);
    }
}
