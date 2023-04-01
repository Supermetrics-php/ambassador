<?php

namespace Supermetrics\Ambassador\Enums;

use Supermetrics\Ambassador\Traits\EnumConverterTrait;

enum ErrorMessages: string
{
    use EnumConverterTrait;
    case INVALID_STORAGE = 'Invalid Storage.';
    case INVALID_ENTITY_TYPE = 'Invalid Entity Type.';
    case INVALID_DATA = 'Provided Data Is Invalid.';
    case STORAGE_CONNECTION_FAILED = 'Database Connection Failed.';
}
