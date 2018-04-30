<?php
\core\Route::get("user/validate/{id}/{hash}", function($id, $hash){
    (new \app\controllers\userController())->validate($id, $hash);
});
/**
 * Returns image from other directory
 */
\core\Route::get("images/{image}", function($image){
    $file = "app/view/images/".$image;
    $fp = fopen($file, 'rb');
    header("Content-Type: image/png");
    header("Content-Length: " . filesize($file));
    fpassthru($fp);
    exit;
});