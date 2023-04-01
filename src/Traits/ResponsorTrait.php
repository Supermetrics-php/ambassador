<?php

namespace Supermetrics\Ambassador\Traits;

use Supermetrics\Ambassador\DataTransferObjects\ResponseDataTransferObject;

trait ResponsorTrait
{
    /**
     * @param ResponseDataTransferObject $responseBody
     *
     * @return array
     */
    protected function response(ResponseDataTransferObject $responseBody): array
    {
        $response = [
            'status' => $responseBody->statusCode->value,
        ];

        if (isset($responseBody->errorMessages) && $responseBody->errorMessages->value !== null) {
            $response['message'] = $responseBody->errorMessages->value;

        }

        if ($responseBody->data !== null) {
            $response['body'] = $responseBody->data;
        }

        return $response;
    }
}
