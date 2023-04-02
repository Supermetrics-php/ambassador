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

    /**
     * @param array $payload
     *
     * @return array
     */
    public function doValidate(array $payload): array
    {
        $errors = [];

        foreach ($payload as $key => $item) {
            /**
             * ID must be existed.
             */
            if (!Validator::key(self::ID)->validate($item)) {
                $errors[$key] = $item;
            }

            /**
             * UUID will be checked
             */
            if (!Validator::uuid()->validate($item[self::ID])) {
                $errors[$key] = $item;
            }

            /**
             * NAME must be existed.
             */
            if (!Validator::key(self::NAME)->validate($item)) {
                $errors[$key] = $item;
            }

            /**
             * NAME type must be string.
             */
            if (!Validator::stringType()->validate($item[self::NAME])) {
                $errors[$key] = $item;
            }
        }

        return $errors;
    }
}
