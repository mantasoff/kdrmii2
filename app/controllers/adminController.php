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

/**
 * Administrator controller
 */
class adminController extends Controller
{
    /**
     * Returnas value is admin
     *
     * @return boolean
     */
    public static function isAdmin(){
        return Session::get("admin_id") != false;
    }

    /**
     * Handles index action
     *
     * @return void
     */
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
        $message = "";
        if(Session::get("message") != false){
            $message = Session::get("message");
            Session::set("message", false);
        }
        (new View())->render("admin/dashboard", ["users" => json_encode($users_array), "message" => $message]);
    }

    /**
     * Handles log out action
     *
     * @return void
     */
    public function logout(){
        Session::destroy();
        indexController::redirect("/admin/login");
    }

    /**
     * Handles user update action
     *
     * @param [type] $id
     * @return void
     */
    public function update($id){
        if(!self::isAdmin()){
            indexController::redirect("/admin/login");
            exit;
        }
        if(!isset($_POST) || count($_POST)<1){
            Session::set("message", '<div class="error"> No data given </div>');
            indexController::redirect("/admin");
            exit;
        }
        $user = new User($id);
        if($user->id == null){
            Session::set("message", '<div class="error">User not exist</div>');
            indexController::redirect("/admin");
            exit;
        }
        $validate = User::validate($_POST);
        if($validate != true){
            Session::set("message", '<div class="error">Entered data invalid: '.$validate.'</div>');
            indexController::redirect("/admin");
            exit;
        }
        foreach ($_POST as $key=>$value){
            $user->$key = $value;
        }
        $user->save();
        Session::set("message", '<div class="success">User '.$user->id.' updated</div>');
        indexController::redirect("/admin");
    }

    /**
     * Handles user delete action
     *
     * @param [type] $id
     * @return void
     */
    public function delete($id){
        if(!self::isAdmin()){
            indexController::redirect("/admin/login");
            exit;
        }
        $user = new User($id);
        if($user->id == null){
            Session::set("message", '<div class="error"> User not exist</div>');
            indexController::redirect("/admin");
            exit;
        }
        $user->delete();
        Session::set("message", '<div class="success">User '.$user->id.' deleted.</div>');
        indexController::redirect("/admin");
    }

    /**
     * Handles log in 
     *
     * @return void
     */
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