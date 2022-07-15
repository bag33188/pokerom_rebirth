<?php

namespace App\Enums;

enum DisplayStateEnum: string
{
    /** ui-state : show */
    case SHOW = 'open';
    /** ui-state : hide */
    case HIDE = '!open';
}
