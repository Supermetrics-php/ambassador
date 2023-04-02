<?php

namespace Unit;

use PHPUnit\Framework\TestCase;
use Supermetrics\Ambassador\Enums\StorageDrivers;

class StorageBuilderTest extends TestCase
{
    /**
     * @return void
     */
    public function testIfDriverSupported(): void
    {
        $validDriver = StorageDrivers::REDIS->value;
        $this->assertContains($validDriver, StorageDrivers::getAllValues());
    }
}