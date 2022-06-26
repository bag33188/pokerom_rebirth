<?php

namespace App\Http\Controllers\www;

use App\Http\Controllers\Controller as ViewController;

class HomeController extends ViewController
{
    private const PAGE_HEADING = 'Dashboard';

    public function index()
    {
        return view('dashboard', ['pageHeading' => self::PAGE_HEADING]);
    }
}
