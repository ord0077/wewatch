<?php

namespace App\Http\Controllers;

use App\Models\HseReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HSEController extends Controller
{
    public function __construct(){
        $this->middleware('auth:sanctum');
    }
    public function index()
    {
        return HseReport::orderBy('id', 'DESC')->get();
    }

    public function store(Request $request)
    {
        $validator =Validator::make($request->all(),[
            
            'user_id' => 'required',
            'project_id' => 'required',
            'name' => 'required',
            'date' => 'required',
            'contact_no' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()

            ]);

        }

       $fields =array(
            'user_id' => $request->user_id,
            'project_id' => $request->project_id,
            'name' => $request->name,
            'date' => $request->date,
            'contact_no' => $request->contact_no,
            'weather_conditions' => $request->weather_conditions,
            'work_timings' => $request->work_timings,
            'workforce_size' => $request->workforce_size,
            'subcontractors' => $request->subcontractors,
            'progress_activity' => $request->progress_activity,
            'session_attendees' => $request->session_attendees,
            'attachment' => '',
            'red_flag' => $request->red_flag,
            'incidents' => $request->incidents,
            'incidents_remarks' => $request->incidents_remarks,
            'near_misses' => $request->near_misses,
            'near_misses_remarks' => $request->near_misses_remarks,
            'violations_noncompliance' => $request->violations_noncompliance,
            'violations_noncompliance_remarks' => $request->violations_noncompliance_remarks,
            'first_aid' => $request->first_aid,
            'first_aid_remarks' => $request->first_aid_remarks,
            'environment_incidents' => $request->environment_incidents,
            'environment_incidents_remarks' => $request->environment_incidents_remarks,
            'housekeeping' => $request->housekeeping,
            'housekeeping_remarks' => $request->housekeeping_remarks,
            'safety_signs' => $request->safety_signs,
            'safety_signs_remarks' => $request->safety_signs_remarks,
            'work_permit' => $request->work_permit,
            'work_permit_remarks' => $request->work_permit_remarks,
            'drums_cylinders' => $request->drums_cylinders,
            'drums_cylinders_remarks' => $request->drums_cylinders_remarks,
            'safety_concerns' => $request->safety_concerns,
            'safety_concerns_remarks' => $request->safety_concerns_remarks,
            'covid_face_mask' => $request->covid_face_mask,
            'covid_face_mask_remarks' => $request->covid_face_mask_remarks,
            'covid_respiratory_hygiene' => $request->covid_respiratory_hygiene,
            'covid_respiratory_hygiene_remarks' => $request->covid_respiratory_hygiene_remarks,
            'social_distancing' => $request->social_distancing,
            'social_distancing_remarks' => $request->social_distancing_remarks,
            'cleaning_disinfecting' => $request->cleaning_disinfecting,
            'cleaning_disinfecting_remarks' => $request->cleaning_disinfecting_remarks
        );

        if(!empty($request->attachment))
            {
                $type = explode(",", $request->attachment);
                $filename = 'attach_'.uniqid().'.'.$type[0] ?? '';
                if (!file_exists(public_path('uploads/hsereport/'))) {
                    mkdir(public_path('uploads/hsereport/'), 0777, true);
                }
                $ifp = fopen( public_path('uploads/hsereport/'.$filename), 'wb' ); 
                fwrite( $ifp, base64_decode($type[1]));
                fclose( $ifp );
                $fields['attachment'] = asset('uploads/hsereport/'.$filename);
            }   

        $success = HseReport::create($fields);

       list($status,$data) = $success ? [true, HseReport::find($success->id)] : [false, ''];
       return ['success' => $status,'data' => $data];
    }

    public function show($id)
    {
        return  HseReport::find($id);
    }

    public function destroy($id)
    {
        $find = HseReport::find($id); 
        return $find->delete() 
        ? ['response_status' => true, 'message' => "Record has been deleted"] 
        : ['response_status' => false, 'message' => "Record has been deleted" ];
    }
}
