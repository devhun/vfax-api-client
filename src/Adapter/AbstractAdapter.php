<?php

namespace DevHun\VFax\Adapter;

use DevHun\VFax\Exception\ApiException;

abstract class AbstractAdapter implements AdapterInterface
{
    protected function reportError($code, $response)
    {
        $response = json_decode($response, true);
        switch ($code) {
            case 301:
                throw new ApiException("Not Modified({$response['message']}})");
                break;
            case 400:
                throw new ApiException("Bad Request({$response['message']})");
                break;
            case 401:
                throw new ApiException("Unauthorized");
                break;
            case 415:
                throw new ApiException("Unsupported Media Type({$response['message']})");
                break;
            case 500:
                throw new ApiException("Internal Server Error({$response['message']})");
                break;
            case 501:
                throw new ApiException("Not Implemented({$response['message']})");
                break;
        }
    }
}