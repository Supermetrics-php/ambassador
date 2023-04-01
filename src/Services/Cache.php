<?php

namespace Supermetrics\Ambassador\Services;

use Predis\Client;

class Cache
{
    public Client $client;
    private const CACHE_TTL = 10; //Minutes
    public function __construct()
    {
        $this->client = new Client(config('database')['cache']['redis']);
    }

    /**
     * @param string $type
     *
     * @return mixed
     */
    public function fetchFromCache(string $type): mixed
    {
        $this->client->select(1);

        $result = $this->client->get($type);

        if ($result !== null) {
            return unserialize($result, ['allowed_classes' => false]);
        }

        return null;
    }

    public function saveIntoCache(string $type, array $payload): void
    {
        $this->client->select(1);

        $data = serialize($payload);

        $this->client->set($type, $data);
        $this->client->expire($type, self::CACHE_TTL);
    }

    public function flush(string $type): void
    {
        $this->client->select(1);

        $this->client->del($type);
    }
}
