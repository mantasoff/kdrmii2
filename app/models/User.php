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

    protected static $validations = [
        "email" => [
            "name" => "Mail",
            "regex" => '/^[A-Za-z0-9.]+@[A-Za-z.]+\.[A-Za-z0-9]+$/',
            "max" => 100
        ],
        "institution" => [
            "name" => "Institution",
            "min" => 3,
            "max" => 100
        ],
        "hotel" => [
            "values" => ["roomother", "roomno", "roomsingle", "roomdouble"]
        ],
        "leading_people" => [
            "values"=> ["accyes", "accno"]
        ],
        "degree" => [
            "max" => 12
        ],
        "invoice_required" => [
            "values" => ["invyes","invno"]
        ],
        "additional_events" => [
            "values" => ["accevyes","accevno"]
        ],
        "first_name" => [
            "max" => 64
        ],
        "last_name" => [
            "max" => 64
        ],
        "affiliation" =>[
            "max" => 255
        ],
        "phone_number" => [
            "max" => 18,
            "regex" => "/^[0-9+ ]+$/"
        ],
        "article_title" => [
            "max" => 255,
        ],
        "article_authors" => [
            "max" => 300
        ],
        "article_authors_affiliations" => [
            "max" => 300
        ],
        "abstract" => [
            "max" => 800
        ],
        "hotel_info" => [
            "max" => 64
        ]

    ];
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
        $requiredParams=["degree", "first_name", "last_name", "institution", "affiliation", "email", "phone_number", "article_title",
            "article_authors", "article_authors_affiliations", "hotel", "leading_people", "abstract"];
        foreach ($requiredParams as $param){
            if(!isset($data[$param]) || $data[$param] === null || $data[$param] === "" || strlen($data[$param])<2){
                return $param." is required";
            }
        }
        $validate = self::validate($data);
        if($validate != true)
            return $validate;
        if($data["hotel"] === "roomother" &&
            (!isset($data["hotel_info"]) || $data["hotel_info"] === null || $data["hotel_info"] === "" || strlen($data["hotel_info"])<2)) {
            return "Additional information about room is required";
        }
        $withMail = User::getByFields([new Field("email", $data["email"])]);
        if($withMail !== null){
            return "User with this email already exist.";
        }
        return true;
    }

    /**
     * Update user data from data array
     * @param $data
     */
    public function updateFromData($data){
        foreach ($data as $key => $value)
            $this->$key = $value;
        if(Post::get("hotel") == "roomother")
            $this->hotel = Post::get("addinfo");
        $this->leading_people = ($data["leading_people"] == "accyes" ? 1 : 0 );
        if($this-> leading_people === 1)
            $this->additional_events = $data["additional_events"] == "accevyes" ? 1 : 0 ;
        else
            $this->additional_events = 0;
    }
    /**
     * Check and update user data.
     * @param $data array Data to update user with
     * @param $params array Variables to update
     */
    public function updateData($data){
        $this->updateFromData($data);
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
        $user->updateFromData($data);
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