<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Project;
use App\Models\Zone;
use App\Models\User;
class ProjectController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth:sanctum');
    }
    
    public function index()
    {
         return Project::all();
    }

    public function store(Request $request)
    {
        // return $request->user_id;
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'project_name' => 'required',
            'project_logo' => 'required',
            'location' => 'required',
            'zones' => 'required'   
        ]);
        if ($validator->fails()) {
            return response()->json([ 
                'success' => false, 
                'errors' => $validator->errors() 
                ]); 
        }

        $fields = array(
            'user_id'=>$request->user_id,
            'project_name'=>$request->project_name,
            'project_logo' => $request->project_logo,
            'location'=>$request->location,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date
        );
        
        if($request->hasFile('project_logo')){
            $attach = $request->project_logo;
            $img = $attach->getClientOriginalName();
            $attach->move(public_path('uploads/logos/'),$img);
            $fields['project_logo'] = asset('uploads/logos/' . $img);
        }        
        $project = Project::create($fields);
        $zones = $request->zones;
        for($i = 1; $i<=$zones; $i++){
            $z_fields = array('project_id'=>$project->id, 'zone_name'=>'Zone '.$i);
            $zone = Zone::create($z_fields);
        }
        list($status,$data) = $project ? [ true , Project::find($project->id) ] : [ false , ''];
        return ['success' => $status,'data' => $data];
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $find = Project::find($id);
        return $find->delete() ? [ 'response_status' => true, 'message' => 'Project has been deleted' ] : [ 'response_status' => false, 'message' => 'Project cannot delete' ];
    }
}
