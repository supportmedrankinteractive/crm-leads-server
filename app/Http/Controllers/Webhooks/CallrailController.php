<?php

namespace App\Http\Controllers\Webhooks;

use App\Lead;
use Illuminate\Http\Request;
use App\Events\CallRailWebHookMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

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
            // $lead->status = $randStatus = rand(0, 1) ? 'New Patient' : 'Existing Patient';
            $lead->status = $content['tag'];
            $lead->start_time =  Carbon::parse($content['start_time'])->format('Y-m-d H:i:s');
            $lead->content = $content;
            $lead->save();
            Log::info('Lead added from webhook: ' . $lead);
            // event(new CallRailWebHookMail($lead));
            return response()->json(["lead" => $lead], 201); 
        } catch(\Illuminate\Database\QueryException $e) {
            // event(new CallRailWebHookMail($e));
            Log::info('Lead creation failed');
            return response()->json([
                'errors' => $e,
            ], 422);
        }
            
    }
}
