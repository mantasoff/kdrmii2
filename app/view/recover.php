{{include "header"}}
<br>
{{message}}
Please enter the email that you used for registration. We will send you the password.
<form name="recover_form" method="POST" onsubmit="return Recover_Form1_Validator(this)" novalidate>
    <br><br>
    <input type="text" name="email" placeholder="Email address" required><br>
    <font color="red">
        <p id="email_ID"></p>
    </font>
    <br>
    <input type="submit" value="Send password">
</form>
<script>
    var recoverFormData = {
        emailField: ([{
            "name": "email",
            "placeholder": "Email",
            "required": true
        }])
    }
</script>
<script src="{{config.directory}}/scripts/recover"></script>
{{include "footer"}}