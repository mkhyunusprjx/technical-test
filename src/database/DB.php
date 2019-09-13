<?php
namespace app\database;

Class DB extends \PDO
{
	private static $_connection = null;

	public static function connect(){
        if (self::$_connection == NULL) {
        	// require ROOT."config/config.php";
            try {
                self::$_connection = new \PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
                self::$_connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                echo 'PDO Error: ' . $e->getMessage();
            }
        }
        return self::$_connection;
	}

	public static function close($conn)
	{
		$conn=null;
	}

	
}