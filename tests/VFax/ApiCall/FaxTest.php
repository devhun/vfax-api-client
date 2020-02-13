<?php

namespace DevHun\Vfax\Tests;

use DevHun\VFax\Adapter\CurlAdapter;
use DevHun\VFax\Adapter\GuzzleHttpAdapter;
use DevHun\VFax\VFaxClient;
use PHPUnit\Framework\TestCase;

class FaxTest extends TestCase
{
    /**
     * @var VFaxClient
     */
    protected $client;

    protected function setUp(): void
    {
        $adapterClass = 'DevHun\\VFax\\Adapter\\'.getenv('ADAPTER');

        /**
         * @var $adapter CurlAdapter|GuzzleHttpAdapter
         */
        $adapter = new $adapterClass(getenv('APITOKEN'));
        $adapter->setEndpoint(getenv('ENDPOINT'));

        $this->client = new VFaxClient($adapter);
    }

    public function testSend()
    {
        $result = $this->client->fax()->send(
            '0212345678',
            '0212345678',
            [
                __DIR__.'/files/sample.pdf'
            ],
            ''
        );

        $this->assertArrayHasKey('jobId', $result);
    }
}