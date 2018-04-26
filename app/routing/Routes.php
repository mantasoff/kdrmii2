<?php
\core\Route::get("user/validate/{id}/{hash}", function($id, $hash){
    (new \app\controllers\userController())->validate($id, $hash);
});