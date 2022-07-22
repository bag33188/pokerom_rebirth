<?php

namespace App\Http\Controllers\WWW;

use App\Http\Controllers\Controller as ViewController;
use Config;
use Illuminate\Http\Response as ResponseView;
use Response;

class WelcomeController extends ViewController
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function __invoke(): ResponseView
    {
        return Response::view('welcome', [
            'page_title' => $this->makePageTitleValue()
        ]);
    }

    private static function getAppName(): string
    {
        return Config::get('app.name');
    }

    private function makePageTitleValue(): string
    {
        return str_replace('Poke', POKE_EACUTE, self::getAppName());
    }
}
