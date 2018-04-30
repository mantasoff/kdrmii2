<?php

/**
 * Created by d0Nt
 * Date: 2018.03.23
 * Time: 17:12
 */
namespace core\Exceptions;
class Error extends Exception
{
    public function __construct($response_code, $message)
    {
        $this->success = false;
        parent::__construct($response_code, $message);
    }
}