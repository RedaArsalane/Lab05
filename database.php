<?php
class Database
{
    private static $dbName = 'country' ;
    private static $dbHost = '127.0.0.1' ;
    private static $dbUsername = 'root';
    private static $dbUserPassword = '';

    private static $handler  = null;

    public function __construct()
    {
        die('Constructor is not allowed');
    }

    public static function connect()
    {
        if ( null == self::$handler )
        {
            try
            {
                self::$handler =  new PDO(
                    "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName.";charset=utf8",
                    self::$dbUsername,
                    self::$dbUserPassword
                );
                self::$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $e)
            {
                die($e->getMessage());
            }
        }
        return self::$handler;
    }

    public static function disconnect()
    {
        self::$handler = null;
    }
}
