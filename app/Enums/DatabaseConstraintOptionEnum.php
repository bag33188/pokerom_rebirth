<?php

namespace App\Enums;

enum DatabaseConstraintOptionEnum: string
{
    case NO_ACTION = 'NO ACTION';
    case CASCADE = 'CASCADE';
    case SET_NULL = 'SET NULL';
    case RESTRICT = 'RESTRICT';
}
