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
    protected static $table = "users";
    protected static $selectFields = ["id", "email", "password", "institution", "degree", "first_name",
        "last_name", "affiliation","phone_number", "article_title", "article_authors", "hotel", "leading_people","abstract"];
    protected static $saveFields = ["email", "institution", "degree", "first_name",
        "last_name", "affiliation","phone_number", "article_title", "article_authors", "hotel", "leading_people","abstract"];
}