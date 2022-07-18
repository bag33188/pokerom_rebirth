<?php

namespace App\Http\Controllers\WWW;

use App\Http\Controllers\Controller as ViewController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class WelcomeController extends ViewController
{
    public function index(): Application|Factory|View
    {
        return view('welcome');
    }
}
