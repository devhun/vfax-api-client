<?php

namespace DevHun\VFax\Tests;

use DevHun\VFax\Adapter\CurlAdapter;
use DevHun\VFax\Adapter\GuzzleHttpAdapter;
use DevHun\VFax\VFaxClient;
use PHPUnit\Framework\TestCase;

class VFaxClientTest extends TestCase
{
    public function testConstruct()
    {
        $adapterClass = 'DevHun\\VFax\\Adapter\\'.getenv('ADAPTER');

        /**
         * @var $adapter CurlAdapter|GuzzleHttpAdapter
         */
        $adapter = new $adapterClass(getenv('APITOKEN'));
        $adapter->setEndpoint(getenv('ENDPOINT'));

        $client = new VFaxClient($adapter);

        $this->assertInstanceOf('DevHun\\VFax\\VFaxClient', $client);
    }
}