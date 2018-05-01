<?php
/**
 * Created by d0Nt
 * Date: 2018.03.24
 * Time: 22:08
 */

namespace core;

class View
{
    private $data = [];
    public function setVar($varName, $value){
        $this->data[$varName] = $value;
    }

    function __set($name, $value){
        $this->setVar($name, $value);
    }

    private function fileContent($path, $dataToExtract=[]){
        extract($dataToExtract);
        ob_start();
        include($path);
        $content = ob_get_contents();
        ob_end_clean();
        return $this->replacements($content, $dataToExtract);
    }
    private function replacements($content, $dataToExtract=[]){
        foreach ($this->data as $key=>$value){
            if(is_array($value)){
                foreach ($value as $_key=>$_value)
                    $content = str_replace("{{".$key.".".$_key."}}", $_value, $content);
            }
            else $content = str_replace("{{".$key."}}", $value, $content);
        }
        $content = preg_replace_callback('~{{include "(.+?)"}}~',
            function($m) use($dataToExtract)
            {
                if(file_exists("app/view/".$m[1].".php"))
                    return $this->fileContent("app/view/".$m[1].".php", $dataToExtract);
                return $m[0];
            }, $content);
        $content = preg_replace_callback('~{{function (.+?)}}~',
            function($m)
            {
                $params = explode(",", $m[1]);
                $function = $params[0];
                array_shift($params);
                return call_user_func_array($function, $params);
            }, $content);
        return $content;
    }
    public function renderCss($path){
        $this->data["config"] = (array)Helper::config("app");
        if(file_exists("app/view/css/".$path.".css")) {
            echo preg_replace(
                array(
                    // Remove comment(s)
                    '#\s*("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')\s*|\s*\/\*(?!\!|@cc_on)(?>[\s\S]*?\*\/)\s*|\s*(?<![\:\=])\/\/.*(?=[\n\r]|$)|^\s*|\s*$#',
                    // Remove white-space(s) outside the string and regex
                    '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/)|\/(?!\/)[^\n\r]*?\/(?=[\s.,;]|[gimuy]|$))|\s*([!%&*\(\)\-=+\[\]\{\}|;:,.<>?\/])\s*#s',
                    // Remove the last semicolon
                    '#;+\}#',
                ),
                array(
                    '$1',
                    '$1$2',
                    '}',
                ),
                $this->fileContent("app/view/css/" . $path . ".css"));
        }
    }
    public function renderJs($path){
        $this->data["config"] = (array)Helper::config("app");
        if(file_exists("app/view/js/".$path.".js")) {
            if(strpos($path, ".min") !== false) echo $this->fileContent("app/view/js/" . $path . ".js");
            else echo preg_replace(
                array(
                    // Remove comment(s)
                    '#\s*("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')\s*|\s*\/\*(?!\!|@cc_on)(?>[\s\S]*?\*\/)\s*|\s*(?<![\:\=])\/\/.*(?=[\n\r]|$)|^\s*|\s*$#',
                    // Remove white-space(s) outside the string and regex
                    '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/)|\/(?!\/)[^\n\r]*?\/(?=[\s.,;]|[gimuy]|$))|\s*([!%&*\(\)\-=+\[\]\{\}|;:,.<>?\/])\s*#s',
                    // Remove the last semicolon
                    '#;+\}#',
                    // Minify object attribute(s) except JSON attribute(s). From `{'foo':'bar'}` to `{foo:'bar'}`
                    '#([\{,])([\'])(\d+|[a-z_][a-z0-9_]*)\2(?=\:)#i',
                    // --ibid. From `foo['bar']` to `foo.bar`
                    '#([a-z0-9_\)\]])\[([\'"])([a-z_][a-z0-9_]*)\2\]#i'
                ),
                array(
                    '$1',
                    '$1$2',
                    '}',
                    '$1$3',
                    '$1.$3'
                ),
                $this->fileContent("app/view/js/" . $path . ".js"));
        }
    }

    public function rendered($path, $moreParams = []){
        if(!empty($moreParams))
            foreach($moreParams as $key=>$value)
                $this->$key = $value;
        if(isset($_SESSION))
            $this->data["session"] = $_SESSION;
        $this->data["config"] = (array)Helper::config("app");
        if(file_exists("app/view/".$path.".php"))
            return $this->fileContent("app/view/".$path.".php", $this->data);
        return null;
    }

    public function render($path, $moreParams = [])
    {
        echo self::rendered($path, $moreParams);
    }
}