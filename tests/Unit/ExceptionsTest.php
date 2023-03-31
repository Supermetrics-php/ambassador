<?php

namespace Unit;

use PHPUnit\Framework\TestCase;
use Supermetrics\Ambassador\Exceptions\StorageDriverException;

class ExceptionsTest extends TestCase
{
    /**
     * @return void
     * @throws StorageDriverException
     */
    public function testDriverException(): void
    {
        $this->expectException(StorageDriverException::class);
        throw new StorageDriverException('Failed');
    }
}