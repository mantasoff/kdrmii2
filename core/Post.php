<?php
/**
 * Created by d0Nt
 * Date: 2018.03.25
 * Time: 12:27
 */

namespace core;


class Post
{
    public static function get($key){
        return isset($_POST[$key])? $_POST[$key] : false;
    }
}