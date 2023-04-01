<?php

namespace Supermetrics\Ambassador\DataTransferObjects;

use Supermetrics\Ambassador\Enums\StatusCodes;
use Supermetrics\Ambassador\Enums\ResponseMessages;

readonly class ResponseDataTransferObject
{
    /**
     * @param StatusCodes           $statusCode
     * @param ResponseMessages|null $errorMessages
     * @param array|null            $data
     */
    public function __construct(
        public StatusCodes $statusCode,
        public ?ResponseMessages $errorMessages,
        public ?array $data
    ) {
    }
}
