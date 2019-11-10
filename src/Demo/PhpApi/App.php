<?php

namespace Demo\PhpApi;

use Demo\PhpApi\Controllers;
use Demo\PhpApi\Utils\AuthTrait;

/**
 * Front Controller
 */
final class App
{
    use AuthTrait;

    private $controller = "products";
    private $method = "index";
    private $param = null;

    private function parseUri() 
    {
        $path = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");
        $count = substr_count($path,"/");
       
        if ($count > 2) {
            return false;
        } elseif ($count == 2) {
            list($this->controller, $this->method, $this->param) = explode("/", $path, 3);
        } elseif ($count == 1) {
            list($this->controller, $this->method) = explode("/", $path, 2);
        } 
        
        $status = $this->setController($this->controller);
        if (!$status) 
            return false;
                  
        $status = $this->setMethod($this->method);
        if (!$status) 
            return false;

        if (isset($this->param)) {
            $status = $this->setParam($this->param);
            if (!$status) 
                return false; 
        }
        return true;
    }
    
    private function setController($controller) 
    {
        $controller = "Demo\\PhpApi\\Controllers\\". ucfirst(strtolower($controller)) . "Controller";
        if (class_exists($controller)) {
            $this->controller = $controller;
            return true;
        }
        return false; 
    }
    
    private function setMethod($method) 
    {
        $reflector = new \ReflectionClass($this->controller);
        if ($reflector->hasMethod($method)) {
            $this->method = $method;
            return true;
        }
        return false;
    }
    
    private function setParam($param) 
    {
        if (intval($param)) {
            $this->param = $param;
            return true;
        }
        return false;
    }
   
    /**
    * Start application
    */
    public function run() 
    {
        $openUris = ['show', 'index', 'register', 'login'];
        if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js)$/', $_SERVER["REQUEST_URI"]))
            return false;
        if (filter_input(INPUT_GET, 'search'))
            return call_user_func_array([new \Demo\PhpMvc\Controllers\ProductsController, "search"], []);
        else {
            $status = $this->parseUri();
            if (!$status) {
                return header("location:/products/index");        
            }
            if (!in_array($this->method, $openUris) && !self::isAuth()) {
                return self::unauthorized();
            }
            if (isset($this->param))
                return call_user_func_array([new $this->controller, $this->method], [$this->param]);
            else
                return call_user_func_array([new $this->controller, $this->method], []);
        }
    }
}
