<?php
namespace  app\controllers;
use core\Controller;
use core\View;

class dashboardController extends Controller
{
    public function index(){
        (new View())->render("dashboard");
    }
}