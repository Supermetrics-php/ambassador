<?php

namespace Supermetrics\Ambassador\Drivers;

use Exception;
use Predis\Client;
use Supermetrics\Ambassador\Contracts\DriverInterface;
use Supermetrics\Ambassador\Contracts\DriverConnectionInterface;

class RedisDriver implements DriverInterface, DriverConnectionInterface
{
    private const BASE_GENERATOR_NAMESPACE = 'Supermetrics\Ambassador\Generators\\';
    private const GENERATOR_CLASS_SUFFIX = 'RedisRecordGenerator';
    public Client $client;
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

    /**
     * @param array  $payload
     * @param string $entityType
     *
     * @return void
     */
    public function store(array $payload, string $entityType): void
    {
        $redisRecordGenerator = $this->getRedisGenerator($entityType);

        foreach ($payload as $item) {
            $redisKey = $redisRecordGenerator->generateKey($item);
            $encodedEntity = $redisRecordGenerator->jsonEncoder($item);

            $this->client->hset($entityType, $redisKey, $encodedEntity);
        }
    }

    public function findById(string $id, string $entityType): array
    {
        $redisRecordGenerator = $this->getRedisGenerator($entityType);
        $redisKey = $redisRecordGenerator->generateKeyFromAnID($id);
        $result = $this->client->hget($entityType, $redisKey);

        if ($result !== null) {
            return $redisRecordGenerator->jsonDecoder($result);
        }

        return [];
    }

    /**
     * @param string $entityType
     *
     * @return array
     */
    public function findAll(string $entityType): array
    {
        $redisRecordGenerator = $this->getRedisGenerator($entityType);
        $result = $this->client->hvals($entityType);
        $convertedResult = [];

        foreach ($result as $item) {
            $convertedResult[] = $redisRecordGenerator->jsonDecoder($item);
        }

        return $convertedResult;
    }

    /**
     * @param string $entityType
     *
     * @return mixed
     */
    private function getRedisGenerator(string $entityType): mixed
    {
        return new (self::BASE_GENERATOR_NAMESPACE . ucfirst($entityType) . '\\' . self::GENERATOR_CLASS_SUFFIX);
    }
}
