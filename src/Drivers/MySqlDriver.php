<?php

namespace Supermetrics\Ambassador\Drivers;

use Supermetrics\Ambassador\Contracts\DriverInterface;
use Supermetrics\Ambassador\Contracts\DriverConnectionInterface;

class MySqlDriver implements DriverInterface, DriverConnectionInterface
{
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
        // TODO: Implement connect() method.
        return true;
    }
}
