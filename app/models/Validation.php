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
        $hash = self::randomString(10);
        $validation = new Validation();
        $validation->user_id = $userId;
        $validation->hash = $hash;
        $validation->valid_till = time()+86400;
        $validation->insert();
        self::sendMailValidation($userId, $hash);
    }

    /**
     * Send user mail validation
     * @param $userId
     * @param $hash
     */
    public static function sendMailValidation($userId, $hash){
        $mail = new Mail();
        $link = "validate/5/dfafadsfasdfgdasgdsfas";
        $mail->send();
    }
}