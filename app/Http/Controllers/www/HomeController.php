<?php

namespace App\Http\Controllers\WWW;

use App\Http\Controllers\Controller as ViewController;
use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class HomeController extends ViewController
{
    public const HOME_PAGE_NAME = 'Dashboard';

    public function index(): View|Application|Factory
    {
        $username = Auth::user()->name;

        return view('dashboard', [
            'username' => strtolower($username),
            'home_page_name' => __(self::HOME_PAGE_NAME)
        ]);
    }
}
