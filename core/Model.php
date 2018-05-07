<?php
/**
 * Created by d0Nt
 * Date: 2017.03.24
 * Time: 22:56
 */

namespace core;

use app\models\User;
use core\Database\Field;
use core\Database\Mysql;
use core\Database\Query;

class Model
{
    protected static $table=null;
    protected static $idColumn='id';
    protected static $db = null;
    /**
     * @var array Validations to fields
     */
    protected static $validations = [];
    /**
     * @var array Fields to select from database [ add id field too ]
     */
    protected static $selectFields=[];
    /**
     * @var array Fields to save in database
     */
    protected static $saveFields=[];

    private $fields = [];
    function __get($name){
        return $this->fields[$name];
    }
    function __set($name, $value){
        $this->fields[$name]=$value;
    }

    function __construct($id=null){
        if(static::$saveFields==null) static::$saveFields=static::$selectFields;
        else{
            foreach (static::$saveFields as $key){
                if(!in_array($key,static::$selectFields)){
                    Mysql::error('Bad saveFields array. Fix it.');
                    static::$saveFields=static::$selectFields;
                    break;
                }
            }
        }
        $this->fields=[];
        foreach (static::$selectFields as $key) {
            $this->fields[$key]=null;
        }
        if($id!=null) $this->getData($id);
    }

    /**
     * Data validator
     * @param $input array Input data to validate
     * @return bool|string True if data is valid, string if error occurred
     */
    public static function validate($input){
        foreach ($input as $key => $value){
            if(!isset(static::$validations[$key])) continue;
            $valid=static::$validations[$key];
            //regex validation
            if(isset($valid["regex"])){
                if(preg_match($valid["regex"], $value) === 0 || preg_match(static::$validations[$key]["regex"], $value) === false){
                    return (isset($valid["name"])?$valid["name"]:$key)." value is bad";
                }
            }
            //min/max validation
            if(isset($valid["min"])){
                if(isset($valid["type"]) && $valid["type"] == "number" && !is_numeric($value))
                    return (isset($valid["name"])?$valid["name"]:$key)." not a number";
                if(isset($valid["type"]) && $valid["type"] == "number" && intval($value) < $valid["min"])
                    return (isset($valid["name"])?$valid["name"]:$key)." too small";
                else if(strlen($value) < $valid["min"])
                    return (isset($valid["name"])?$valid["name"]:$key)." too short";
            }
            //min/max validation
            if(isset($valid["max"])){
                if(isset($valid["type"]) && $valid["type"] == "number" && !is_numeric($value))
                    return (isset($valid["name"])?$valid["name"]:$key)." not a number";
                if(isset($valid["type"]) && $valid["type"] == "number" && intval($value) < $valid["max"])
                    return (isset($valid["name"])?$valid["name"]:$key)." too big";
                else if(strlen($value) > $valid["max"])
                    return (isset($valid["name"])?$valid["name"]:$key)." too long";
            }
            //hard coded values
            if(isset($valid["values"])){
                if(!in_array($value, $valid["values"]))
                    return (isset($valid["name"])?$valid["name"]:$key)." value is bad";
            }
        }
        return true;
    }
    /**
     * Get model data from database by id
     * @param $id
     * @return bool
     */
    private function getData($id){
        $query = new Query();
        if(static::$db !== null) $query->db(static::$db);
        $query->table(static::$table)->select(implode(',',array_values(static::$selectFields)))->where(new Field(static::$idColumn,$id));
        $values = Mysql::execute($query);
        if($values === false) return false;
        $this->id = $id;
        $this->updateDataFromResult($values);
        return true;
    }

    /**
     * Update model data from database fields
     * @param $result
     */
    protected function updateDataFromResult($result){
        if(!is_array($result)) return;
        foreach (array_keys((array)$result) as $key){
                $this->fields[$key]=$result[''.$key];
        }
    }

    /**
     * Insert model to database
     * @param bool $insertID Custom id
     * @return mixed|null
     */
    public function insert($insertID=false){
        if(static::$idColumn==null){
            Mysql::error('ID column not set for object');
            return null;
        }
        if($this->fields[static::$idColumn]==null && $insertID){
            Mysql::error('ID column value not set');
            return null;
        }
        $fields = [];
        if($insertID) array_push($fields, new Field(static::$idColumn, $this->fields[static::$idColumn]));
        foreach (static::$saveFields as $field){
            if($this->fields[$field]==null || $field==static::$idColumn) continue;
            array_push($fields, new Field($field, $this->fields[$field]));
        }
        $query = new Query();
        if(static::$db !== null) $query->db(static::$db);
        $query->table(static::$table)->insert($fields);
        Mysql::execute($query);
        if(is_numeric(Mysql::lastInserted()))
            $this->fields[static::$idColumn] = Mysql::lastInserted();
        return Mysql::lastInserted();
    }

    /**
     * Delete model from database
     */
    public function delete(){
        if(static::$idColumn==null){
            Mysql::error('ID column not set for object');
            return;
        }
        if($this->fields[static::$idColumn]==null){
            Mysql::error('ID column value not set');
            return;
        }
        $query = new Query();
        if(static::$db !== null) $query->db(static::$db);
        $query->table(static::$table)->delete()->where(new Field(static::$idColumn, $this->fields[static::$idColumn]));
        Mysql::execute($query);
    }
    /**
     * Get formated query
     * @param null $query
     * @param string $select
     * @return Query|null
     */
    public static function getQuery($query = null, $select = "*"){
        if($query === null) $query = new Query();
        if(static::$db !== null) $query->db(static::$db);
        $query->table(static::$table)->select($select)->orderBy("id", false);
        return $query;
    }

    /**
     * Save model to database
     */
    public function save(){
        if(static::$idColumn==null){
            Mysql::error('ID column not set for object');
            return;
        }
        if($this->fields[static::$idColumn]==null){
            Mysql::error('ID column value not set');
            return;
        }
        $fields = [];
        foreach (static::$saveFields as $field){
            array_push($fields, new Field($field, $this->fields[$field]));
        }
        $query = new Query();
        if(static::$db !== null) $query->db(static::$db);
        $query->table(static::$table)->update($fields)->where(new Field(static::$idColumn,$this->fields[static::$idColumn]));;
        Mysql::execute($query);
    }

    /**
     * Get model data in array
     * @return array
     */
    public function getArray(){
        return $this->fields;
    }

    /**
     * Get model/models from database with specified fields
     * @param $fields
     * @param null $order
     * @param null $limit
     * @return User|User[]|null
     */
    public static function getByFields($fields, $order = null, $limit = null)
    {
        if (is_array($fields)) {
            foreach ($fields as $field)
                if (!$field instanceof Field) {
                    Mysql::error("Bad fields value in getByFields.", "Not all requested fields are Field type");
                    return null;
                }
        } else {
            if (!$fields instanceof Field) {
                Mysql::error("Bad fields value in getByFields.", "Not all requested fields are Field type");
                return null;
            }
        }
        $query =(new Query())->table(static::$table)->select(implode(',', array_values(static::$selectFields)))->where($fields);
        if(static::$db !== null) $query->db(static::$db);
        if($limit !== null)
            $query->limit($limit);
        if($order !== null)
            $query->orderBy(static::$idColumn, strtolower($order)=="asc"?true:false);
        $result = Mysql::execute($query);
        $className=get_called_class();
        if(Mysql::$num_rows > 1){
            $models = [];
            foreach ($result as $row)
            {
                $model = new $className();
                $model->updateDataFromResult($row);
                array_push($models, $model);
            }
            return $models;
        }
        if(Mysql::$num_rows == 0)
            return null;
        $model = new $className();
        $model->updateDataFromResult($result);
        return $model;
    }

    /**
     * Return all model instances from database
     * @return array
     */
    public static function all(){
        $className=get_called_class();
        $query = (new Query())->table(static::$table)->select(implode(',',array_values(static::$selectFields)));
        if(static::$db !== null) $query->db(static::$db);
        $result = Mysql::execute($query);
        $models = [];
        $model = null;
        foreach ($result as $row){
            $model = new $className();
            $model->updateDataFromResult($row);
            if(!is_array($models))
                $models = [$model];
            else
                array_push($models, $model);
            $model = null;
        }
        return $models;
    }

}