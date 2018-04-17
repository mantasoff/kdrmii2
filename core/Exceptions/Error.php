<?php

/**
 * Created by d0Nt
 * Date: 2018.03.23
 * Time: 17:12
 */
namespace core\Exceptions;
use core\Helper;

class Error
{

    private $error_code;
    private $error_message;
    private $force_print_type = ExceptionsPrintTypes::Config;
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

    public function printData(){
        if($this->force_print_type == ExceptionsPrintTypes::Config){
            if(!isset(Helper::config("app")->error_format) || Helper::config("app")->error_format == ExceptionsPrintTypes::String)
                $this->printString();
            else
                $this->printJson();
        }
        else if($this->force_print_type == ExceptionsPrintTypes::Json)
            $this->printJson();
        else
            $this->printString();
    }

    public function forcePrintType($printType){
        if(ExceptionsPrintTypes::isValidValue($printType))
            $this->force_print_type = $printType;
        else{
            (new Error(500, "Bad parameter in forcePrintType"))->printData();
            die();
        }
    }

    private function printString(){
        echo $this->error_code."<br>". $this->error_message;
        return $this;
    }

    private function printJson(){
        echo json_encode([
            "success" => false,
            "response_code" => $this->error_code,
            "message" => $this->error_message
        ]);
        return $this;
    }
}