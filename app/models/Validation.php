<?php
/**
 * Created by d0Nt
 * Date: 2018.03.24
 * Time: 23:20
 */

namespace app\models;


use app\controllers\mailController;
use core\Database\Field;
use core\Database\Mysql;
use core\Database\Query;
use core\Model;

class Validation extends Model
{
    protected static $table = "email_validation";
    protected static $idColumn = "id";
    protected static $selectFields = ["id","user_id","hash", "valid_till", "type"];
    protected static $saveFields = ["user_id","hash","valid_till", "type"];

    /**
     * Delete old validation records
     */
    public static function clearOld(){
        $validations = Validation::all();
        if($validations == null) return;
        if(is_array($validations)){
            foreach ($validations as $validation){
                if(intval($validation->valid_till) > time()) continue;
                $validation->delete();
                if($validation->type == "validate"){
                    $user = new User($validation->user_id);
                    if($user->id != null && $user->validated != 1)
                        $user->delete();
                }
            }
        }
    }

    /**
     * Create user validation in database
     * @param $userId
     * @param $type
     */
    public static function createUserValidation($userId, $type="validate"){
        if($type == "reset"){
            Mysql::execute((new Query())->table(static::$table)->delete()->where([new Field("user_id", $userId),new Field("type", $type)]));
        }
        $validation = new Validation();
        $validation->type = $type;
        $validation->user_id = $userId;
        $validation->hash = mailController::randomString(10);
        $validation->valid_till = time()+86400;
        $validation->insert();
        if($type == "validate") mailController::sendMailValidation($userId, $validation);
        else mailController::sendPasswordValidation($userId, $validation);
    }
}