<?php

namespace App\Enums;

enum DatabaseCascadeOptionsEnum: string
{
    case NO_ACTION = 'NO ACTION';
    case DELETE = 'DELETE';
    case SET_NULL = 'SET NULL';
    case RESTRICT = 'RESTRICT';
}
