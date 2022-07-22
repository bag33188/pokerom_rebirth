<?php

namespace App\Http\Controllers\WWW;

use App\Http\Controllers\Controller as ViewController;
use App\Models\User;
use Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class HomeController extends ViewController
{
    public const HOME_PAGE_NAME = 'Dashboard';

    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function __invoke(): View|Application|Factory
    {
        return view('dashboard', [
            'username' => strtolower($this->getUsername()),
            'home_page_name' => __(self::HOME_PAGE_NAME)
        ]);
    }

    private function getUsername(): string
    {
        /** @var ?User $currentUser */
        $currentUser = $this->getCurrentUser();

        return $this->userIsInSession()
            ? $currentUser->name
            : 'Guest User';
    }

    private function getCurrentUser(): Authenticatable|User|null
    {
        return Auth::guard('web')->user();
    }

    private function userIsInSession(): bool
    {
        $user = $this->getCurrentUser();
        return !empty($user);
    }
}
