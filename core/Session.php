<?php
/**
 * Created by d0Nt
 * Date: 2017.03.23
 * Time: 21:35
 */

namespace core;


class Session
{
    public static function start(){
        session_start();
    }
    public static function get($key){
        return isset($_SESSION[$key])? $_SESSION[$key] : false;
    }
    public static function set($key, $value){
        $_SESSION[$key] = $value;
    }
    public static function destroy(){
        session_destroy();
    }
}