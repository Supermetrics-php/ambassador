<?php

namespace Unit;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Supermetrics\Ambassador\Rules\Users;

class UserValidationTest extends TestCase
{
    /**
     * @return void
     */
    public function testFailureWhenInvalidUserDataIsProvided(): void
    {
        $faker = Factory::create();
        $data = [
            ['ida' => $faker->uuid, 'name' => $faker->name],
        ];

        $userValidation = new Users();

        $result = $userValidation->doValidate($data);

        $this->assertIsArray($result);

        $this->assertCount(1, $result);
    }
}