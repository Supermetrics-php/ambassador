<?php

namespace Supermetrics\Ambassador;

use Supermetrics\Ambassador\Services\Cache;
use Supermetrics\Ambassador\Enums\StatusCodes;
use Supermetrics\Ambassador\Enums\EntityTypes;
use Supermetrics\Ambassador\Services\Validator;
use Supermetrics\Ambassador\Enums\Messages;
use Supermetrics\Ambassador\Traits\ResponsorTrait;
use Supermetrics\Ambassador\Services\StorageBuilder;
use Supermetrics\Ambassador\Contracts\DriverInterface;
use Supermetrics\Ambassador\Exceptions\StorageDriverException;
use Supermetrics\Ambassador\DataTransferObjects\ResponseDataTransferObject;

final class Ambassador
{
    use ResponsorTrait;
    protected DriverInterface $storageDriver;
    protected Cache $cache;

    /**
     * @throws StorageDriverException|Exceptions\ConnectionException
     */
    public function __construct(string $driver, protected $validatorService = new Validator())
    {
        $this->storageDriver = StorageBuilder::getDriverInstance($driver);
        $this->cache = new Cache();
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
                    errorMessages: Messages::INVALID_ENTITY_TYPE,
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
                    errorMessages: Messages::INVALID_DATA,
                    data: $hasErrorOnValidation
                )
            );
        }

        $this->storageDriver->store($payload, EntityTypes::from($type)->value);

        /**
         * Old Cached data will be removed.
         */
        $this->cache->flush($type);

        return $this->response(
            responseBody: new ResponseDataTransferObject(
                statusCode: StatusCodes::SUCCESS,
                errorMessages: Messages::DATA_SUCCESSFULLY_IMPORTED,
                data: $payload
            )
        );
    }

    /**
     * @param string $type
     *
     * @return array
     */
    public function fetchAll(string $type): array
    {
        /**
         * Data will be fetched from Redis (Cache layer) before executing a query.
         */
        $result = $this->cache->fetchFromCache($type);

        if (!$result) {
            $result = $this->storageDriver->findAll($type);
            $this->cache->saveIntoCache($type, $result);
        }

        return $this->response(
            responseBody: new ResponseDataTransferObject(
                statusCode: StatusCodes::SUCCESS,
                errorMessages: null,
                data: $result
            )
        );
    }

    /**
     * @param string $type
     * @param string $id
     *
     * @return array
     */
    public function fetchById(string $type, string $id): array
    {
        /**
         * Given type will be validated.
         * Only "users" can be accepted.
         */
        if (!in_array($type, EntityTypes::getAllValues(), true)) {
            return $this->response(
                responseBody: new ResponseDataTransferObject(
                    statusCode: StatusCodes::INVALID_REQUEST,
                    errorMessages: Messages::INVALID_ENTITY_TYPE,
                    data: null
                )
            );
        }

        $result = $this->storageDriver->findById($id, $type);
        if (count($result) >= 1) {
            return $this->response(
                responseBody: new ResponseDataTransferObject(
                    statusCode: StatusCodes::SUCCESS,
                    errorMessages: null,
                    data: $result
                )
            );
        }

        return $this->response(
            responseBody: new ResponseDataTransferObject(
                statusCode: StatusCodes::NOT_FOUND,
                errorMessages: Messages::RECORD_NOT_FOUND,
                data: null
            )
        );
    }
}
