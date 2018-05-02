<?php
namespace app\controllers;
use app\models\User;
use core\Controller;
use core\Helper;
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
        if(User::isLogged()){
            indexController::redirect('/dashboard');
            return 1;
        }
        (new View())->render("register", ["message" => (Session::get("message") === false ? "" : Session::get("message"))]);
        if(Session::get("message") !== false)
            Session::set("message", false);
    }

    /**
     * Redirect to index page
     * @param $message
     */
    public static function moveToIndex($message){
        Session::set("message",$message);
        self::redirect('/');
    }

    /**
     * Redirect in project
     * @param $project_url
     */
    public static function redirect($project_url){
        header('Location: '.Helper::config("app")->directory.$project_url);
    }
}