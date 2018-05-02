<?php
/**
 * Created by d0Nt
 * Date: 2018.05.02
 * Time: 09:59
 */

namespace app\controllers;


use core\Helper;

class recaptcha
{
    /**
     * Validate reCaptcha response from google
     * @return bool
     */
    public static function verify(){
        $post_data = http_build_query(
            array(
                'secret' => Helper::config("app")->recaptcha["secret_key"],
                'response' => $_POST['g-recaptcha-response'],
                'remoteip' => $_SERVER['REMOTE_ADDR']
            )
        );
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $post_data
            )
        );
        $context  = stream_context_create($opts);
        $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
        $result = json_decode($response);
        if (!$result->success)
            return false;
        return true;
    }
}