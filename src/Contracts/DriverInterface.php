<?php

namespace Supermetrics\Ambassador\Contracts;

interface DriverInterface
{
    public function store(array $payload, string $entityType): void;

    public function findById(string $id, string $entityType): array;

    public function findAll(string $entityType): array;
}
