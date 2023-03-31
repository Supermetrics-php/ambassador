<?php

namespace Supermetrics\Ambassador\Contracts;

interface ValidationInterface
{
    public function doValidate(array $payload): array;
}
