<?php

namespace Supermetrics\Ambassador\Generators\Users;

class RedisRecordGenerator
{
    private const KEY = 'users:';
    public function generateKey(array $user): string
    {
        return self::KEY . $user['id'];
    }

    public function generateKeyFromAnID(string $id): string
    {
        return self::KEY . $id;
    }

    public function jsonEncoder(array $user): string
    {
        return json_encode($user, true);
    }

    public function jsonDecoder(string $user): array
    {
        return json_decode($user, true);
    }
}