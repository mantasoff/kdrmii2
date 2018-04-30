<?php
namespace app\controllers;
use core\Controller;
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
        $view = new View();
        $view->title = "phpFramework";
        $view->render("index",[
            "user" =>[
                "name"=>"var from php"
            ]
        ]);
    }
}