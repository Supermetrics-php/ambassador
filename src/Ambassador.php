<?php

namespace Supermetrics\Ambassador;

use Supermetrics\Ambassador\Contracts\DriverInterface;
use Supermetrics\Ambassador\Drivers\StorageBuilder;

class Ambassador
{
	protected DriverInterface $storageDriver;

    /**
     * @param $driver
     */
    public function __construct($driver)
	{
		$this->storageDriver = StorageBuilder::getDriverInstance($driver);
	}

    /**
     * @param array $payload
     *
     * @return array
     * steps:
     * 1- Incoming data should be validated (structure and security).
     * 2-
     */
    public function handle(array $payload): array
	{
        var_dump($this->storageDriver->findById());
		return [];
	}
}
