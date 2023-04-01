<?php

namespace Supermetrics\Ambassador\Enums;

use Supermetrics\Ambassador\Traits\EnumConverterTrait;

enum StatusCodes: int
{
    use EnumConverterTrait;
    case SUCCESS = 200;
    case INVALID_REQUEST = 400;
    case NOT_FOUND = 404;
    case SERVER_ERROR = 500;
}
