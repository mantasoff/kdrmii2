<?php
/**
 * Created by d0Nt
 * Date: 2018.03.24
 * Time: 23:20
 */

namespace app\models;


use core\Model;

class User extends Model
{
    protected static $table = "player";
    protected static $selectFields = ["id", "name", "password"];
}