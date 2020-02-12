<?php

namespace DevHun\VFax\Adapter;

use DevHun\VFax\VFaxClient;

class CurlAdapter extends AbstractAdapter
{
    /**
     * @var string API endpoint
     */
    protected $endpoint;

    /**
     * API Token.
     *
     * @var string VFax API token
     */
    protected $apiToken;

    /**
     * The API responseCode.
     *
     * @var int
     */
    protected $responseCode;

    public function __construct($apiToken)
    {
        $this->apiToken = $apiToken;
        $this->responseCode = 0;

    }

    /**
     * {@inheritdoc}
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * {@inheritdoc}
     */
    public function get($url, array $args = [])
    {
        return $this->query($url, $args, 'GET');
    }

    /**
     * {@inheritdoc}
     */
    public function post($url, array $args, array $files = [])
    {
        return $this->query($url, $args, 'POST', $files);
    }

    protected function query($url, array $args, $requestType, array $files = [])
    {
        $url = $this->endpoint.$url;

        $defaults = [
            CURLOPT_USERAGENT      => sprintf('%s v%s (%s)', VFaxClient::AGENT, VFaxClient::VERSION, 'https://github.com/devhun/vfax-api-client'),
            CURLOPT_HEADER         => false,
            CURLOPT_VERBOSE        => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FORBID_REUSE   => true,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTPHEADER     => [
                "Authorization: Bearer $this->apiToken",
            ],
        ];

        switch ($requestType) {
            case 'POST':
                $defaults[CURLOPT_URL] = $url;
                $defaults[CURLOPT_POST] = true;
                array_push($defaults[CURLOPT_HTTPHEADER], 'Content-Type: multipart/form-data; charset=UTF-8');
                $postData = $args;
                foreach ($files as $index => $file) {
                    $postData["file[$index]"] = curl_file_create($file);
                }
                $defaults[CURLOPT_POSTFIELDS] = $postData;
                break;
            case 'GET':
                $defaults[CURLOPT_URL] = $url;
                if (is_array($args)) {
                    $getData = http_build_query($args);
                    $defaults[CURLOPT_URL] = $defaults[CURLOPT_URL].'?'.$getData;
                }
                break;
        }

        $client = curl_init();
        curl_setopt_array($client, $defaults);
        $response = curl_exec($client);
        $code = curl_getinfo($client, CURLINFO_HTTP_CODE);
        curl_close($client);

        if ($code !== 200) {
            // Check to see if there were any API exceptions thrown.
            return $this->isAPIError($client, $response);
        }

        return json_decode($response, true);
    }

    protected function isAPIError($responseObj, $resposne)
    {
        $code = curl_getinfo($responseObj, CURLINFO_HTTP_CODE);
        curl_close($responseObj);
    }
}