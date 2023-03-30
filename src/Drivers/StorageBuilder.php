<?php

namespace Supermetrics\Ambassador\Drivers;

use Supermetrics\Ambassador\Enums\StorageDrivers;

class StorageBuilder
{
    protected static $dbInstance;

    /**
     * Just to make sure that any external instantiation will be locked.
     */
    private function  __construct()
    {
    }

    /**
     * Just to make sure that any copy of the object will be prevented.
     */
    private function  __clone()
    {
    }

    public static function getDriverInstance($driverName): Driver
    {
        if (self::$dbInstance === null) {
            self::$dbInstance = self::getDriver($driverName);
        }

        return self::$dbInstance;
    }
    public static function getDriver(string $driverName): Driver
    {
        return match ($driverName) {
            StorageDrivers::MYSQL->value => new MySqlDriver(),
            StorageDrivers::MONGO->value => new MongoDriver(),
            default               => new RedisDriver(),
        };
    }
}
