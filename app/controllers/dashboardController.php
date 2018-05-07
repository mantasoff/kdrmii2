<?php
namespace app\controllers;
use app\models\User;
use core\Controller;
use core\Post;
use core\Session;
use core\View;

class dashboardController extends Controller
{
    /**
     * Main dashboard page
     */
    public function index(){
        $user = new User(Session::get("id"));
        $userData = $user->getArray();
        unset($userData["password"]);
        if(isset($_POST) && count($_POST)> 2){
            $params=["institution", "affiliation", "phone_number", "phone_number", "article_title", "article_authors",
                "article_authors_affiliations", "abstract", "hotel", "leading_people"];
            foreach ($params as $param){
                if(!isset($_POST[$param])){
                    (new View())->render("dashboard", [
                        "message" => "<div class='error'>$param is required</div>",
                        "user" => $userData
                    ]);
                    return;
                }
            }
            $validation = User::validate($_POST);
            if($validation !== true){
                (new View())->render("dashboard", [
                    "message" => "<div class='error'>$validation</div>",
                    "user" => $userData
                ]);
                return;
            }

            $user->updateData($_POST);
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