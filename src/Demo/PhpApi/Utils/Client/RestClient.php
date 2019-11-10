<?php

namespace Demo\PhpApi\Utils\Client;

final class RestClient 
{
    public static function sendContent(array $data, string $url, string $verb = 'POST', string $auth = null)
    {
        $header_content = 'Content-Type: application/json';
        if ($auth) {
            $header_content = $header_content . '\nauthorization: '.$auth;
        }
        $options = [
            'http' => [
                'method' => $verb,
                'content' => json_encode($data),
                'header' => $header_content 
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $response = json_decode($result, true);
        return $response;
    }

    public static function getContent(string $url, string $auth = null)
    {
        $header_content = 'Content-Type: application/json';
        if ($auth) {
            $header_content = $header_content . '\nauthorization: '.$auth;
        }
        $options = [
            'http' => [
                'method' => 'GET',
                'header' => $header_content 
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $response = json_decode($result, true);
        return $response;
    }
}
