<?php
namespace app\controllers;
use app\models\User;
use core\Controller;
use core\Post;
use core\Session;
use core\View;

class dashboardController extends Controller
{
    public function index(){
        $user = new User(Session::get("id"));
        $userData = $user->getArray();
        unset($userData["password"]);
        if(isset($_POST) && count($_POST)> 2){
            $params=["institution", "affiliation", "phone_number", "phone_number", "article_title", "article_authors", "article_authors_affiliations"];
            foreach($params as $key){
                if(Post::get($key) === false || strlen(Post::get($key)) < 1){
                    (new View())->render("dashboard", [
                        "message" => "<div class='error'>$key is required.</div>",
                        "user" => $userData
                    ]);
                    return;
                }
            }
            $user->updateData($_POST, $params);
            $userData=$user->getArray();
            (new View())->render("dashboard", [
                "message"=> "<div class='success'>Saved.</div>",
                "user" => $userData
            ]);
            return;
        }
        (new View())->render("dashboard", [
            "message"=> "",
            "user" => $userData
        ]);
    }
}