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
                "name"=>"vladiskov",
                "dbid" => 9
            ]
        ]);
    }

    public function test(){
        echo "testuojam";
    }
}