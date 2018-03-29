<?php
namespace app\controllers;
use core\Controller;
use core\View;

class indexController extends Controller
{
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

    public function test(){
        echo "testuojam";
    }
}