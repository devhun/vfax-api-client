<?php

namespace DevHun\VFax\ApiCall;

class Fax extends AbstractApiCall
{
    public function send($callback, $destFax, array $files, $reqDate = '')
    {
        $args = [
            'cid' => $callback,
            'coverType' => '',
            'coverSubject' => '',
            'coverContent' => '',
            'coverSendDate' => '',
            'coverSendName' => '',
            'subject' => '',
            'desFax' => $destFax,
            'desName' => '',
            'callback' => '',
            'reqDate' => $reqDate
        ];

        $json_args = ['form' => json_encode($args)];

        $index = 0;
        $file_arguments = [];
        foreach ($files as $file) {
            if (file_exists(realpath($file))) {
                $file_arguments["file[{$index}]"] = $file;
                $index++;
            }
        }

        return $this->adapter->post('sendFax', $json_args, $file_arguments);
    }
}