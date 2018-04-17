<?php
/**
 * Created by d0Nt
 * Date: 2018.03.30
 * Time: 11:37
 */

namespace core\Exceptions;


use core\BasicEnum;

class ExceptionsPrintTypes extends BasicEnum
{
    const Json = 0;
    const String = 1;
    const Config = 2;
}