<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * view the Edit form for the user data
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_profile()
    {
        $user = Auth::user();
        return view('users.edit_profile',compact('user'));
    }

    
    /**
     * update user's data
     *
     * @return \Illuminate\Http\Response
     */
    public function update_profile(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'national_id' => 'required|unique:users,national_id,'.Auth::id(),
            'gender' => 'required',
        ]);
// dd('f');
        $user = Auth::user();
        $user->fill($data);
        $user->save();

        return view('users.edit_profile',compact('user'));
    }
}
