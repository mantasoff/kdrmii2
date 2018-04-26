<?php
/**
 * Created by d0Nt
 * Date: 2018.04.07
 * Time: 19:05
 */

namespace core;


class Security
{
    public static function markdown_decode($input){
        $input=preg_replace("/(on.*?=)/i", "", $input);
        $input=preg_replace('/:iframe:\[(.+?)\]/', '<iframe allow="autoplay; encrypted-media" allowfullscreen="true" frameborder="0" height="270" src="$1" width="480"></iframe>', $input);
        $input=preg_replace("/:img:\[(.+?)\]/", "<img src='$1'>", $input);
        $input=preg_replace("/:b:\[(.+?)\]/", "<b>$1</b>", $input);
        $input=preg_replace("/:i:\[(.+?)\]/", "<i>$1</i>", $input);
        $input=preg_replace("/:u:\[(.+?)\]/", "<u>$1</u>", $input);
        $input=preg_replace("/::br:/", "<br>", $input);
        $input=preg_replace("/:center:\[(.+?)\]/", "<div style='text-align: center;'>$1</div>", $input);
        $input=preg_replace("/:left:\[(.+?)\]/", "<div style='text-align: left;'>$1</div>", $input);
        $input=preg_replace("/:right:\[(.+?)\]/", "<div style='text-align: right;'>$1</div>", $input);
        $input=preg_replace("/:justify:\[(.+?)\]/", "<div style='text-align: justify;'>$1</div>", $input);
        $input=preg_replace("/:strike:\[(.+?)\]/", "<strike>$1</strike>", $input);
        return $input;
    }
    public static function markdown_encode($input){
        $input=preg_replace("/<b>(.+?)<\/b>/", ":b:[$1]", $input);
        $input=preg_replace("/<u>(.+?)<\/u>/", ":u:[$1]", $input);
        $input=preg_replace("/<i>(.+?)<\/i>/", ":i:[$1]", $input);
        $input=preg_replace('/<iframe.+?src=\"(.+?)\".+?><\/iframe>/', ":iframe:[$1]", $input);
        $input=preg_replace('/<img.+?src=\"(.+?)\".+?>/', ":img:[$1]", $input);
        $input=preg_replace("/<br>/", "::br:", $input);
        $input=preg_replace('/<div style=\"text-align: center;\">(.+?)<\/div>/', ":center:[$1]", $input);
        $input=preg_replace('/<div style=\"text-align: left;\">(.+?)<\/div>/', ":left:[$1]", $input);
        $input=preg_replace('/<div style=\"text-align: right;\">(.+?)<\/div>/', ":right:[$1]", $input);
        $input=preg_replace('/<div style=\"text-align: justify;\">(.+?)<\/div>/', ":justify:[$1]", $input);
        $input=preg_replace('/<strike>(.+)<\/strike>/', ":strike:[$1]", $input);
        return $input;
    }
    public static function html_encode($text){
        $text = htmlspecialchars_decode($text);
        $text = self::markdown_encode($text);
        $text = strip_tags($text);
        $text = htmlspecialchars($text);
        return $text;
    }
    public static function html_decode($text){
        $text = htmlspecialchars_decode($text);
        $text = self::markdown_decode($text);
        return $text;
    }
}