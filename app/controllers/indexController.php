<?php
namespace app\controllers;
use core\Controller;
use core\Session;
use core\View;

/**
 * Default controller
 * @package app\controllers
 */
class indexController extends Controller
{
    /**
     * Default location in controller
     */
    public function index()
    {
        (new View())->render("register", ["message" => (Session::get("message") === false ? "" : Session::get("message"))]);
        if(Session::get("message") !== false)
            Session::set("message", false);
    }
}