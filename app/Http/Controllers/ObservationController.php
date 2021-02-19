<?php

namespace App\Http\Controllers;

use App\Models\Observation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ObservationController extends Controller
{

        public function __construct()
        {
            $this->middleware('auth:sanctum');
        }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return Observation::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(),[
                    
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Observation  $observation
     * @return \Illuminate\Http\Response
     */
    public function show(Observation $observation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Observation  $observation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Observation $observation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Observation  $observation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Observation $observation)
    {
        //
    }
}
