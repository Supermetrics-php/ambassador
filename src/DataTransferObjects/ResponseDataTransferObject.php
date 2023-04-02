<?php

namespace Supermetrics\Ambassador\DataTransferObjects;

use Supermetrics\Ambassador\Enums\StatusCodes;
use Supermetrics\Ambassador\Enums\Messages;

readonly class ResponseDataTransferObject
{
    /**
     * @param StatusCodes   $statusCode
     * @param Messages|null $errorMessages
     * @param array|null    $data
     */
    public function __construct(
        public StatusCodes $statusCode,
        public ?Messages $errorMessages,
        public ?array $data
    ) {
    }
}
