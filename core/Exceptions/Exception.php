<?php
/**
 * Created by d0Nt
 * Date: 2018.04.26
 * Time: 08:56
 */

namespace core\Exceptions;


use core\Helper;

class Exception
{
    protected $response_code;
    protected $message;
    protected $success = false;
    private $force_print_type = ExceptionsPrintTypes::Config;
    /**
     * Error constructor.
     * @param $response_code
     * @param $message
     */
    public function __construct($response_code, $message)
    {
        $this->response_code = $response_code;
        $this->message = $message;
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

    /**
     * Print exception as string
     * @return $this
     */
    public function printString(){
        echo $this->response_code."<br>". $this->message;
        http_response_code ($this->response_code);
        return $this;
    }

    /**
     * Print exception in json format
     * @return $this
     */
    public function printJson(){
        echo json_encode([
            "success" => $this->success,
            "message" => $this->message
        ]);
        http_response_code ($this->response_code);
        return $this;
    }

}