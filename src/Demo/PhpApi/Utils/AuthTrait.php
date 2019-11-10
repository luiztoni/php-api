<?php

namespace Demo\PhpApi\Utils;

use Demo\PhpApi\Repositories\UserRepository as Repository;

/**
 * Trait for methods isAuth and unauthorized.
 */
trait AuthTrait
{
    private static function isAuth()
    {
        $headers = getallheaders();
        $repository = new Repository; 
        if (!isset($headers['token']) || !$repository->matchToken($headers['token'])) {
            return false;   
        }
        return true;       
    }

    private static function unauthorized()
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['error'=>'Unauthorized']);
        http_response_code(401);
    }
}
