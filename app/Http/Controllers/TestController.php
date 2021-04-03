<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
class TestController extends Controller
{
    // public function __construct()
	// {
	// 	$this->middleware('auth:sanctum');
	// }
    public function index()
    {
       
            dump(['post_max_size'=> ini_get('post_max_size')]);
            dump(['upload_max_filesize'=> ini_get('upload_max_filesize')]);
            dump(ini_get_all());
            // return ['data' => $request->all()];
    }

    public function store(Request $request)
    {
        $arr = [
            'project_id' => $request->project_id,
            'user_ids' => $request->user_ids,
            'manager_ids' => $request->manager_ids,
        ];
        // echo '<pre>';
        print_r($arr);

        Test::create([
            'project_id' => $request->project_id,
            'user_id' => $request->user_ids,
            'manager_id' => $request->manager_ids,
        ]);
        return ['data' => $request->all()];
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
        //
    }

    public function send_email(Request $request){

        Mail::to('aizaz@gmail.com')->send(new TestMail("ok"));
    }
}
