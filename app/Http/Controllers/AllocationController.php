<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\User;
use Illuminate\Http\Request;

use Validator;

class AllocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allocations = Allocation::orderby('id','desc')->select('id','project_id','user_ids','manager_ids','created_at')->get();
        foreach($allocations as $aa){

            $aa->users =  $aa->user_ids ? User::whereIn('id', $aa->user_ids)->pluck('name') : [];
            $aa->managers =  $aa->manager_ids ? User::whereIn('id', $aa->manager_ids)->pluck('name') : [];
            
        }

        return ['success' => true, 'data' => $allocations];
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
            
            'project_id' => 'required',
            'user_ids' => 'required',
            'manager_ids' => 'required',       
        
            ]);
        if ($validator->fails()) {
            return response()->json([ 
                'success' => false, 
                'errors' => $validator->errors() 
                ]); 
        }

        $fields = array(
            'project_id'=>$request->project_id,
            'user_ids'=> $request->user_ids,
            'manager_ids' => $request->manager_ids
        );

        $created = Allocation::create($fields);

        $allocation = Allocation::where('id',$created->id)->select('id','project_id','user_ids','manager_ids','created_at')->first();
        $allocation->users =  $allocation->user_ids ? User::whereIn('id', $request->user_ids)->pluck('name') : [];
        $allocation->managers =  $allocation->manager_ids ? User::whereIn('id', $request->manager_ids)->pluck('name') : [];
            
        list($status,$data) = $created ? [ true , $allocation ] : [ false , ''];
        return ['success' => $status,'data' => $allocation];

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $allocation = Allocation::where('id',$id)->select('id','project_id','user_ids','manager_ids','created_at')->first();
        $allocation->users =  $allocation->user_ids ? User::whereIn('id', $allocation->user_ids)->pluck('name') : [];
        $allocation->managers =  $allocation->manager_ids ? User::whereIn('id', $allocation->manager_ids)->pluck('name') : [];
            
        return $allocation;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Allocation $allocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        return Allocation::destroy($id)
            ? ['response_status' => true, 'message'=> 'Record has been deleted'] 
            : ['response_status' => false, 'message' => 'Record has not been deleted']; 
    }
}
