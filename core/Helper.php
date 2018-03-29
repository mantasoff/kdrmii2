<?php
/**
 * Created by d0Nt
 * Date: 2018.03.24
 * Time: 11:36
 */

namespace core;


class Helper
{
    public static function localUrl()
    {
        return trim(substr(urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)),strlen(self::config("app")->directory)), '/');
    }
    public static function config($configFile)
    {
        return (object)require __DIR__ . '/../app/config/' . $configFile . ".php";
    }
}