<?php

namespace Supermetrics\Ambassador;

use Supermetrics\Ambassador\Drivers\Driver;
use Supermetrics\Ambassador\Drivers\StorageBuilder;

class Ambassador
{
	protected Driver $storageDriver;

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
		return [];
	}
}
