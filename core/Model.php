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

    private function getData($id){
        $query = new Query();
        $query->table(static::$table)->select(implode(',',array_values(static::$selectFields)))->where(new Field(static::$idColumn,$id));
        $values = Mysql::execute($query);
        if($values === false) return false;
        $this->id = $id;
        foreach (array_keys((array)$values) as $key){
            $this->fields[$key]=$values[''.$key];
        }
        return true;
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
        Mysql::execute((new Query())->table(static::$table)->insert($fields));
        if(is_numeric(Mysql::lastInserted()))
            $this->fields[static::$idColumn] = Mysql::lastInserted();
        return Mysql::lastInserted();
    }

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
        Mysql::execute((new Query())->table(static::$table)->update($fields)->where(new Field(static::$idColumn,$this->fields[static::$idColumn])));
    }

    /**
     * Return all model instances from database
     * @return array
     */
    public static function all(){
        $result = Mysql::execute((new Query())->table(static::$table)->select(implode(',',array_values(static::$selectFields))));
        $users = [];
        $user = null;
        foreach ($result as $values){
            $user = new User();
            foreach (array_keys((array)$values) as $key){
                $user->fields[$key]=$values[''.$key];
            }
            if($user!=null) array_push($users, $user);
            $user = null;
        }
        return $users;
    }

}