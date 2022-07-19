<?php

namespace App\Enums;

enum FileContentTypeEnum: string
{
    /** binary stream where file subtype is unknown or not officially defined in spec */
    case OCTET_STREAM = "application/octet-stream";
    /** plain text encoding */
    case PLAIN_TEXT = "text/plain";
}
