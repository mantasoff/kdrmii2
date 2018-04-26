<?php
/**
 * Created by d0Nt
 * Date: 2018.04.26
 * Time: 08:56
 */

namespace core\Exceptions;


class Exception
{
    protected $response_code;
    protected $message;
    protected $success = false;
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