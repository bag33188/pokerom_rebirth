<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    /** administrator */
    case ADMIN = 'admin';
    /** default user */
    case USER = 'user';
    /** guest user */
    case GUEST = 'guest';
}
