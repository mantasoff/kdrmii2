<?php
/**
 * Created by d0Nt
 * Date: 2018.04.29
 * Time: 23:29
 */

namespace app\models;


use core\Helper;
use core\View;

class Mail
{
    private $mail;
    private $subject;
    private $text;
    public function __construct($mail, $subject, $text)
    {
        $this->mail = $mail;
        $this->subject = $subject;
        $this->text = (new View())->rendered("other/mail", ["content" => $text]);
    }

    /**
     * Send function route
     */

    public function send(){
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <'.Helper::config('app')->mail.'>' . "\r\n";
        mail($this->mail,$this->subject, $this->text, $headers);
    }
}