<?php

namespace App\Enums;

enum FileContentTypeEnum: string
{
    /** (generic) binary stream where file type is unknown */
    case OCTET_STREAM = "application/octet-stream";
    /** unofficial mime type (custom http header) */
    case X_BINARY = "application/x-binary";
}
