<?php

namespace Supermetrics\Ambassador\Enums;

use Supermetrics\Ambassador\Traits\EnumConverterTrait;

enum Messages: string
{
    use EnumConverterTrait;
    case INVALID_STORAGE = 'Invalid Storage.';
    case INVALID_ENTITY_TYPE = 'Invalid Entity Type.';
    case INVALID_DATA = 'Provided Data Is Invalid.';
    case STORAGE_CONNECTION_FAILED = 'Database Connection Failed.';
    case FILE_IS_UNAVAILABLE = 'File is unavailable.';
    case RECORD_NOT_FOUND = 'Record Not Found.';
    case DATA_SUCCESSFULLY_IMPORTED = 'Data is successfully imported.';
}
