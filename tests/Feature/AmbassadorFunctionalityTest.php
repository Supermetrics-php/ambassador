<?php

namespace Feature;

use PHPUnit\Framework\TestCase;
use Supermetrics\Ambassador\Ambassador;
use Supermetrics\Ambassador\Enums\StatusCodes;

class AmbassadorFunctionalityTest extends TestCase
{
    public function testIfDataCanBePersistedInRedis(): void
    {
        $ambassador = new Ambassador('redis');

        $result = $ambassador->persist('users', [
            ['id' => '60bb0ca5-25d1-43bd-98e5-6a878c00a0d8', 'name' => 'farshid'],
            ['id' => '60bb0ca5-25d1-43bd-98e5-6a878c00a0d9', 'name' => 'mary']
        ]);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('status', $result, StatusCodes::SUCCESS->value);
    }

    public function testIfAllDataCanBeFetchedFromRedis(): void
    {
        $ambassador = new Ambassador('redis');

        $result = $ambassador->fetchAll('users');

        $this->assertIsArray($result);
        $this->assertArrayHasKey('status', $result, StatusCodes::SUCCESS->value);
    }

    public function testIfSpecificDataCanBeFetchedFromRedis(): void
    {
        $ambassador = new Ambassador('redis');

        $result = $ambassador->fetchById('users', '60bb0ca5-25d1-43bd-98e5-6a878c00a0d8');

        $this->assertIsArray($result);
        $this->assertArrayHasKey('status', $result, StatusCodes::SUCCESS->value);
    }
}
