<?php
namespace app\controllers;
use app\models\User;
use app\models\Validation;
use core\Controller;
use core\Database\Field;
use core\Post;
use core\Session;
use core\View;

class userController extends Controller
{
    public function index(){}
    /***
     * *
     * Password Reset route
     */
    public function passwordReset()
    {
        if (User::isLogged()) {
            indexController::redirect('/dashboard');
            return;
        }
        $message = "";
        if (isset($_POST) && count($_POST) > 0) {

            if (Post::get("email") === false || strlen(Post::get("email")) < 1) {
                $message = "<div class='error'>Error: email is empty.</div>";
            }else{
                $user = User::getByFields([
                    new Field("email", Post::get("email"))
                ]);
                if($user === null || is_array($user)){
                    $message = "<div class='error'>Error: Email incorrect.</div>";
                }else{
                    Validation::createUserValidation($user->id,"reset");
                    return;
                }
            }
        }
        (new View())->render("reset", ["message" => $message]);
        indexController::moveToIndex('Your password reset link has been sent to your email, please confirm');
    }
    public function dashboard(){
        if(!User::isLogged()){
            indexController::redirect('/user/login');
            return;
        }
    }

    /***
     * * User login
     * Checks if fields fill out
     * Checks if user information is correct
     * Login
     */

    public function login(){
        if(User::isLogged()){
            indexController::redirect('/dashboard');
            return;
        }
        $message = "";
        if(isset($_POST) && count($_POST) > 0){
            if(Post::get("email") === false || strlen(Post::get("email")) < 1 ||
                Post::get("password") === false || strlen(Post::get("password")) < 1){
                $message = "<div class='error'>Error: email or password is empty.</div>";
            }else{
                $user = User::getByFields([
                    new Field("email", Post::get("email")) ,
                    new Field("password", User::getHashedPassword(Post::get("password")))
                ]);
                if($user === null || is_array($user)){
                    $message = "<div class='error'>User name or passwords incorrect.</div>";
                }else{
                    Session::set("id", $user->id);
                    indexController::redirect('/dashboard');
                    return;
                }
            }
        }
        (new View())->render("login", ["message" => $message]);
    }

    /**
     * Logout action
     */
    public function logout(){
        Session::destroy();
        indexController::redirect('/user/login');
    }
    /**
     * User registration route
     * @return int 0 if fails to register user, 1 if success
     */
    public function register(){
        if(User::isLogged()){
            indexController::redirect('/dashboard');
            return 0;
        }
        $error = User::validateData($_POST);
        if($error !== true){
            indexController::moveToIndex("<div class='error'>Error: $error</div>");
            return 0;
        }
        if(User::create($_POST) === 0)
        {
            indexController::moveToIndex("<div class='error'>Error: Unknown error.</div>");
            return 0;
        }
        indexController::moveToIndex("<div class='success'>Registration successful. Please check your mail for further information.</div>");
        return 1;
    }

    /**
     * Validate mail requests route
     * @param $id
     * @param $hash
     */
    public function validate($id, $hash){
        $validation = Validation::getByFields([
            new Field("id", $id),
            new Field("hash", $hash)
        ]);
        if($validation === null || $validation->id === null) {
            indexController::moveToIndex("<div class='error'>Error: Validation not found.</div>");
            return;
        }
        if(intval($validation->valid_till) < time()){
            $user = new User($validation->user_id);
            if($user->id !== null)
                $user->delete();
            $validation->delete();
            indexController::moveToIndex("<div class='error'>Error: Validation not found.</div>");
            return;
        }
        $user = new User($validation->user_id);
        if($user->id === null){
            indexController::moveToIndex("<div class='error'>Error: User not exist anymore.</div>");
            $validation->delete();
            return;
        }
        $user->validated = 1;
        $user->save();
        $validation->delete();
        mailController::sendPassword($user->id);
        indexController::moveToIndex("<div class='success'>User validated successful. Password is sent to your email.</div>");
    }
}