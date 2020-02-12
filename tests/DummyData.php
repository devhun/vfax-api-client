<?php

namespace DevHun\VFax\Tests;

class DummyData
{
    private $response = [
        'sendFax' => '{
            "jobId": "DUMMY-JOB-ID"
        }',
        'cancelFax' => '{
            "result": "1"
        }'
    ];

    public function getResponse($url, array $args)
    {
        $response = '{}';

        $jobId = false;
        if ($this->endWith($url, 'DUMMY-JOB-ID')) {
            $url = str_replace('/DUMMY-JOB-ID', '', $url);
            $jobId = true;
        }

        if (isset($this->response[$url])) {
            $response = $this->response[$url];
            if ($jobId) {
                $response = json_decode($this->response[$url], true);
                $response['jobId'] = 'DUMMY-JOB-ID';
                $response = json_encode($response);
            }
        }

        return $response;
    }

    private function endWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

}