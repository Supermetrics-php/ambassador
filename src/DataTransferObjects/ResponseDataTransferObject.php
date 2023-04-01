<?php

namespace Supermetrics\Ambassador\DataTransferObjects;

use Supermetrics\Ambassador\Enums\StatusCodes;
use Supermetrics\Ambassador\Enums\ErrorMessages;

readonly class ResponseDataTransferObject
{
    /**
     * @param StatusCodes   $statusCode
     * @param ErrorMessages $errorMessages
     * @param array|null    $data
     */
    public function __construct(
        public StatusCodes $statusCode,
        public ErrorMessages $errorMessages,
        public ?array $data
    ) {
    }
}
