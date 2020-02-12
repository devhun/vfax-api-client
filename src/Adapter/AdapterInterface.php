<?php

namespace DevHun\VFax\Adapter;

interface AdapterInterface
{
    /**
     * Added primarily to allow proper code testing.
     *
     * @param string $endpoint
     */
    public function setEndpoint($endpoint);

    /**
     * GET Method.
     *
     * @param string $url  API method to call
     * @param array  $args Argument to pass along with the method call.
     *
     * @return array
     */
    public function get($url, array $args = []);

    /**
     * POST Method.
     *
     * @param string $url   API method to call
     * @param array  $args  Argument to pass along with the method call.
     * @param array  $files File to pass along with the method call.
     *
     * @return array|int when $getCode is set, the HTTP response code will
     *                   be returned, otherwise an array of results will be returned.
     */
    public function post($url, array $args, array $files = []);
}