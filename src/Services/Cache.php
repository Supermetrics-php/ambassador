<?php

namespace Supermetrics\Ambassador\Services;

use Predis\Client;

final class Cache
{
    public Client $client;
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

    /**
     * @param string $type
     * @param array  $payload
     *
     * @return void
     */
    public function saveIntoCache(string $type, array $payload): void
    {
        $this->client->select(1);

        $data = serialize($payload);

        $this->client->set($type, $data);
        $this->client->expire($type, $this->getCacheTTL());
    }

    /**
     * @param string $type
     *
     * @return void
     */
    public function flush(string $type): void
    {
        $this->client->select(1);

        $this->client->del($type);
    }

    private function getCacheTTL(): int
    {
        return config('database')['cache']['redis']['default']['ttl'];
    }
}
