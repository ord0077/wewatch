<?php

namespace App\Http\Controllers;

use App\Models\DailyVisitorsRegister as DVR;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class DailyVisitorsRegisterController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:sanctum');

    }

  
    public function index()
    {
        return DVR::all();
    }

  
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[

            'user_id' => 'required',
            'project_id' => 'required',
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
            'project_id' => $request->project_id,
            'company_name' => $request->company_name,
            'driver_contact' => $request->driver_contact,
            'visit_reason' => $request->visit_reason,
            'car_attachment' => $request->car_attachment,
            'id_attachment' =>$request->id_attachment

            // 'car_attachment' => $this->save_attachments($request,'car_attachment'),
            // 'id_attachment' => $this->save_attachments($request,'id_attachment') 

        );

        

        if($request->hasFile('car_attachment')){
            $attach = $request->car_attachment;

            $type = explode(",", $attach);
            $filename = 'attach_'.uniqid().'.'.$type[0] ?? '';
            
            $ifp = fopen( public_path('uploads/dailyvisitorsregister/'.$filename), 'wb' ); 
            fwrite( $ifp, base64_decode($type[1]));
            fclose( $ifp );
            $fields['car_attachment'] = asset('uploads/dailyvisitorsregister/'.$filename); 

        }   
        
        if($request->hasFile('id_attachment')){
            $attach = $request->car_attachment;

            $type = explode(",", $attach);
            $filename = 'attach_'.uniqid().'.'.$type[0] ?? '';
            
            $ifp = fopen( public_path('uploads/dailyvisitorsregister/'.$filename), 'wb' ); 
            fwrite( $ifp, base64_decode($type[1]));
            fclose( $ifp );
            $fields['id_attachment'] = asset('uploads/dailyvisitorsregister/'.$filename); 

        }   
        // dd($fields);


        $success = DVR::create($fields);

            return [ 'success' => true, 'data' => DVR::find($success->id) ];

        }

  
    public function show($id)
    {
        return DVR::find($id);
    }

   
    public function destroy($id)
    {
       
       return DVR::find($id)->delete() 
       ? ['response_status' => true, 'message' => "Record has been deleted"] 
       : ['response_status' => false, 'message' => "Record has been deleted" ];
    }



    public function save_attachments($request,$file)
    {

         
        if($request->hasFile($file))
        {
            

           $attach= $request->$file;
          

           $type = explode(",", $attach);
           $filename = 'attach_'.uniqid().'.'.$type[0] ?? '';
           
           $ifp = fopen( public_path('uploads/dailyvisitorsregister/'.$filename), 'wb' ); 
           fwrite( $ifp, base64_decode($type[1]));
           fclose( $ifp );
        //    $fields['image'] = asset('uploads/covid/'.$filename); 
           $fields[$file] = asset('uploads/dailyvisitorsregister/'.$filename);

           return $img;

        }
    }

  
}
