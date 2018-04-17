<?php
/**
 * Created by d0Nt
 * Date: 2017.03.23
 * Time: 14:24
 */
namespace core\Database;
use core\Exceptions\Error;
use core\Helper;
use mysqli;

class Mysql
{
    /**
     * @var $connection mysqli
     */
    static $connection = null;
    public static $num_rows = 0;

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
            self::$connection = null;
            die();
        }
    }

    /**
     * Open connection from database file
     */
    public static function openConnection(){
        $db = Helper::config("database");
        if($db === false) {
            self::error("No database config file.");
            return;
        }
        $db = Helper::config("database");
        if(!isset($db->host) || !isset($db->password) || !isset($db->user) || !isset($db->database)){
            self::error("Bad database config file", "Required parameters: host, user, password and database");
            return;
        }
        self::connect($db->host, $db->user, $db->password, $db->database, isset($db->port)?$db->port:3306);
        if(isset($db->charset))
            self::$connection->set_charset($db->charset);
    }

    /**
     * Start transaction
     * @param int $FLAG
     */
    public static function startTransaction($FLAG = MYSQLI_TRANS_START_READ_WRITE){
        if(self::$connection === null){
            self::error("No open connection to database.", "Transaction requires open connection.");
            return;
        }
        if($FLAG !== MYSQLI_TRANS_START_READ_ONLY && $FLAG !== MYSQLI_TRANS_START_READ_WRITE && $FLAG !== MYSQLI_TRANS_START_WITH_CONSISTENT_SNAPSHOT){
            self::error("Bad transaction flag.", "Only mysqli transaction flags possible. Leave blank for default.");
            return;
        }
        self::$connection->begin_transaction($FLAG);
    }

    /**
     * End transaction
     */
    public static function endTransaction(){
        self::commit();
    }

    /**
     * End transaction and save changes
     */
    public static function commit(){
        if(self::$connection === null){
            self::error("No open connection to database.", "Transaction requires open connection.");
            return;
        }
        self::$connection->commit();
    }
    public static function rollback(){
        if(self::$connection === null){
            self::error("No open connection to database.", "Transaction requires open connection.");
            return;
        }
        self::$connection->rollback();
    }
    /**
     * Execute query
     * @param $query
     * @param $onlyCount boolean Return only number of rows(true) or full result(false)
     * @return bool|mixed|null
     */
    public static function execute($query, $onlyCount = false){
        self::$num_rows = 0;
        self::openConnection();
        if(self::$connection === null) return null;
        if(!$query instanceof Query)
            self::error("$query need to be instance of class Query");
        $result =  self::$connection->query($query->toString());
        if($result === false)
            self::error("Failed to execute query ", self::$connection->error);
        if(!isset($result->num_rows) || $result->num_rows == 0) return false;
        self::$num_rows = $result->num_rows;
        if($onlyCount)
            return self::$num_rows;
        if(self::$num_rows == 1) return $result->fetch_array(MYSQLI_ASSOC);
        else return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Print database error
     * @param $error
     * @param null $details
     */
    public static function error($error, $details = null){
        if(ini_get('display_errors') == 1)
        {
            (new Error(503, "[Database] ". $error .": ". $details))->printData();
            die();
        }
        else
            (new Error(503, "[Database] ". $error))->printData();
            die();
    }

    /**
     * Last inserted row id
     * @return mixed
     */
    public static function lastInserted(){
        return self::$connection->insert_id;
    }

    /**
     * Escape string
     * @param $string
     * @return string
     */
    public static function escapeString($string){
        if (self::$connection === null)
          self::error("To escape string you need to open connection first");
        return self::$connection->real_escape_string($string);
    }


}