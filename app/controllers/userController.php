<?php
namespace app\controllers;
use app\models\User;
use app\models\Validation;
use core\Controller;
use core\Database\Field;
use core\Exceptions\Error;
use core\Exceptions\Success;
use core\Helper;
use core\Session;
use core\View;

class userController extends Controller
{
    public function index(){}

    /**
     * User registration route
     * @return int 0 if fails to register user, 1 if success
     */

    public function register(){
        $error = User::validateData($_POST);
        if($error !== true){
            (new View())->render("register", ["message"=>"<div class='error'>Error: $error</div>"]);
            return 0;
        }
        if(User::create($_POST) === 0)
        {
            (new View())->render("register", ["message"=>"<div class='error'>Error: Unknown error.</div>"]);
            return 0;
        }
        Session::set("message","<div class='success'>Registration successful. Please check your mail for further information.</div>");
        header('Location: '.Helper::config("app")->directory.'/');
        return 0;
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
            (new Error(400, "Validations not found"))->printData();
            return;
        }
        if(intval($validation->valid_till) < time()){
            $user = new User($validation->user_id);
            if($user->id !== null)
                $user->delete();
            $validation->delete();
            (new Error(400, "Validations not found"))->printData();
            return;
        }
        $user = new User($validation->user_id);
        if($user->id === null){
            (new Error(400, "User not exist anymore"))->printData();
            return;
        }
        $user->validated = 1;
        $user->save();
        $validation->delete();
        (new Success(200, "User validated"))->printData();
    }
}