<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
class RoleController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth:sanctum');
	}
    public function index()
    {
        return Auth::user()->role_id == 1 ? Role::all() : Role::wherenotIN('id',[1])->get();
    }

    public function store(Request $request)
    {
        //
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
}
