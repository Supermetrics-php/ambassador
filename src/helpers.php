<?php

use Dotenv\Dotenv;

if (! function_exists('config')) {
    function config(string $configName): array
    {
        return include(__DIR__ . "/Config/$configName.php");
    }
}

if (! function_exists('loadENV')) {
    function loadENV(): void
    {
        $env = Dotenv::createImmutable('./');
        $env->load();
    }
}
