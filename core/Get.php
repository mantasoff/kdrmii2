<?php
/**
 * Created by d0Nt
 * Date: 2018.03.25
 * Time: 12:28
 */

namespace core;


class Get
{
    public static function get($key){
        return isset($_GET[$key])? $_GET[$key] : false;
    }
}