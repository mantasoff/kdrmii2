<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set ("Europe/Vilnius");
require "core/autoload.php";
\core\Session::start();
require "app/routing/Routes.php";
\core\Route::defaultRoute();
