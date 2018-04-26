<?php
/**
 * Created by d0Nt
 * Date: 2017.03.23
 * Time: 14:24
 */
namespace core\Database;
use core\Exceptions\Error;
use mysqli;

class Mysql
{
    /**
     * @var $connection mysqli
     */
    static $connection = null;

    /**
     * Create connection to mysql database.
     * @param $host string Host address to connect to
     * @param $database string Database name
     * @param $user string Database user
     * @param $password string Database password
     * @param int $port int Port to mysql server (default 3306)
     */
    public static function connect($host, $user, $password, $database, $port = 3306)
    {
        if(self::$connection !== null) return;
        self::$connection = new mysqli($host, $user, $password, $database, $port);
        if (self::$connection->connect_error) {
            self::error("Connection to database failed ",self::$connection->connect_error);
        }
    }

    public static function execute($query){
        if (self::$connection === null)
            self::error("To execure query you need to open connection first");
        if(!$query instanceof Query)
            self::error("$query need to be instance of class Query");
        $result =  self::$connection->query($query->toString());
        if($result === false)
            self::error("Failed to execute query ", self::$connection->error);
        if(!isset($result->num_rows) || $result->num_rows == 0) return false;
        if($result->num_rows == 1) $result->fetch_array(MYSQLI_ASSOC);
        else return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function error($error, $details = null){
        if(ini_get('display_errors') == 1)
        {
            (new Error(503, "[Database] ". $error .": ". $details))->printString();
            die();
        }
        else
            (new Error(503, "[Database] ". $error))->printString();
            die();
    }

    public static function lastInserted(){
        return self::$connection->insert_id;
    }

    public static function escapeString($string){
        if (self::$connection === null)
          self::error("To escape string you need to open connection first");
        return self::$connection->real_escape_string($string);
    }


}