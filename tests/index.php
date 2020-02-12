<?php

require_once 'DummyData.php';

// Out fake 'content store'
$jsonData = new DevHun\VFax\Tests\DummyData();

// Grab requested url.
$url = ltrim($_SERVER['PATH_INFO'], '/');

// Prepare arguments.
$args = array_merge($_GET, $_POST);

header('Content-Type: application/json');
echo
    $jsonData->getResponse($url, $args);