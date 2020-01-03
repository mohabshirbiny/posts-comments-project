<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Post;
use App\User;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // get all the posts made by the users with the same gender of the current user
        $posts = Post::whereHas('user', function($q)
        {
            $q->where('gender', '=', Auth::user()->gender );

        })->latest()->get();

        return view('home' , compact("posts"));
    }


    
}
