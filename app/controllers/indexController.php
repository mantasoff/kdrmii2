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
     * Defult location in controller
     *
     * @return void
     */
    public function index()
    {
        if(Helper::config("app")->old_record_clear == "url")
            (new cronController())->clear();
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
     *
     * @param [type] $message
     * @return void
     */
    public static function moveToIndex($message){
        Session::set("message",$message);
        self::redirect('/');
    }

    /**
     * Redirect in project
     *
     * @param [type] $project_url
     * @return void
     */
    public static function redirect($project_url){
        header('Location: '.Helper::config("app")->directory.$project_url);
    }
}