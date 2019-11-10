<?php

namespace Demo\PhpApi\Services;

use Demo\PhpApi\Models\User;
use Demo\PhpApi\Repositories\UserRepository as Repository;
use Demo\PhpApi\Utils\AuthTrait as Auth;

/**
 * Service layer
 */
final class AuthService
{
    use Auth;

    /**
    * Login service 
    */
    public static function login()
    {
        $credentials = file_get_contents("php://input");
        $credentials = json_decode($credentials, true);
        
        $repository = new Repository;
        $user = $repository->match($credentials['email'], $credentials['password']);
       
        if ($user) 
            self::start($user);    
        else 
            self::unauthorized();
    }

    /**
    * Logout service 
    */
    public static function logout($token)
    {
        $repository = new Repository;
        $user = $repository->matchToken($token);
        $user->setToken(null);
        $repository->update($user->getId(), $user);
    }

    /**
    * Generate authorization token 
    */
    private static function start($user)
    {
        $token = bin2hex(random_bytes(32));
        $user->setToken($token);
        $repository = new Repository;
        $repository->update($user->getId(), $user);
        header('token: '. $token);
        http_response_code(200);
    }

    /**
    * Register service 
    */
    public static function register()
    {
        $informations = file_get_contents("php://input");
        $informations = json_decode($informations, true);
        $password = password_hash($informations['password'], PASSWORD_DEFAULT);
       
        $repository = new Repository;
        $user = new User(null, $informations['email'], $password, "default.png");
       
        $id = $repository->create($user);
        $user->setId($id);
        self::start($user);
    }
}
