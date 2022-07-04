<?php

namespace App\Enums;

enum RomFileTypesEnum: string
{
    // (generic) binary stream where file type is unknown
    case OCTET_STREAM = "application/octet-stream";
    // unofficial mime type (custom http header)
    case X_BINARY = "application/x-binary";
}
