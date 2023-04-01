<?php

namespace Supermetrics\Ambassador\Drivers;

use Exception;
use Predis\Client;
use Supermetrics\Ambassador\Contracts\DriverInterface;
use Supermetrics\Ambassador\Contracts\DriverConnectionInterface;
use Supermetrics\Ambassador\Exceptions\ConnectionException;

class RedisDriver implements DriverInterface, DriverConnectionInterface
{
    public Client $client;
    public function store()
    {
        // TODO: Implement store() method.
    }

    public function findById()
    {
        // TODO: Implement findById() method.
    }

    public function connect(): bool
    {
        try {
            $this->client = new Client(config('database')['connections']['redis']);
            $this->client->ping();

            return true;
        } catch (Exception) {
            return false;
        }
    }
}
