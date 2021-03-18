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
         return Project::orderBy('id','desc')->get();
    }

    public function projectbyuserid($id)
    {
         return Project::where('user_id',$id)->orderBy('id','desc')->get();
    }
    

    public function store(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'project_name' => 'required',
            'location' => 'required',
            'zones' => 'required'   
        ]);

        if(!$request->hasFile('project_logo')){
            return [
                'errors' => $validator->errors()->add('project_logo', 'project logo field is required')
            ]; 
            
        }
            if ($validator->fails()) {
                return [ 'success' => false, 'errors' => $validator->errors() 
                ]; 
            }

        $fields = [
            'user_id'=>$request->user_id,
            'project_name'=>$request->project_name,
            'location'=>$request->location,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date
        ];


        if($request->hasFile('project_logo')){
            
            $img =  $request->project_logo->getClientOriginalName();
            
            $request->project_logo->move(public_path('uploads/logos/'),$img);
            
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

    public function update_project_logo(Request $request,$id)
    {
        if(!$request->hasFile('project_logo')){
            
            return [
                    'success' => false, 
                    'errors' => [ 'project_logo' => [ 'project logo field is required' ] ]
                ];
        }     
        if($request->hasFile('project_logo')){
            
            $img =  $request->project_logo->getClientOriginalName();
            
            $request->project_logo->move(public_path('uploads/logos/'),$img);
            
            $project = Project::where('id',$id)->update([ 'project_logo'=>asset('uploads/logos/' . $img) ]);
            list($status,$data) = $project ? [ true , Project::find($id) ] : [ false , ''];
            return ['success' => $status,'data' => $data];

        } 

    }

        public function update(Request $request,$id)
        {
      
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'project_name' => 'required',
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
                'location'=>$request->location,
                'start_date'=>$request->start_date,
                'end_date'=>$request->end_date
            );
            // return ['success' => true,'data' => $request->all()];

            
           
            $project = Project::where('id',$id)->update($fields);
            
            Zone::where('project_id',$id)->delete();

            for($i = 1; $i<= $request->zones; $i++){
                
                Zone::where('project_id' ,$id)->create([
                'project_id'=>$id, 'zone_name'=>'Zone '.$i
                ]);

            }
            list($status,$data) = $project ? [ true , Project::find($id) ] : [ false , ''];
            return ['success' => $status,'data' => $data];
        
    }


    public function destroy($id)
    {
        $find = Project::find($id);
        Zone::where('project_id',$id)->delete();
        
        return $find->delete() ? [ 'response_status' => true, 'message' => 'Project has been deleted' ] : [ 'response_status' => false, 'message' => 'Project cannot delete' ];
    }
}
