<?php

namespace Supermetrics\Ambassador\Services;

use Supermetrics\Ambassador\Enums\ErrorMessages;
use Supermetrics\Ambassador\Drivers\MongoDriver;
use Supermetrics\Ambassador\Drivers\RedisDriver;
use Supermetrics\Ambassador\Drivers\MySqlDriver;
use Supermetrics\Ambassador\Enums\StorageDrivers;
use Supermetrics\Ambassador\Contracts\DriverInterface;
use Supermetrics\Ambassador\Exceptions\StorageDriverException;

class StorageBuilder
{
    protected static $dbInstance;

    /**
     * Just to make sure that any external instantiation will be locked.
     */
    private function __construct()
    {
    }

    /**
     * Just to make sure that any copy of the object will be prevented.
     */
    private function __clone()
    {
    }

    /**
     * @throws StorageDriverException
     */
    public static function getDriverInstance(string $driverName): DriverInterface
    {
        if (!self::isDriverSupported($driverName)) {
            throw new StorageDriverException(ErrorMessages::INVALID_STORAGE->value);
        }

        if (self::$dbInstance === null) {
            self::$dbInstance = self::getDriver($driverName);
        }

        return self::$dbInstance;
    }
    public static function getDriver(string $driverName): DriverInterface
    {
        return match ($driverName) {
            StorageDrivers::MYSQL->value => new MySqlDriver(),
            StorageDrivers::MONGO->value => new MongoDriver(),
            default               => new RedisDriver(),
        };
    }

    private static function isDriverSupported(string $driverName): bool
    {
        return in_array($driverName, StorageDrivers::getAllValues(), true);
    }
}
