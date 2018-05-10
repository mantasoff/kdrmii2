<?php
\core\Route::get("user/validate/{id}/{hash}", function($id, $hash){
    (new \app\controllers\userController())->validate($id, $hash);
});
/**
 * Admin routes
 */
\core\Route::get("admin/update/{id}", function($id){
    (new \app\controllers\adminController())->update($id);
});
\core\Route::get("admin/delete/{id}", function($id){
    (new \app\controllers\adminController())->delete($id);
});

require("ViewRoutes.php");