<?php

namespace DevHun\VFax\ApiCall;

class Fax extends AbstractApiCall
{
    public function send($callback, $destFax, array $files, $reqDate = '')
    {
        $args = [
            'cid' => $callback,
            'coverType' => '1',
            'coverSubject' => '',
            'coverContent' => '',
            'coverSendName' => '',
            'subject' => '',
            'destFax' => $destFax,
            'callback' => '',
            'reqDate' => $reqDate,
            'desName' => ''
        ];
        $json_args = json_encode(['form' => $args]);

        return $this->adapter->post('sendFax', $args, $files);
    }
}