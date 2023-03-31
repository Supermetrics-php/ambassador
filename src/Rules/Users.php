<?php

namespace Supermetrics\Ambassador\Rules;

use Respect\Validation\Validator;
use Supermetrics\Ambassador\Contracts\ValidationInterface;

class Users implements ValidationInterface
{
    /**
     * User Fields
     */
    private const ID = 'id';
    private const NAME = 'name';
    public function doValidate(array $payload): array
    {
        $errors = [];

        foreach ($payload as $key => $item) {
            if (!Validator::key(self::ID)->validate($item)) {
                $errors[$key] = $item;
            }

            if (!Validator::key(self::NAME)->validate($item)) {
                $errors[$key] = $item;
            }
        }

        return $errors;
    }
}
