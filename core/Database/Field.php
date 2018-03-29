<?php
/**
 * Created by d0Nt
 * Date: 2017.03.23
 * Time: 15:09
 */

namespace core\Database;


class Field
{
    private $field = null;
    private $value = null;
    private $separator = "=";
    private $escape = true;
    public static function customSeparator($field, $value, $separator){
        $instance = new self($field, $value);
        $instance->separator = $separator;
        return $instance;
    }
    function __construct($field, $value)
    {
        $this->field = $field;
        $this->value = $value;
    }
    public function unsafe(){
        $this->escape = false;
        return $this;
    }
    public function safe(){
        $this->escape = true;
        return $this;
    }
    public function getField(){
        return $this->field;
    }
    public function getValue(){
        if(!$this->escape || !is_string($this->value)) return $this->value;
        return "'".Mysql::escapeString($this->value)."'";
    }
    public function toString(){
        return $this->getField()."".$this->separator."".$this->getValue();
    }
}