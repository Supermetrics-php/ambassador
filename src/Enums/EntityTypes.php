<?php

namespace Supermetrics\Ambassador\Enums;
use Supermetrics\Ambassador\Traits\EnumConverterTrait;

enum EntityTypes: string
{
    use EnumConverterTrait;
    case USERS = 'users';
}
