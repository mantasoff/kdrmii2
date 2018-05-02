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

require_once __DIR__ . '/composer/autoload_real.php';

return ComposerAutoloaderInite9feef8766847951b7b8de26e8eb0bc4::getLoader();