<?php

namespace App\Http\Controllers\Webhooks;

use App\Lead;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CallrailController extends Controller
{
    /**
     * Add leads to profile.
     *
     * @param  int  $id
     * @return View
     */
    public function __invoke( $profile, Request $request )
    {
        try {
            $request->request->add(['profile' => $profile]);
            // make the POST request object as json except for profile_id, platform_id and status
            $content = json_encode($request->except(['profile']));
    
            // add the as part of the request object the converted json field
            $request->request->add(['contents' => json_decode($content)]);
            
            // return json_decode($request->callrailResponse);
            // $request->validate([
            //     'profile'    =>  'required',
            // ]);
    
            $status = ['New Patient', 'Existing Patient'];
            $randStatus = array_rand($status);
    
            $lead = new Lead();
            $lead->profile_id = $request->profile;
            $lead->platform_id = 1;
            $lead->status = $randStatus = rand(0, 1) ? 'New Patient' : 'Existing Patient';
            $lead->content = json_encode($content);
            $lead->save();
    
            return response()->json(["lead" => $lead], 201); 
        } catch(\Illuminate\Database\QueryException $e) {
            mail('valencia.dominic.29@gmail.com', 'Callrail Webhook Error', $e);
            return response()->json([
                'errors' => $e,
            ], 422);
        }
            
    }
}