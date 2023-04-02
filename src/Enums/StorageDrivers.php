<?php

namespace Supermetrics\Ambassador\Enums;

use Supermetrics\Ambassador\Traits\EnumConverterTrait;

enum StorageDrivers: string
{
    use EnumConverterTrait;
    case REDIS = 'redis';
    case MONGO = 'mongo';
    case FILE = 'file';
    case MYSQL = 'mysql';
}
