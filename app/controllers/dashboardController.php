<?php
namespace app\controllers;
use app\models\Invoice;
use app\models\User;
use core\Controller;
use core\Database\Field;
use core\Session;
use core\View;

class dashboardController extends Controller
{
    /**
     * Main dashboard page
     *
     * @return void
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

    /**
     * Handles invoice download
     *
     * @return void
     */
    public function invoice(){
        $invoiceData = Invoice::getByFields([new Field("requesting_user", Session::get("id"))]);
        if($invoiceData == null) $invoiceData = new Invoice();
        $invoiceData = $invoiceData->getArray();
        if(isset($_POST) && count($_POST)> 2){
            if($invoiceData["generated"] == 1){
                (new View())->render("invoice", ["message" => "<div class='error'>Invoice already confirmed. If you want to change something, contact us via email.</div>", "invoice" => $invoiceData]);
                return;
            }
            $params=["company_name", "company_code", "company_address", "bank_code"];
            foreach ($params as $param){
                if(!isset($_POST[$param])){
                    (new View())->render("invoice", ["message" => "<div class='error'>$param is required</div>", "invoice" => $invoiceData]);
                    return;
                }
            }
            $valid = Invoice::validate($_POST);
            if($valid !== true){
                (new View())->render("invoice", ["message" => "<div class='error'>$valid</div>", "invoice" => $invoiceData]);
                return;
            }
            $invoiceData = Invoice::update($_POST)->getArray();
            (new View())->render("invoice", ["message" => "<div class='success'>Information updated</div>", "invoice" => $invoiceData]);
            return;
        }
        $message = ($invoiceData["generated"] == 1)?"<div class='error'>Invoice already confirmed. If you want to change something, contact us via email.</div>":"";
        (new View())->render("invoice", ["message" => $message, "invoice" => $invoiceData]);
    }
}