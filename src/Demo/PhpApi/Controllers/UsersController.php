<?php

namespace Demo\PhpApi\Controllers;

use Demo\PhpApi\Services\AuthService as Auth;

/**
 * Users controller
 */
class UsersController extends Controller
{
    /**
    * Create user
    */
    public function register()
    {    
        Auth::register();
    }

    /**
    * Auth user
    */
    public function login()
    {
        Auth::login();
    }

    /**
    * logout user
    */
    public function logout()
    {
        $headers = getallheaders();
        Auth::logout($headers['token']);
        header("location:/products/index");
    }
}
