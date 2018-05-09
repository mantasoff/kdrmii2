<?php
/**
 * Created by d0Nt
 * Date: 2018.05.09
 * Time: 14:18
 */

namespace app\controllers;


use app\models\Validation;
use core\Controller;

class cronController extends Controller
{
    public function index(){}

    /**
     * Clear old records
     */
    public function clear(){
        Validation::clearOld();
    }
}