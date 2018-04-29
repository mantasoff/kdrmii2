<?php
/**
 * Created by d0Nt
 * Date: 2018.04.29
 * Time: 23:29
 */

namespace app\models;


class Mail
{
    private $mail;
    private $subject;
    private $text;
    public function __construct($mail, $subject, $text)
    {
        $this->mail = $mail;
        $this->subject = $subject;

    }
    public function send(){
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <webmaster@example.com>' . "\r\n";
        mail($this->mail,$this->subject, $this->text, $headers);
    }
}