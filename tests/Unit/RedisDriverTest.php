<?php

namespace Unit;

use PHPUnit\Framework\TestCase;
use Supermetrics\Ambassador\Drivers\RedisDriver;

class RedisDriverTest extends TestCase
{
    /**
     * @return void
     */
    public function testIfConnectedCorrectly(): void
    {
        $redisDriver  = new RedisDriver();
        $result = $redisDriver->client->ping();

        $this->assertIsObject($result);
    }
}