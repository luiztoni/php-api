<?php

namespace Demo\PhpApi\Config;

/**
*  Databese Configuration
*/
class DbConfig
{
    /**
    * Returns a connection to the default database
    * @return \PDO connection
    */
    public static function getConnection()
    {
        $dbLocation = $_SERVER['DOCUMENT_ROOT'].'\\src\\Demo\\PhpApi\\Config\\demo.db';

        try {
            $pdo = new \PDO('sqlite:'.$dbLocation);         
        } catch (PDOException $exception) {
            echo "Error:" . $exception->getMessage();
        }
        return $pdo;   
    }
}
