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
    protected static $selectFields = ["invoice_id", "requesting_user", "company_name","company_code","company_invoice","bank_code"];
    protected static $saveFields = ["requesting_user", "company_name","company_code","company_invoice","bank_code"];
}