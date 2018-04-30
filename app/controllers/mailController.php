<?php
/**
 * Created by d0Nt
 * Date: 2018.04.30
 * Time: 14:20
 */

namespace app\controllers;


use app\models\Mail;
use app\models\User;

class mailController
{
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
     * Send user mail validation
     * @param $userId
     * @param $validation
     */
    public static function sendMailValidation($userId, $validation){
        $user = new User($userId);
        $link = "validate/".$validation->id."/".$validation->hash;
        $mail = new Mail($user->email,
            "Registration confirmation",
            "<p>Hello ".$user->name.",</p>
                    <p>Thank you for registering for 10th International “Data Analysis Methods for Software Systems” workshop.</p>
                    <p>Please confirm your registration: <a href='".$link."'>confirm</a></p>
        ");
        $mail->send();
    }
}