<?php
/**
 * Created by d0Nt
 * Date: 2018.05.08
 * Time: 21:00
 */

namespace app\controllers;
use app\models\User;
use core\Database\Field;

use core\Controller;
use core\Helper;
use core\Post;
use core\Session;
use core\View;

class adminController extends Controller
{
    public static function isAdmin(){
        return Session::get("admin_id") != false;
    }
    public function index()
    {
        if(!self::isAdmin()){
            indexController::redirect("/admin/login");
            return;
        }
        $users = User::getByFields(new Field("Validated", 1));
        $users_array = [];
        foreach ($users as $user){
            array_push($users_array, $user->getArray());
        }
        (new View())->render("admin/dashboard", ["users" => json_encode($users_array)]);
    }
    public function login(){
        if(isset($_POST) && count($_POST)>1){
            if(Post::get("name") === false || strlen(Post::get("name")) < 3){
                (new View())->render("admin/login", ["message" => "<div class='error'>Name not valid.</div>"]);
                return;
            }
            if(Post::get("password") === false || strlen(Post::get("password")) < 3){
                (new View())->render("admin/login", ["message" => "<div class='error'>Password not valid.</div>"]);
                return;
            }
            //login confirm
            if(Post::get("name") !== Helper::config("app")->admin_name ||
                Post::get("name") !== Helper::config("app")->admin_password){
                (new View())->render("admin/login", ["message" => "<div class='error'>Name or password not valid.</div>"]);
                return;
            }
            Session::set("admin_id", 1);
            //
            indexController::redirect("/admin");
            return;
        }
        (new View())->render("admin/login", ["message" => ""]);
    }
}