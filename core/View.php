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

    private function fileContent($path){
        ob_start();
        include($path);
        $content = ob_get_contents();
        ob_end_clean();
        return $this->replacements($content);
    }
    private function replacements($content){
        foreach ($this->data as $key=>$value){
            if(is_array($value)){
                foreach ($value as $_key=>$_value)
                    $content = str_replace("{{".$key.".".$_key."}}", $_value, $content);
            }
            else $content = str_replace("{{".$key."}}", $value, $content);
        }
        $content = preg_replace_callback('~{{include "(.+?)"}}~',
            function($m)
            {
                if(file_exists("app/view/".$m[1].".php"))
                    return $this->fileContent("app/view/".$m[1].".php");
                return $m[0];
            }, $content);
        return $content;
    }
    public function render($path, $moreParams = [])
    {
        if(!empty($moreParams))
            foreach($moreParams as $key=>$value)
                $this->$key = $value;
        $this->data["config"] = (array)Helper::config("app");
        extract($this->data);
        if(file_exists("app/view/".$path.".php"))
            echo $this->fileContent("app/view/".$path.".php");
    }
}