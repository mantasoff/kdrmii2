<?php

/**
 * Created by d0Nt
 * Date: 2018.03.23
 * Time: 17:12
 */
namespace core\Exceptions;

class Success extends Exception
{
    public function __construct($response_code, $message)
    {
        $this->success = true;
        parent::__construct($response_code, $message);
    }
}