<?php

namespace App\Http\Controllers\www;

use App\Http\Controllers\Controller as ViewController;
use Illuminate\Http\Request;

class WelcomeController extends ViewController
{
    public function index() {
        return view('welcome');
    }
}
