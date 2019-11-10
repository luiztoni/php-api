<?php

require_once __DIR__ . '/RestClient.php';

$response = Demo\PhpApi\Utils\Client\RestClient::getContent('http://localhost:8000/products/index');

print_r($response);
die;
