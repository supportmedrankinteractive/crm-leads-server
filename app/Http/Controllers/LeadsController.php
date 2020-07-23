<?php

namespace App\Http\Controllers;

use App\Lead;
use Illuminate\Http\Request;

class LeadsController extends Controller
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
        // return User::with('profile.leads')->where('is_admin', '!=', 1)->get();
        return auth()->user()->profile->leads;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
            // return json_decode($request->callrailResponse);
            $leads = [];
            // foreach(json_decode($request->callrailResponse)->chunk(4) as $chunk) {
            //     $leads = $chunk;
            // }
            // return $leads;
            // make the POST request object as json except for profile_id, platform_id and status
            $content = json_encode($request->except(['profile_id', 'platform_id', 'status']));

            // add the as part of the request object the converted json field
            $request->request->add(['contents' => json_decode($content)]);
            
            // return json_decode($request->callrailResponse);
            $request->validate([
                'profile_id'    =>  'required',
                'platform_id'    =>  'required|integer|min:0',
                // 'content'   =>  'required|json',
                'status'    =>  'required',
            ]);

            
            foreach(json_decode($request->callrailResponse) as $content) {
                $lead = new Lead();
                // $profile = Profile::
                $lead->profile_id = $request->profile_id;
                $lead->platform_id = $request->platform_id;
                $lead->status = $request->status;
                $lead->content = json_encode($content);
                $lead->save();
                array_push($leads, json_encode($content));
            }

            return response()->json(["leads" => $leads], 201);

        } catch(\Illuminate\Database\QueryException $e) {
            return response()->json([
                    'errors' => $e,
                ], 422);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
