<?php

namespace App\Enums;

enum ImageTypeEnum: string
{
    /** PORTABLE NETWORK GRAPHICS */
    case IMG_PNG = "image/png";
    /** JOINT PHOTOGRAPHIC EXPERTS GROUP */
    case IMG_JPG = "image/jpeg";
    /** TAGGED IMAGE FORMAT */
    case IMG_TFF = "image/tiff";
    /** GRAPHICS INTERCHANGE FORMAT */
    case IMG_GIF = "image/gif";
    /** ICON FORMAT */
    case IMG_ICO = "image/vnd.microsoft.icon";
}
