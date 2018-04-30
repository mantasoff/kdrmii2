<?php
namespace app\controllers;
use app\models\User;
use app\models\Validation;
use core\Controller;
use core\Database\Field;
use core\Exceptions\Error;
use core\Exceptions\Success;
use core\Post;

class userController extends Controller
{
    public function index(){}

    /**
     * User registration route
     * @return int 0 if fails to register user, 1 if success
     */
    public function register(){
        if(count($_POST) === 0){
            (new Error(400, "No arguments given"))->printData();
            return 0;
        }
        $requiredParams=["title", "firstname", "lastname", "affiliation", "email", "phone", "articletitle",
            "articleauthors", "articleauthorsaffiliations", "hotel", "accompany"];
        foreach ($requiredParams as $param){
            if(Post::get($param) === false || Post::get($param) === null || Post::get($param) === ""){
                (new Error(400, "Not all required arguments given"))->printData();
                return 0;
            }
        }
        $user = new User();
        $user->email = Post::get("email");
        $user->first_name = Post::get("firstname");
        $user->last_name = Post::get("lastname");
        $user->degree = Post::get("title");
        $user->affiliation = Post::get("affiliation");
        $user->phone_number = Post::get("phone");
        $user->article_title = Post::get("articletitle");
        $user->article_authors = Post::get("title");
        $user->hotel = Post::get("hotel");
        $user->leading_people = Post::get("accompany");
        $id=$user->insert();
        Validation::createUserValidation($id);
        (new Success(200, "User created"))->printData();
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