<?php
/**
 * Created by d0Nt
 * Date: 2018.03.24
 * Time: 23:20
 */

namespace app\models;


use core\Model;

class Invoice extends Model
{
    protected static $table = "invoice";
    protected static $selectFields = ["id", "user_id", "hash"];
    protected static $saveFields = ["user_id", "hash"];
}