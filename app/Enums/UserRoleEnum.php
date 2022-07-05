<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case ADMIN = 'admin';
    case GUEST = 'guest';
    case USER = 'user';
}
