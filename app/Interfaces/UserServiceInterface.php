<?php

namespace App\Interfaces;

interface UserServiceInterface {
    public function authenticateUserAgainstCreds(string $requestPassword);
    public function logoutCurrentUser();
    public function registerUserToken();
    public function deleteUserAndTokens();
}
