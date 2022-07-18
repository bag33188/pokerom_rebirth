<?php

namespace App\Enums;

enum DisplayStateEnum: string
{
    /** ui-state : show (`open`) */
    case SHOW = 'open';
    /** ui-state : hide (`!open`) */
    case HIDE = '!open';
}
