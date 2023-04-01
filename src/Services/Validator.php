<?php

namespace Supermetrics\Ambassador\Services;

use Supermetrics\Ambassador\Enums\EntityTypes;

class Validator
{
    private const BASE_NAMESPACE = "Supermetrics\Ambassador\Rules\\";
    /**
     * @param EntityTypes $type
     * @param array       $payload
     *
     * @return array
     */
    public function handle(EntityTypes $type, array $payload): array
    {
        $validationClass = self::BASE_NAMESPACE . ucfirst($type->value);

        return (new $validationClass())->doValidate($payload);
    }
}
