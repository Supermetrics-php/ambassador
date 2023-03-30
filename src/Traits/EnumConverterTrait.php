<?php

namespace Supermetrics\Ambassador\Traits;

trait EnumConverterTrait
{
    /**
     * @return array
     */
    public static function getAllValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}