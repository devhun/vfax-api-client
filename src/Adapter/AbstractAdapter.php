<?php

namespace DevHun\VFax\Adapter;

use DevHun\VFax\Exception\ApiException;

abstract class AbstractAdapter implements AdapterInterface
{
    protected function reportError($code, $response)
    {
        switch ($code) {
            case 200:
                $responseObj = json_decode($response, true);

                if ($responseObj['code'] !== '200') {
                    throw new ApiException(isset($responseObj['message']) ?: '');
                }
                break;
        }
    }
}