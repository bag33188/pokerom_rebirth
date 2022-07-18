<?php

namespace App\Http\Controllers\WWW;

use App\Http\Controllers\Controller as ViewController;

class WelcomeController extends ViewController
{
    public function index()
    {
        return view('welcome');
    }
}
