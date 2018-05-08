<?php
/**
 * Created by d0Nt
 * Date: 2018.04.30
 * Time: 14:20
 */

namespace app\controllers;


use app\models\Mail;
use app\models\User;
use core\Helper;

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
        $link = Helper::host()."/user/validate/".$validation->id."/".$validation->hash;
        $mail = new Mail($user->email,
            "Registration confirmation",
            "<p>Hello ".$user->first_name.",</p>
                    <p>Thank you for registering for 10th International “Data Analysis Methods for Software Systems” workshop.</p>
                    <p>Please confirm your registration: <a target='_blank' href='".$link."'>confirm</a></p>
        ");
        $mail->send();
    }
    /**
     * Send user first password
     * @param $userId
     * @param $validation
     */
    public static function sendPassword($userId){
        $user = new User($userId);
        $password = self::randomString(8);
        $user->setPassword($password);
        $user->save();
        $mail = new Mail($user->email,
            "DAMSS password",
            "<p>Hello ".$user->first_name.",</p>
                    <p>Your registration validated.</p>
                    <p>If you want to change any of your entered information or cancel your participation just login into our website.</p>
                    <p>Your password: ".$password."</p>
        ");
        $mail->send();
    }

    /**
     * Send new generated password
     * @param $userId
     */
    public static function sendNewPassword($userId){
        $user = new User($userId);
        $password = self::randomString(8);
        $user->setPassword($password);
        $user->save();
        $mail = new Mail($user->email,
            "DAMSS password",
            "<p>Hello ".$user->first_name.",</p>
                    <p>Your password has been reset.</p>
                    <p>If you want to change any of your entered information or cancel your participation just login into our website.</p>
                    <p>Your password: ".$password."</p>
        ");
        $mail->send();
    }
    /**
     * Send password change validation
     * @param $userId
     * @param $validation
     */
    public static function sendPasswordValidation($userId, $validation){
        $user = new User($userId);
        $link = Helper::host()."/user/validate/".$validation->id."/".$validation->hash;
        $mail = new Mail($user->email,
            "Registration confirmation",
            "<p>Hello ".$user->first_name.",</p>
                    <p>Password reset request.</p>
                    <p>Please click following link if you want to reset your password.</p>
                    <p>Your : ".$link."</p>
        ");
        $mail->send();
    }
}