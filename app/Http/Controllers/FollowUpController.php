<?php

namespace App\Http\Controllers;

use App\FollowUp;
use Illuminate\Http\Request;

class FollowUpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // return $request->all();
            $request->validate([
                'lead_id'    =>  'required',
                'text'    =>  'required',
                'date_at'    =>  'required',
            ]);        
    
            $follow_up = FollowUp::create($request->all());
            return response()->json(["follow_up" => $follow_up], 201);
            
        } catch(\Illuminate\Database\QueryException $e) {
            return response()->json([
                    'errors' => $e,
                ], 422);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FollowUp  $followUp
     * @return \Illuminate\Http\Response
     */
    public function show(FollowUp $followUp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FollowUp  $followUp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FollowUp $followUp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FollowUp  $followUp
     * @return \Illuminate\Http\Response
     */
    public function destroy(FollowUp $followUp)
    {
        //
    }
}
