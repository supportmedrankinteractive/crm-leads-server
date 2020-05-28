<?php

namespace App\Http\Controllers;

use Response;
use App\User;
use App\Profile;
use App\Events\NewUserRegistered;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return User::with('profile')->where('is_admin', '!=', 1)->get();
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
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:5',
                'notes' =>    'required'
            ]);
    
            // $request->password = bcrypt($request->password);
    
            // $user = User::create($request->only(['name', 'email', bcrypt('password'), 'notes']));
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->notes = $request->notes;
            $user->is_approved = 1;
            $user->save();
            // $user->profile->company_name = $request->company['name'];
            // $user->profile->callrail = $request->company['id'];            
            // $user->push();
            
            $user->plain_password = $request->password;

            $profile = Profile::firstOrNew(['user_id' => $user->id]);
            $profile->company_name = $request->company['name'];
            $profile->callrail = $request->company['id'];
            $profile->save();
                        
            event(new NewUserRegistered($user));

            return $user;

        } catch(\Illuminate\Database\QueryException $e) {
            return response()->json([
                'errors' => $e,
              ],422);
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
        return User::with('profile')->where('id', $id)->first();
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
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'company' => 'required'
        ]);
        
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->notes = $request->notes;
        $user->is_approved = 1;
        $user->save();

        $profile = Profile::firstOrNew(['user_id' => $user->id]);
        $profile->company_name = $request->company['name'];
        $profile->callrail = $request->company['id'];
        $profile->save();

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $request->user()->tokens()->delete();

        return response('Loggedout', 200);
    }
}
