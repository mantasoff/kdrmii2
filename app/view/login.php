{{include "header"}}
<?php

var_dump(\app\models\User::isLogged());
?>
<br>
{{message}}
Login
<form name="login_form" method="POST" onsubmit="return Login_Form1_Validator(this)" novalidate>
    <br>
    <input type="text" name="email" placeholder="Email address" required><br>
    <font color="red">
        <p id="email_ID"></p>
    </font>
    <br>
    <input type="password" name="password" placeholder="Password" required><br>
    <font color="red">
        <p id="password_ID"></p>
    </font>
    <br>
    <input type="submit" value="Login">
    <br><br>
    <p><a href="{{config.directory}}/user/passwordReset">Forgot password?</a></p>
</form>
<script>
    var loginFormData = {
        emailField: ([{
            "name": "email",
            "placeholder": "Email",
            "required": true
        }]),
        passwordField: ([{
            "name": "password",
            "placeholder": "Password",
            "required": true
        }])
    }
</script>
<script src="{{config.directory}}/scripts/login"></script>
{{include "footer"}}