<?php

namespace DevHun\VFax;

use DevHun\VFax\Adapter\AdapterInterface;
use DevHun\VFax\ApiCall\Fax;

class VFaxClient
{
    const ENDPOINT = 'https://api.vfax.co.kr/vFax/v1/';
    const VERSION = '1.0.1';
    const AGENT = 'VFax PHP API Client';

    /**
     * @var AdapterInterface
     */
    private $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function fax()
    {
        return new Fax($this->adapter);
    }
}
