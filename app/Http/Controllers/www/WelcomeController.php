<?php

namespace App\Http\Controllers\www;

use App\Http\Controllers\Controller as ViewController;

class WelcomeController extends ViewController
{
    public function index()
    {
        return view('welcome');
    }
}
