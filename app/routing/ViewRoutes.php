<?php
/**
 * Returns image from view directory
 */
\core\Route::get("images/{image}", function($image){
    $file = "app/view/images/".$image;
    $fp = fopen($file, 'rb');
    if($fp === false) return;
    header("Content-Type: image/png");
    header("Content-Length: " . filesize($file));
    fpassthru($fp);
    exit;
});
/**
 * Returns style from view directory
 */
\core\Route::get("styles/{style}", function($style){
    header('Content-Type: text/css');
    $file ="app/view/css/".$style.".css";

    if(!file_exists($file))
        echo "Failed to load style file $style.css";
    else
        (new \core\View())->renderCss($style);
    exit;
});
/**
 * Returns javascript from view directory
 */
\core\Route::get("scripts/{js}", function($js){
    header('Content-Type: application/javascript');
    $file ="app/view/js/".$js.".js";

    if(!file_exists($file))
        echo "Failed to load javascript file $js.js file";
    else
        (new \core\View())->renderJs($js);
    exit;
});