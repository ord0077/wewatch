<?php

namespace App\Http\Controllers;

use App\Models\Covid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class CovidController extends Controller
{

    public function __construct()
	{
	    $this->middleware('auth:sanctum');
    }

    public function store(Request $request)
    {
        try {

        $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'project_id' => 'required',
                'temperature' => 'required',
                'staff_name' => 'required',
                'company' => 'required',
                'image' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
                ]);
        }

        $fields = array(
            'user_id'=>$request->user_id,
            'temperature'=>$request->temperature,
            'staff_name'=>$request->staff_name,
            'company'=>$request->company,
            'project_id' => $request->project_id,
            'remarks'=>$request->remarks,
            'image'=>   ''
        );

            $type = explode(",", $request->image);
            $filename = 'attach_'.uniqid().'.'.$type[0] ?? '';
            if (!file_exists(public_path('uploads/covid/'))) {
                mkdir(public_path('uploads/covid/'), 0777, true);
            }
            $ifp = fopen( public_path('uploads/covid/'.$filename), 'wb' );
            fwrite( $ifp, base64_decode($type[1]));
            fclose( $ifp );
            $fields['image'] = asset('uploads/covid/'.$filename);


        $covid = Covid::create($fields);

        list($status,$data) = $covid ? [ true , Covid::find($covid->id) ] : [ false , ''];
        return ['success' => $status,'data' => $data];


        } catch (Exception $e) {

             return response()->json($e->errorInfo[2] ?? 'unknown error');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Covid  $covid
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Covid::find($id);
    }

    public function covid_by_project($id,Request $req)
    {
          return Covid::where('project_id', $id)->paginate($req->per_page);
    }


    public function update(Request $request, $id)
    {
        try {

        $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'project_id' => 'required',
                'temperature' => 'required',
                'staff_name' => 'required',
                'company' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
                ]);
        }

        $fields = array(
            'user_id'=>$request->user_id,
            'temperature'=>$request->temperature,
            'staff_name'=>$request->staff_name,
            'company'=>$request->company,
            'project_id' => $request->project_id,
            'remarks'=>$request->remarks,
        );
        if(!empty($request->image))
        {
            $type = explode(",", $request->image);
            $filename = 'attach_'.uniqid().'.'.$type[0] ?? '';
            if (!file_exists(public_path('uploads/covid/'))) {
                mkdir(public_path('uploads/covid/'), 0777, true);
            }
            $ifp = fopen( public_path('uploads/covid/'.$filename), 'wb' );
            fwrite( $ifp, base64_decode($type[1]));
            fclose( $ifp );
            $fields['image'] = asset('uploads/covid/'.$filename);
        }

        $covid = Covid::where('id', $id)->update($fields);

        list($status,$data) = $covid ? [ true , Covid::find($id) ] : [ false , ''];
        return ['success' => $status,'data' => $data];


        } catch (Exception $e) {

             return response()->json($e->errorInfo[2] ?? 'unknown error');
        }


    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Covid  $covid
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $find = Covid::find($id);
        return $find->delete() ? [ 'response_status' => true, 'message' => 'Record has been deleted' ] : [ 'response_status' => false, 'message' => 'Record cannot delete' ];
    }
}
