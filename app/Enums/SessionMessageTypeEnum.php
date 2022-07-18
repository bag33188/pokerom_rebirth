<?php

namespace App\Enums;

enum SessionMessageTypeEnum
{
    /** session error message */
    case ERROR;
    /** session success message */
    case SUCCESS;
}
