<?php

namespace App\Http\Controllers;

use App\Lead;
use Carbon\Carbon;
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
        // return $date_from = Carbon::now()->subDays(300)->format('yy-m-d');
        // return Carbon::parse('last year')->startOfYear()->format('Y-m-d H:i:s');//Carbon::now()->format('Y-m-d');
        if(request()->date == 'today') {
            // return 2;
            $date_from = Carbon::today();
            $date_to = Carbon::tomorrow();
        } else if(request()->date == 'yesterday') {
            // return 2;
            $date_from = Carbon::yesterday();
            $date_to = Carbon::today();
        } else if(request()->date == 'last_7_days') {
            // return 2;
            $date_from = Carbon::now()->subDays(7);
            $date_to = Carbon::tomorrow();
        } else if(request()->date == 'last_30_days') {
            // return 2;
            $date_from = Carbon::now()->subDays(30);
            $date_to = Carbon::tomorrow();
        } else if(request()->date == 'this_month') {
            // return 2;
            $date_from = Carbon::now()->startOfMonth();
            $date_to = Carbon::now()->endOfMonth();
        } else if(request()->date == 'last_month') {
            // return 2;
            $date_from = Carbon::parse('last month')->startOfMonth();
            $date_to = Carbon::parse('last month')->endOfMonth();
        } else if(request()->date == 'this_year') {
            // return 2;
            $date_from = Carbon::parse('this year')->startOfYear();
            $date_to = Carbon::parse('this year')->endOfYear();
        } else if(request()->date == 'last_year') {
            // return 2;
            $date_from = Carbon::parse('last year')->startOfYear();
            $date_to = Carbon::parse('last year')->endOfYear();
        } else if(request()->date == 'all_time') {
            // return 2;
            $date_from = Carbon::now()->subDays(300);
            $date_to = Carbon::now();
        }
        // return request()->date.' - '.$date_from->format('Y-m-d H:i:s') .' - '.$date_to->format('Y-m-d H:i:s');
        // return User::with('profile.leads')->where('is_admin', '!=', 1)->get();
        // $leads = auth()->user()->profile->leads;

        $leads = Lead::where('profile_id', auth()->user()->profile->id)
            ->whereBetween('start_time', [
                $date_from->format('Y-m-d H:i:s'),
                $date_to->format('Y-m-d H:i:s')
            ])
            ->get();

        return $leads;
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

            $status = ['New Patient', 'Existing Patient'];
            $randStatus = array_rand($status);

            foreach(json_decode($request->callrailResponse) as $content) {
                $lead = new Lead();
                // $profile = Profile::
                $lead->profile_id = $request->profile_id;
                $lead->platform_id = $request->platform_id;
                $lead->status = $randStatus = rand(0, 1) ? 'New Patient' : 'Existing Patient';
                // $lead->status = $content->tags[0]->name;
                $lead->start_time =  Carbon::parse($content->start_time)->format('Y-m-d H:i:s');
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
        // temporary method for updating lead's status. Maybe create a new controller?
        $lead = Lead::find($id);
        $lead->status = $request->status;
        $lead->save();

        return $lead;
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
