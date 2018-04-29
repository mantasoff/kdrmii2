<?php
/**
 * Created by d0Nt
 * Date: 2018.03.24
 * Time: 23:20
 */

namespace app\models;


use core\Database\Field;
use core\Database\Mysql;
use core\Database\Query;
use core\Model;

class Validation extends Model
{
    protected static $table = "email_validation";
    protected static $selectFields = ["id","user_id","hash", "valid_till"];
    protected static $saveFields = ["user_id","hash","valid_till"];

    /**
     * Delete old validation records
     */
    public static function clearOld(){
        Mysql::execute((new Query())->table(static::$table)->delete()->where([Field::customSeparator("valid_till",time()-86400,'<')]));
    }

    /**
     * Generate random string
     * @param int $length string length
     * @return string
     */
    public static function randomString($length = 5){
        $randomBytes = openssl_random_pseudo_bytes($length);
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $result = '';
        for ($i = 0; $i < $length; $i++)
            $result .= $characters[ord($randomBytes[$i]) % $charactersLength];
        return $result;
    }

    /**
     * Create user validation in database
     * @param $userId
     */
    public static function createUserValidation($userId){
        $validation = new Validation();
        $validation->user_id = $userId;
        $validation->hash = self::randomString(10);
        $validation->valid_till = time()+86400;
        $validation->insert();
        self::sendMailValidation($userId, $validation);
    }

    /**
     * Send user mail validation
     * @param $userId
     * @param $validation
     */
    public static function sendMailValidation($userId, $validation){
        $user = new User($userId);
        $link = "validate/".$validation->id."/".$validation->hash;
        $mail = new Mail($user->email,
            "Registracijos patvirtinimas",
            "Norint patvirtinti slaptažodį paspauskite ant nuorodos: <a href='".$link."'>atstatyti slaptažodį</a>.");
        $mail->send();
    }
}