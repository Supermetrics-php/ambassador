<?php

namespace Supermetrics\Ambassador\Services;

use Supermetrics\Ambassador\Enums\EntityTypes;

final class Validator
{
    private const BASE_NAMESPACE = "Supermetrics\Ambassador\Rules\\";
    /**
     * @param EntityTypes $type
     * @param array       $payload
     *
     * @return array
     * Idea: Always code over a convention. Therefore, class names inside
     * Rules MUST be exactly EntityTypes Names.
     * For instance, Users.php
     */
    public function handle(EntityTypes $type, array $payload): array
    {
        $validationClass = self::BASE_NAMESPACE . ucfirst($type->value);

        return (new $validationClass())->doValidate($payload);
    }
}
