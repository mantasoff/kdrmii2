<?php

/**
 * Created by d0Nt
 * Date: 2018.03.23
 * Time: 17:12
 */
namespace core\Exceptions;
class Error
{
    private $error_code;
    private $error_message;

    /**
     * Error constructor.
     * @param $error_code
     * @param $error_message
     */
    public function __construct($error_code, $error_message)
    {
        $this->error_code = $error_code;
        $this->error_message = $error_message;
    }

    public function print(){
        echo $this->error_code."<br>". $this->error_message;
        return $this;
    }

    public function printJson(){
        echo json_encode([
            "success" => false,
            "response_code" => $this->error_code,
            "message" => $this->error_message
        ]);
        return $this;
    }
}