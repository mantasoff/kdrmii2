<?php
/**
 * Created by d0Nt
 * Date: 2018.03.24
 * Time: 23:20
 */

namespace app\models;


use app\controllers\recaptcha;
use core\Database\Field;
use core\Model;
use core\Post;
use core\Session;

class User extends Model
{
    protected static $table = "users";
    protected static $selectFields = ["id", "email", "password", "institution", "degree", "first_name",
        "last_name", "affiliation", "phone_number", "article_title", "article_authors", "article_authors_affiliations", "hotel",
        "leading_people", "abstract", "additional_events", "validated"];
    protected static $saveFields = ["email", "password", "institution", "degree", "first_name", "last_name", "affiliation",
        "phone_number", "article_title", "article_authors", "article_authors_affiliations", "hotel", "leading_people", "abstract",
        "additional_events", "validated"];
    /**
     * @var string Static salt for hashing passwords
     */
    private static $salt = "D1ISxMojS4g1FRmSAGsd";

    /**
     * Set hashed password for user
     * @param $unHashed string password to set
     */
    public function setPassword($unHashed){
        $this->password = self::getHashedPassword($unHashed);
    }

    public static function getHashedPassword($unHashed){
        return hash('sha256', self::$salt."".$unHashed);
    }

    /**
     * Validate user data before creating
     * @param $data
     * @return bool|string
     */
    public static function validateData($data){
        if(!is_array($data) || count($data) === 0){
            return "No data given";
        }
        if(!recaptcha::verify()){
            return "reCaptcha validation failed";
        }
        $requiredParams=["title", "firstname", "lastname", "institution", "affiliation", "email", "phone", "articletitle",
            "articleauthors", "articleauthorsaffiliations", "hotel", "leading_people", "invoice_required", "abstract"];
        foreach ($requiredParams as $param){
            if(!isset($data[$param]) || $data[$param] === null || $data[$param] === "" || strlen($data[$param])<2){
                return $param." is required";
            }
        }
        if(preg_match('/^[A-Za-z0-9.]+@[A-Za-z]+.[A-Za-z0-9.]+$/', $data["email"]) === 0 || preg_match('/^[A-Za-z0-9.]+@[A-Za-z]+.[A-Za-z0-9.]+$/', $data["email"]) === false){
            return "Bad mail value";
        }
        if(!in_array($data["hotel"], ["roomother", "roomno", "roomsingle", "roomdouble"])){
            return "Bad hotel value";
        }
        if($data["hotel"] === "roomother" && (!isset($data["addinfo"]) || $data["addinfo"] === null || $data["addinfo"] === "" || strlen($data["addinfo"])<2)) {
            return "Additional information about room is required";
        }
        if(!in_array($data["leading_people"], ["accyes", "accno"])){
            return "Bad accompany value";
        }
        if(!in_array($data["additional_events"], ["accevyes","accevno"])){
            return "Bad additional events value";
        }
        if(!in_array($data["invoice_required"], ["invyes","invno"])){
            return "Bad invoice value";
        }
        if($data["invoice_required"] === "invyes"){
            foreach (["institutionname","institutionaddress", "institutioncompanycode", "institutionbankcode"] as $param){
                if(!isset($data[$param]) || $data[$param] === null || $data[$param] === "" || strlen($data[$param])<2){
                    return $param." is required";
                }
            }
        }
        if(strlen($data["email"]) > 100){
            return "Mail is too long.";
        }
        if(strlen($data["institution"]) > 100){
            return "Institution is too long.";
        }
        if(strlen($data["title"])>12){
            return "Degree is too long";
        }
        if(strlen($data["firstname"]) > 64){
            return "First name is too long.";
        }
        if(strlen($data["lastname"]) > 64){
            return "Last name is too long.";
        }
        if(strlen($data["affiliation"]) > 255){
            return "Affiliation is too long.";
        }
        if(strlen($data["phone"]) > 18){
            return "Phone number is too long.";
        }
        if(preg_match("/^[0-9+ ]+$/", $data["phone"]) == 0 || preg_match("/^[0-9+ ]+$/", $data["phone"]) == false){
            return "Phone number is not valid";
        }
        if(strlen($data["articletitle"]) > 255){
            return "Article title is too long.";
        }
        if(strlen($data["articleauthors"]) > 300){
            return "Article authors is too long.";
        }
        if(strlen($data["articleauthorsaffiliations"]) > 300){
            return "Article authors affiliations is too long.";
        }
        if(strlen($data["abstract"]) > 800){
            return "Abstraction is too long.";
        }
        if(strlen($data["hotel"]) > 64){
            return "Hotel data is too long.";
        }
        $withMail = User::getByFields([new Field("email", $data["email"])]);
        if($withMail !== null){
            return "User with this email already exist.";
        }
        return true;
    }
    public static function validateUpdateData($params){
        foreach($params as $key){
            if(Post::get($key) === false || strlen(Post::get($key)) < 1){
                return "$key is required.";
            }
        }
        if(!in_array(Post::get("hotel"), ["roomother", "roomno", "roomsingle", "roomdouble"])){
            return "Bad hotel value";
        }
        if(strlen(Post::get("hotel")) > 64){
            return "Hotel data is too long.";
        }
        if(preg_match("/^[0-9+ ]+$/", Post::get("phone_number")) == 0 || preg_match("/^[0-9+ ]+$/", Post::get("phone_number")) == false){
            return "Phone number is not valid";
        }
        if(Post::get("hotel") === "roomother" && (Post::get("addinfo") === false || Post::get("addinfo") === null || Post::get("addinfo") === "" || strlen(Post::get("addinfo"))<2)) {
            return "Additional information about room is required";
        }

        return true;
    }

    /**
     * Check and update user data.
     * @param $data array Data to update user with
     * @param $params array Variables to update
     */
    public function updateData($data, $params){
        foreach ($params as $key){
            $this->$key = $data[$key];
        }
        if(Post::get("hotel") === "roomother")
            $this->hotel = Post::get("addinfo");
        $this->leading_people = ($data["leading_people"] == "accyes" ? 1 : 0 );
        if($this-> leading_people === 1)
            $this->additional_events = $data["additional_events"] == "accevyes" ? 1 : 0 ;
        else
            $this->additional_events = 0;
        $this->save();
    }
    /**
     * Create user in database
     * @param $data
     * @return int
     */
    public static function create($data)
    {
        $user = new User();
        $user->email = $data["email"];
        $user->first_name = $data["firstname"];
        $user->last_name = $data["lastname"];
        $user->degree = $data["title"];
        $user->institution = $data["institution"];
        $user->affiliation = $data["affiliation"];
        $user->phone_number = $data["phone"];
        $user->article_title = $data["articletitle"];
        $user->article_authors = $data["title"];
        $user->article_authors_affiliation = $data["articleauthorsaffiliations"];
        if(in_array($data["hotel"], ["roomno","roomsingle", "roomdouble"]))
            $user->hotel = $data["hotel"];
        else
            $user->hotel = $data["addinfo"];
        $user->leading_people = ($data["leading_people"] === "accyes" ? true : false );
        if($user-> leading_people)
            $user->additional_events = ($data["additional_events"] === "accevyes" ? true : false );
        $user->abstract = $data["abstract"];
        $id=$user->insert();
        Validation::createUserValidation($id);
        return 1;
    }

    /**
     * Check if user is looged in
     * @return bool
     */
    public static function isLogged(){
        if(Session::get("id") === false)
            return false;
        if(!is_numeric(Session::get("id")))
            return false;
        if(intval(Session::get("id")) < 1)
            return false;
        return true;
    }
}