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
    public function response(ResponseDataTransferObject $responseBody): array
    {
        $response = [
            'message' => $responseBody->errorMessages->value,
            'status' => $responseBody->statusCode->value,
        ];

        if ($responseBody->data !== null) {
            $response['body'] = $responseBody->data;
        }

        return $response;
    }
}
