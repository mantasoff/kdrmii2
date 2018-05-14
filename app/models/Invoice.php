<?php
/**
 * Created by d0Nt
 * Date: 2018.03.24
 * Time: 23:20
 */

namespace app\models;


use core\Database\Field;
use core\Database\Mysql;
use core\Database\Query;
use core\Model;
use core\Session;

class Invoice extends Model
{
    protected static $table = "invoice";
    protected static $idColumn = "invoice_id";
    protected static $selectFields = ["invoice_id", "requesting_user", "company_name", "company_address", "company_code", "bank_code", "generated"];
    protected static $saveFields = ["requesting_user", "company_name", "company_address", "company_code", "bank_code", "generated"];

    /**
     * Invoice model fields validation
     * @var array
     */

    protected static $validations = [
        "company_name" => [
            "name" => "Institution name",
            "min" => 3,
            "max" => 255
        ],
        "company_address" => [
            "name" => "Institution address",
            "min" => 3,
            "max" => 255
        ],
        "company_code" => [
            "name" => "Institution code",
            "min" => 3,
            "max" => 255
        ],
        "bank_code" => [
            "name" => "Bank code",
            "min" => 3,
            "max" => 255
        ]
    ];

    /**
     * Update data
     *
     * @param [type] $data
     * @return void
     */
    public static function update($data)
    {
        Mysql::execute((new Query())->table(static::$table)->delete()->where(new Field("requesting_user", Session::get("id"))));
        $invoice = new Invoice();
        $invoice->requesting_user = Session::get("id");
        foreach ($data as $key=>$value){
            $invoice->$key = $value;
        }
        $invoice->insert();
        return $invoice;
    }
}