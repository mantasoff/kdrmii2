<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require "core/autoload.php";
require "app/routing/Routes.php";
\core\Route::defaultRoute();
