<?php

namespace Supermetrics\Ambassador;

use Supermetrics\Ambassador\Enums\StatusCodes;
use Supermetrics\Ambassador\Enums\EntityTypes;
use Supermetrics\Ambassador\Services\Validator;
use Supermetrics\Ambassador\Enums\ErrorMessages;
use Supermetrics\Ambassador\Traits\ResponsorTrait;
use Supermetrics\Ambassador\Services\StorageBuilder;
use Supermetrics\Ambassador\Contracts\DriverInterface;
use Supermetrics\Ambassador\Exceptions\StorageDriverException;
use Supermetrics\Ambassador\DataTransferObjects\ResponseDataTransferObject;

class Ambassador
{
    use ResponsorTrait;
    protected DriverInterface $storageDriver;

    /**
     * @throws StorageDriverException
     */
    public function __construct(string $driver, protected $validatorService = new Validator)
    {
        $this->storageDriver = StorageBuilder::getDriverInstance($driver);
    }

    /**
     * @param string $type
     * @param array  $payload
     *
     * @return array
     */
    public function persist(string $type, array $payload): array
    {
        /**
         * Given type will be validated.
         * Only "users" can be accepted.
         */
        if (!in_array($type, EntityTypes::getAllValues(), true)) {
            return $this->response(
                responseBody: new ResponseDataTransferObject(
                    statusCode: StatusCodes::INVALID_REQUEST,
                    errorMessages: ErrorMessages::INVALID_ENTITY_TYPE,
                    data: null
                )
            );
        }

        /**
         * Provided Payload will be validated. If any record has special error,
         * the error will be returned to the client.
         */
        $hasErrorOnValidation = $this->validatorService->handle(EntityTypes::from($type), $payload);

        if (count($hasErrorOnValidation) > 0) {
            return $this->response(
                responseBody: new ResponseDataTransferObject(
                    statusCode: StatusCodes::INVALID_REQUEST,
                    errorMessages: ErrorMessages::INVALID_DATA,
                    data: $hasErrorOnValidation
                )
            );
        }

        return [];
    }
}
