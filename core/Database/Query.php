<?php
/**
 * Created by d0Nt
 * Date: 2017.03.23
 * Time: 15:12
 */

namespace core\Database;

class Query
{
    private $command = null;
    private $table = null;
    private $where = null;
    private $orderBy = null;
    private $limit = null;
    private $offset = null;
    private $db = null;

    /**
     * Set table for query to execute in
     * @param $table
     * @return $this Query
     */
    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function db($db){
        $this->db = $db;
        return $this;
    }
    /**
     * Select statement for mysql
     * @param $select string Fields to select(separated by comma)
     * @return $this Query Returns Query object
     */
    public function select($select){
        $this->command = "SELECT " . $select . " FROM ";
        return $this;
    }

    /**
     * Update statement for mysql
     * @param $fields Field[]
     * @return $this Query
     */
    public function update($fields){
        if($this->table == null)
            die("Query table was not set.");
        $this->command = "UPDATE ". ($this->db === null?"":$this->db.".") . $this->table . " SET ";
        $result = [];
        if(is_array($fields)){
            foreach ($fields as $field) {
                if(!$field instanceof Field)
                    die("Bad query formatting. One of fields was not instance of Field");
                array_push($result,$field->toString());
            }
        }
        else{
            if(!$fields instanceof Field)
                die("Bad query formatting. One of fields was not instance of Field");
            array_push($result,$fields->toString());
        }
        $this->command .= implode(',', $result);
        return $this;
    }

    /**
     * Delete statement for mysql
     * @return $this Query
     */
    public function delete(){
        $this->command = "DELETE FROM";
        return $this;
    }

    /**
     * Insert statement for mysql
     * @param $fields Field[]
     * @return $this Query
     */
    public function insert($fields){
        if($this->table == null)
            die("Query table was not set.");
        $keys = [];
        $values = [];
        if(is_array($fields)){
            foreach ($fields as $field){
                if(!$field instanceof Field)
                    die("Bad query formatting. One of fields was not instance of Field");
                array_push($keys, $field->getField());
                array_push($values, $field->getValue());
            }
        }
        else{
            if(!$fields instanceof Field)
                die("Bad query formatting. One of fields was not instance of Field");
            array_push($keys, $fields->getField());
            array_push($values, $fields->getValue());
        }
        $this->command = "INSERT INTO ". ($this->db === null?"":$this->db.".") . $this->table . " ( ".implode(",", $keys)." ) VALUES (".implode(",", $values).")";
        return $this;
    }

    /**
     * Order by field
     * @param string $field
     * @param bool $asc
     * @return $this
     */
    public function orderBy($field, $asc = true){
        $this->orderBy = " ORDER BY " . $field . ($asc ? " ASC" : " DESC");
        return $this;
    }
    public function limit($limit){
        $this->limit = " LIMIT " . $limit;
        return $this;
    }
    public function offset($offset){
        $this->offset = " OFFSET " . $offset;
        return $this;
    }
    public function where($fields){
        $this->where = "WHERE ";
        $result = [];
        if(is_array($fields)){
            foreach ($fields as $field) {
                if(!$field instanceof Field)
                    die("Bad query formatting. One of fields was not instance of Field");
                array_push($result,$field->toString());
            }
        }
        else{
            if(!$fields instanceof Field)
                die("Bad query formatting. Fields was not instance of Field");
            array_push($result,$fields->toString());
        }
        $this->where .= implode(' AND ', $result);
        return $this;
    }

    /**
     * Finalize query formating
     * @return null|string
     */
    public function toString(){
        if (strpos(strtolower($this->command), "update") !== false) return $this->command ." ". $this->where . $this->limit . $this->offset;
        else if (strpos(strtolower($this->command), "insert") !== false || strpos(strtolower($this->command), "replace") !== false) return $this->command;
        else return $this->command . ($this->db === null?"":$this->db.".") ." ". $this->table . " " . $this->where . $this->orderBy . $this->limit . $this->offset;
    }
}