<?php

namespace Supermetrics\Ambassador\Generators\Users;

class RedisRecordGenerator
{
    private const KEY = 'users:';

    /**
     * @param array $user
     *
     * @return string
     */
    public function generateKey(array $user): string
    {
        return self::KEY . $user['id'];
    }

    /**
     * @param string $id
     *
     * @return string
     */
    public function generateKeyFromAnID(string $id): string
    {
        return self::KEY . $id;
    }

    /**
     * @param array $user
     *
     * @return string
     */
    public function jsonEncoder(array $user): string
    {
        return json_encode($user, true);
    }

    /**
     * @param string $user
     *
     * @return array
     */
    public function jsonDecoder(string $user): array
    {
        return json_decode($user, true);
    }
}
