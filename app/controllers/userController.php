<?php
namespace app\controllers;
use app\models\User;
use core\Controller;
use core\Exceptions\Error;
use core\Exceptions\Success;
use core\Post;

class userController extends Controller
{
    public function index(){}

    public function register(){
        if(count($_POST) === 0){
            return (new Error(400, "No arguments given"))->printJson();
        }
        $requiredParams=["title", "firstname", "lastname", "affiliation", "email", "phone", "articletitle",
            "articleauthors", "articleauthorsaffiliations", "hotel", "accompany"];
        foreach ($requiredParams as $param){
            if(Post::get($param) === false || Post::get($param) === null || Post::get($param) === ""){
                return (new Error(400, "Not all required arguments given"))->printJson();
            }
        }
        $user = new User();
        $user->email=Post::get("email");
        $user->first_name = Post::get("firstname");
        $user->last_name = Post::get("lastname");
        $user->degree = Post::get("title");
        $user->affiliation = Post::get("affiliation");
        $user->phone_number = Post::get("phone");
        $user->article_title = Post::get("articletitle");
        $user->article_authors = Post::get("title");
        $user->hotel = Post::get("hotel");
        $user->leading_people = Post::get("accompany");
        $user->insert();
        (new Success(200, "User created"))->printJson();
        return 1;
    }
    public function validate($id, $hash){
        echo "test";
    }
}