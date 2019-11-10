<?php

namespace Demo\PhpApi\Controllers;

/**
 * Abstract class inherited by over controllers  
 *
 * @author     Luiz Toni <luiztoni@outlook.com>
 * @copyright  License MIT
 */
abstract class Controller
{
    /**
     * Parse array to json
     * @param array $args array of arguments
     * @param int $status HTTP status code, default 200
     */
   final protected function jsonParse(array $args, int $status = 200) 
   {
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($args);
        http_response_code($status);
        exit;
   }
}
