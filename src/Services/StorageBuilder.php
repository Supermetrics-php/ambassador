<?php

namespace Supermetrics\Ambassador\Services;

use Supermetrics\Ambassador\Enums\Messages;
use Supermetrics\Ambassador\Drivers\MongoDriver;
use Supermetrics\Ambassador\Drivers\RedisDriver;
use Supermetrics\Ambassador\Drivers\FileDriver;
use Supermetrics\Ambassador\Enums\StorageDrivers;
use Supermetrics\Ambassador\Contracts\DriverInterface;
use Supermetrics\Ambassador\Exceptions\ConnectionException;
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
     * @throws ConnectionException
     */
    public static function getDriverInstance(string $driverName): DriverInterface
    {
        /**
         * Provided Driver from client will be validated.
         */
        if (!self::isDriverSupported($driverName)) {
            throw new StorageDriverException(Messages::INVALID_STORAGE->value);
        }

        if (self::$dbInstance === null) {
            self::$dbInstance = self::getDriver($driverName);
        }

        $isConnected = self::$dbInstance->connect();

        /**
         * If Connection failed. Exception will be thrown.
         */
        if (!$isConnected) {
            throw new ConnectionException(Messages::STORAGE_CONNECTION_FAILED->value);
        }

        return self::$dbInstance;
    }

    /**
     * @param string $driverName
     *
     * @return DriverInterface
     */
    public static function getDriver(string $driverName): DriverInterface
    {
        return match ($driverName) {
            StorageDrivers::FILE->value => new FileDriver(),
            StorageDrivers::MONGO->value => new MongoDriver(),
            default               => new RedisDriver(),
        };
    }

    /**
     * @param string $driverName
     *
     * @return bool
     */
    private static function isDriverSupported(string $driverName): bool
    {
        return in_array($driverName, StorageDrivers::getAllValues(), true);
    }
}
