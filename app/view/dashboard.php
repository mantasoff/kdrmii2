{{include "header"}}
{{message}}
Title:<br>
<input value="{{user.degree}}" disabled><br>
First name:<br>
<input value="{{user.first_name}}" disabled><br>
Last name:<br>
<input value="{{user.last_name}}" disabled><br>
Email:<br>
<input value="{{user.email}}" disabled><br>
<form method="post">
    Institution:<br>
    <input name="institution" value="{{user.institution}}"><br>
    Affiliation:<br>
    <input name="affiliation" value="{{user.affiliation}}"><br>
    Phone number:<br>
    <input name="phone_number" value="{{user.phone_number}}"><br>
    Article title:<br>
    <input name="article_title" value="{{user.article_title}}"><br>
    Article authors:<br>
    <input name="article_authors" value="{{user.article_authors}}"><br>
    Article authors affiliations:<br>
    <input name="article_authors_affiliations" value="{{user.article_authors_affiliations}}"><br>
    <input type="submit">
</form>
{{include "footer"}}