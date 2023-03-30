<?php

namespace Supermetrics\Ambassador\DataTransferObjects;

readonly class UserDataTransferObject
{
    public function __construct(
        public string $userId,
        public string $userName
    ) {
    }
}
