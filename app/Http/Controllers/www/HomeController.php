<?php

namespace App\Http\Controllers\www;

use App\Http\Controllers\Controller as ViewController;
use Illuminate\Http\Request;

class HomeController extends ViewController
{
    public function index() {
        return view('dashboard');
    }
}
