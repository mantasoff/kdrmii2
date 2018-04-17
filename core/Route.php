<?php
/**
 * Created by d0Nt
 * Date: 2017.06.01
 * Time: 11:07
 */

namespace core;

class Route
{
    private static $pageLoaded = false;
    private static $_where=[];

    public static function isLoaded(){
        return self::$pageLoaded;
    }

    public static function get($route, $function){
        if(self::$pageLoaded) return;
        $where=self::$_where;
        self::$_where=[];
        if(preg_match('/\{([^]]+)\}/', $route) === 0){
            if(strcmp(Helper::localUrl(),$route)==0){
                $function();
                self::$pageLoaded = true;
            }
            return;
        }else{
            $routeData = explode('/', $route);
            $urlData = explode('/', Helper::localUrl());
            if(count($urlData)!=count($routeData)) return;
            $params = [];
            foreach ($routeData as $key=>$value){
                if(preg_match('/\{([^]]+)\}/', $value) !== 0)
                    array_push($params, self::filterReplace($where, $value, $urlData[$key]));
                else if(strcmp($value, $urlData[$key]) !== 0) return;
            }
            call_user_func_array($function, $params);
            self::$pageLoaded = true;
        }
    }

    public static function post($route, $function){
        if(self::$pageLoaded) return;
        $where=self::$_where;
        self::$_where=[];
        if(preg_match('/\{([^]]+)\}/', $route) === 0){
            if(strcmp(Helper::localUrl(),$route)==0){
                $function();
                self::$pageLoaded = true;
            }
            return;
        }else{
            $routeData = explode('/', $route);
            $params = [];
            $requiredCount = 0;
            foreach ($routeData as $key=>$value){
                if(preg_match('/\{([^]]+)\}/', $value) !== 0) {
                    $requiredCount++;
                    if (isset($_POST[substr($value, 1, -1)]))
                        array_push($params, self::filterReplace($where, $value, $_POST[substr($value, 1, -1)]));
                }
            }
            if(count($params) != $requiredCount) return;
            call_user_func_array($function, $params);
            self::$pageLoaded = true;
        }
    }

    public static function filter($where){
        static::$_where=$where;
        return new self();
    }

    private static function filterReplace($where,$name,$var){
        if($where==null || !is_array($where)) return $var;
        else{
            $regEx=null;
            foreach ($where as $index => $reg){
                if('{'.$index.'}'==$name){
                    $rez=preg_replace("/".$reg."/",'',$var);
                    if($rez==null) return $var;
                    else return $rez;
                    break;
                }
            }
            return $var;
        }
    }

    public static function isAjaxRequest()
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            return true;
        return false;
    }

    public static function defaultRoute($defaultController = "index", $defaultFunction = "index"){
        if(self::isLoaded()) return;
        $controller = $defaultController;
        $function = $defaultFunction;
        $urlExplode = explode('/', Helper::localUrl());
        if(count($urlExplode) > 0)
            $controller=$urlExplode[0];
        if(count($urlExplode) > 1)
            $function = $urlExplode[1];

        $class = "\\app\\controllers\\".$controller."Controller";
        if(!class_exists ($class)){
            $class = "\\app\\controllers\\".$defaultController."Controller";
            $_controller = (new $class());
            if($_controller->canAccess())
                $_controller->$defaultFunction();
            else
                $_controller->noAccess();
            return;
        }
        $_controller = new $class();
        if(!$_controller->canAccess()){
            $_controller->noAccess();
            return;
        }
        if(!method_exists($_controller, $function) || Controller::classParamCount($_controller, $function)>0)
            $function = $defaultFunction;
        $_controller->$function();
    }
}