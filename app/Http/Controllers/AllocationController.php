<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Validator;

class AllocationController extends Controller
{

    public function __construct() {

        $this->middleware('auth:sanctum');

    }


   
    public function index()
    {
         $allocations = Allocation::orderby('id','desc')->select(
             'id',
             'project_id',
             'user_ids',
             'manager_ids',
             'guard_ids',
             'created_at'
             )->get();
        foreach($allocations as $aa){

            $aa->users =  $aa->user_ids ? User::whereIn('id', $aa->user_ids)->pluck('name') : [];

            $aa->managers =  $aa->manager_ids ? User::whereIn('id', $aa->manager_ids)->pluck('name') : [];

            $aa->guards =  $aa->guard_ids ? User::whereIn('id', $aa->guard_ids)->pluck('name') : [];
            
        }

        return ['success' => true, 'data' => $allocations];
    }
    

    public function getAssignedMembers($id = null){

            $allocations = $id 

            ? Allocation::without('project')->where('id','!=',$id)->select('user_ids','guard_ids')->get()

            : Allocation::without('project')->select('user_ids','guard_ids')->get();

            $user_ids = [];

            $guard_ids = [];

            foreach($allocations as $aa){

                $user_ids[] = $aa->user_ids;
                $guard_ids[] = $aa->guard_ids;

            }

            return [ 
                'users' => $this->getFreeMembers($user_ids,5), 
                'guards' =>  $this->getFreeMembers($guard_ids,7)    
            ];

    }


    public function getFreeMembers($ids,$role_id)
    {
        return User::whereNotIn('id', Arr::flatten($ids))->where('role_id',$role_id)->select('id','name')->get();
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [ 'project_id' => 'required' ]);

        if ($validator->fails()) {

            return response()->json([ 'success' => false, 'errors' => $validator->errors() ]); 
        
        }

        $created = Allocation::create($this->fields($request));

        list($status,$data) = $created ? [ true , $this->show($created->id) ] : [ false , ''];

        return ['success' => $status,'data' => $data];

    }

    public function show($id)
    {
        $allocation = Allocation::where('id',$id)->select(
            'id',
            'project_id',
            'user_ids',
            'manager_ids',
            'guard_ids',
            'created_at'
            )->first();

        $allocation->users =  $allocation->user_ids ? User::whereIn('id', $allocation->user_ids)->where('role_id',5)->pluck('name') : [];
        $allocation->managers =  $allocation->manager_ids ? User::whereIn('id', $allocation->manager_ids)->where('role_id',4)->pluck('name') : [];
        $allocation->guards =  $allocation->guard_ids ? User::whereIn('id', $allocation->guard_ids)->where('role_id',7)->pluck('name') : [];
            
        return $allocation;
    }

    public function update(Request $request, $id)
    {

        $updated = Allocation::where('id',$id)->update($this->fields($request));
            
        list($status,$data) = $updated ? [ true , $this->show($id) ] : [ false , ''];

        return ['success' => $status,'data' => $data];
    }

    public function destroy($id)
    {
        
        return Allocation::destroy($id)

        ? ['response_status' => true, 'message'=> 'Record has been deleted'] 

        : ['response_status' => false, 'message' => 'Record has not been deleted']; 

    }

    public function fields($request){

        return [
            'project_id'=>$request->project_id,
            'user_ids'=> $request->user_ids,
            'guard_ids'=> $request->guard_ids,
            'manager_ids' => $request->manager_ids
        ];
    }

}
