{{include "header"}}
<p class="MsoNormal">
    <span style="font-size: 10pt; line-height: 107%;">
        If you want to <b>delete</b> your registration enter your password.
    </span>
</p>
{{message}}<br>
<form method="post">
    <input name="password" type="password" placeholder="Password">
    <br><br>
    <input class="danger" type="submit" value="Confirm">
    <a href="{{config.directory}}/dashboard"><input type="button" value="Cancel"></a>
</form>
{{include "footer"}}