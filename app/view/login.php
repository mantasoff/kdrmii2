{{include "header"}}
<?php

var_dump(\app\models\User::isLogged());
?>
{{message}}
Prisijungti
<form method="post">
    <input type="text" name="email" placeholder="Email address">
    <input type="password" name="password" placeholder="Password">
    <input type="submit" value="Submit">
</form>
{{include "footer"}}