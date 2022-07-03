<?php

namespace App\Http\Controllers\www;

use App\Http\Controllers\Controller as ViewController;

class HomeController extends ViewController
{
    public function index()
    {
        $username = auth()->user()->name;
        return view('dashboard', ['username' => $username]);
    }
}
