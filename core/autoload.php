<?php
/**
 * Created by PhpStorm.
 * User: d0Nt
 * Date: 2017.03.23
 * Time: 14:35
 */
spl_autoload_register(function($class) {
    $file = str_replace('\\', '/', $class);

    $file.=".php";
    if(file_exists($file))
        require $file;
});