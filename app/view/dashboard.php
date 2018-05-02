{{include "header"}}
<br>
<input button type="button" value="Logout">
<br>
<br>
<input button type="button" value="Invoice information">
<br>
Title:<br>
<input value="{{user.degree}}" disabled><br>
First name:<br>
<input value="{{user.first_name}}" disabled><br>
Last name:<br>
<input value="{{user.last_name}}" disabled><br>
Email:<br>
<input value="{{user.email}}" disabled><br>
<form name="dashboard_form" method="POST" onsubmit="return Dashboard_Form1_Validator(this)" novalidate>
    Institution:<br>
    <input name="institution" value="{{user.institution}}"><br>
    <font color="red">
        <label id="institution_ID">
    </font>
    <br>
    Affiliation:<br>
    <input name="affiliation" value="{{user.affiliation}}"><br>
    <font color="red">
        <label id="affiliation_ID">
    </font>
    <br>
    Phone number:<br>
    <input name="phone_number" value="{{user.phone_number}}"><br>
    <font color="red">
        <label id="phone_number_ID">
    </font>
    <br>
    Article title:<br>
    <input name="article_title" value="{{user.article_title}}"><br>
    <font color="red">
        <label id="article_title_ID">
    </font>
    <br>
    Article authors:<br>
    <input name="article_authors" value="{{user.article_authors}}"><br>
    <font color="red">
        <label id="article_authors_ID">
    </font>
    <br>
    Article authors affiliations:<br>
    <input name="article_authors_affiliations" value="{{user.article_authors_affiliations}}"><br>
    <font color="red">
        <label id="article_authors_affiliations_ID">
    </font>
    <br>
    Do you need to book the hotel room?<br>
    <input type="radio" name="hotel" value="roomno" onclick="isLastChoice(this.value)" required> No<br>
    <input type="radio" name="hotel" value="roomsingle" onclick="isLastChoice(this.value)" required> Single room<br>
    <input type="radio" name="hotel" value="roomdouble" onclick="isLastChoice(this.value)" required> Double room<br>
    <input type="radio" name="hotel" value="roomother" onclick="isLastChoice(this.value)" required> Other<br>
    <p id="otherroom">
        Additional information:<br>
        <textarea type="text" name="addinfo" id="addinfo" rows="4" cols="50"></textarea>
        <br>
        <font color="red">
            <label id="addinfo_ID">
        </font>
        <br>
    </p>
    <br> Will there be people accompanying?<br>
    <input type="radio" name="leading_people" value="accno" onclick="isLastChoice2(this.value)"  required> No <br>
    <input type="radio" name="leading_people" value="accyes" onclick="isLastChoice2(this.value)" required> Yes <br>
    <br>
    <p id="otheraccompany">
        Will people accompanying you be present at additional events?<br>
        <input type="radio" name="additional_events" value="accevno"  required> No <br>
        <input type="radio" name="additional_events" value="accevyes" required> Yes <br>
        <br>
    </p>
    <textarea type="text" name="abstract" value="{{user.abstract}}" placeholder="Abstract" id="abstractfield" rows="4" cols="50" required></textarea>
    <br>
    <font color="red">
        <p id="abstract_ID"></p>
    </font>
    <br>

    <input type="submit" value="Update information">
</form>
<script>
    var registerFormData = {
        registerFields: ([{
            "label": "Institution:",
            "name": "institution",
            "placeholder": "Institution",
            "required": true
        }, {
            "label": "Affiliation:",
            "name": "affiliation",
            "placeholder": "Affiliation",
            "required": true
        }, {
            "label": "Phone number:",
            "name": "phone_number",
            "placeholder": "Phone number",
            "required": true
        }, {
            "label": "Article title:",
            "name": "article_title",
            "placeholder": "Article title",
            "required": true
        }, {
            "label": "Article authors:",
            "name": "article_authors",
            "placeholder": "Article authors",
            "required": true
        }, {
            "label": "Article authors affiliations:",
            "name": "article_authors_affiliations",
            "placeholder": "Affiliations",
            "required": true
        }]),
        registerRoom: ([{
            "label": "Do you need to book the hotel room?",
            "name": "hotel",
            "choices": [{
                "label": "No",
                "value": "roomno",
                "choicename": "choice1",
                "checked": "checked"
            }, {
                "label": "Single room",
                "value": "roomsingle",
                "choicename": "choice1",
                "checked": ""
            }, {
                "label": "Double room",
                "value": "roomdouble",
                "choicename": "choice1",
                "checked": ""
            }, {
                "label": "Other",
                "value": "roomother",
                "choicename": "choice1",
                "checked": ""
            }]
        }]),
        registerRoomOther: ([{
            "label": "Additional information:",
            "name": "addinfo",
            "id": "addinfo"
        }]),
        abstractField: ([{
            "label": "Abstract:",
            "name": "abstract",
            "placeholder": "Abstract",
            "required": true
        }])
    }
</script>
<script src="{{config.directory}}/scripts/dashboard"></script>

<p></p>
{{include "footer"}}