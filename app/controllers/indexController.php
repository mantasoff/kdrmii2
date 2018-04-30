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
        (new View())->render("register");
    }
}