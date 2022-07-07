<?php

namespace App\Http\Controllers\www;

use App\Http\Controllers\Controller as ViewController;
use Auth;

class HomeController extends ViewController
{
    public function index()
    {
        $username = Auth::user()->name;
        return view('dashboard', ['username' => strtolower($username)]);
    }
}
