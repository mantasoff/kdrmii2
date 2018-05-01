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
    protected static $selectFields = ["invoice_id", "requesting_user", "company_name","company_adress","company_code","bank_code"];
    protected static $saveFields = ["requesting_user", "company_name","company_code","company_invoice","bank_code"];

    public function validateData($data){
        if(!isset($data["institutionname"]) || strlen($data["institutionname"]) > 255) {
                 return "Company name is too long.";
        }
        if(!isset($data["institutionaddress"]) || strlen($data["institutionaddress"]) > 255) {
            return "Company invoice is too long.";
        }
        if(!isset($data["otherinvoice"]) || strlen($data["otherinvoice"]) > 255) {
            return "Company name is too long.";
        }
        if(!isset($data["institutionbankcode"]) || strlen($data["institutionbankcode"]) > 255) {
            return "Bank code is too long.";
        }
        return 1;
    }
}