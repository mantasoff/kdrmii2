<?php
/**
 * Created by d0Nt
 * Date: 2018.03.24
 * Time: 14:07
 */

namespace core;

class Controller
{
    public function index(){
        echo "index";
    }

    /**
     * Get function parameters count
     * @param $func
     * @return int
     */
    public static function paramCount($func){
        $reflection = new \ReflectionFunction($func);
        return $reflection->getNumberOfParameters();
    }

    /**
     * Get class function parameters count
     * @param $class
     * @param $func
     * @return int
     */
    public static function classParamCount($class, $func){
        $reflection = new \ReflectionMethod($class, $func);
        return $reflection->getNumberOfParameters();
    }
}