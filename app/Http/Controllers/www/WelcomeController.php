<?php

namespace App\Http\Controllers\www;

use App\Http\Controllers\Controller as ViewController;
use Config;

class WelcomeController extends ViewController
{
    // todo: change to renderSplash in future??
    public function renderIndex()
    {
        $pageTitle = Config::get('app.name');
        return view('welcome', ['title' => $pageTitle]);
    }
}
