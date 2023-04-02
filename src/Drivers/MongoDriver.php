<?php

namespace Supermetrics\Ambassador\Drivers;

use Supermetrics\Ambassador\Contracts\DriverInterface;
use Supermetrics\Ambassador\Contracts\DriverConnectionInterface;

class MongoDriver implements DriverInterface, DriverConnectionInterface
{
    public function store(array $payload, string $entityType): void
    {
        // TODO: Implement store() method.
    }

    public function findAll(string $entityType): array
    {
        // TODO: Implement findAll() method.
        return [];
    }

    public function findById(string $id, string $entityType): array
    {
        // TODO: Implement findById() method.
        return [];
    }

    public function connect(): bool
    {
        // TODO: Implement connect() method.
        return true;
    }
}
