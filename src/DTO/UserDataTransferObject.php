<?php

namespace Supermetrics\Ambassador\Returner;

readonly class UserDataTransferObject
{
    public function __construct(
        public string $userId,
        public string $userName
    ) {
    }
}
