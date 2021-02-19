<?php

namespace App\Http\Controllers;

use App\Models\DailyVisitorsRegister as DVR;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class DailyVisitorsRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');

    }

  
    public function index()
    {
        return DVR::all();
    }

  
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[

            'user_id' => 'required',
            'company_name' => 'required',
            'driver_contact' => 'required',
            'visit_reason' => 'required',
            'car_attachment' => 'required',
            'id_attachment' => 'required'

        ]);
        if($validator->fails()){
          return  ['success' => false,'error' =>  $validator->errors()];
        }

       $fields = array(

            'user_id' => $request->user_id,
            'company_name' => $request->company_name,
            'driver_contact' => $request->driver_contact,
            'visit_reason' => $request->visit_reason,
            'car_attachment' => $this->save_attachments($request,'car_attachment'),
            'id_attachment' => $this->save_attachments($request,'id_attachment')

        );
        $success = DVR::create($fields);

            return [ 'success' => true, 'data' => DVR::find($success->id) ];

        }

  
    public function show($id)
    {
        return DVR::find($id);
    }

   
    public function destroy($id)
    {
       $find = DVR::find($id);
       return $find->delete() 
       ? 
       ['response_status' => true, 'message' => "Record has been deleted"] 
       : ['response_status' => false, 'message' => "Record has been deleted" ];
    }



    public function save_attachments($request,$file)
    {

         
        if($request->hasFile($file))
        {
            

           $attach= $request->$file;
           $img = $attach->getClientOriginalName();
       
           $attach->move(public_path('uploads/dailyvisitorsregister/'),$img);
           $fields[$file] = asset('uploads/dailyvisitorsregister/'.$img);

           return $img;

        }
    }

  
}
