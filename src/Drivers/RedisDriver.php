<?php

namespace Supermetrics\Ambassador\Drivers;

use Predis\Client;
use Supermetrics\Ambassador\Contracts\DriverInterface;
use Supermetrics\Ambassador\Contracts\DriverConnectionInterface;

class RedisDriver implements DriverInterface, DriverConnectionInterface
{
    public Client $client;
    public function __construct()
    {
        $this->client = new Client(config('database')['connections']['redis']);
    }
    public function store()
    {
        // TODO: Implement store() method.
    }

    public function findById()
    {
        // TODO: Implement findById() method.
    }

    public function connect()
    {
    var_dump($this->client->ping());
    }
}
