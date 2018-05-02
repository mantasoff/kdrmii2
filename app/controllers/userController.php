<?php
namespace app\controllers;
use app\models\User;
use app\models\Validation;
use core\Controller;
use core\Database\Field;
use core\Exceptions\Error;
use core\Exceptions\Success;

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
            indexController::moveToIndex("<div class='error'>Error: $error</div>");
            return 0;
        }
        if(User::create($_POST) === 0)
        {
            indexController::moveToIndex("<div class='error'>Error: Unknown error.</div>");
            return 0;
        }
        indexController::moveToIndex("<div class='success'>Registration successful. Please check your mail for further information.</div>");
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