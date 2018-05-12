{{include "header"}}
<link href="{{config.directory}}/styles/dashboard" type="text/css" rel="stylesheet">
<br>
<a href="{{config.directory}}/user/logout"><input class="top" type="button" value="Logout"></a>
<a href="{{config.directory}}/dashboard/invoice"><input class="top" type="button" value="Invoice information"></a>
<a href="{{config.directory}}/user/delete"><input class="top danger" type="button" value="Delete registration"></a>
{{message}}
<br>
Title:<br>
<input value="{{user.degree}}" disabled><br>
<br>
First name:<br>
<input value="{{user.first_name}}" disabled><br>
<br>
Last name:<br>
<input value="{{user.last_name}}" disabled><br>
<br>
Email:<br>
<input value="{{user.email}}" disabled><br>
<br>
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
    Abstract:<br>
    <textarea name="abstract" placeholder="Abstract" id="abstractfield" rows="4" cols="50" required>{{user.abstract}}</textarea>
    <font color="red">
        <p id="abstract_ID"></p>
    </font>
    <br>
    Do you need to book the hotel room?<br>
    <input type="radio" name="hotel" value="roomno" onclick="isLastChoice(this.value)" required <?php if($user["hotel"]==="roomno") echo "checked";?>> No<br>
    <input type="radio" name="hotel" value="roomsingle" onclick="isLastChoice(this.value)" required <?php if($user["hotel"]==="roomsingle") echo "checked";?>> Single room<br>
    <input type="radio" name="hotel" value="roomdouble" onclick="isLastChoice(this.value)" required <?php if($user["hotel"]==="roomdouble") echo "checked";?>> Double room<br>
    <input type="radio" name="hotel" value="roomother" onclick="isLastChoice(this.value)" required <?php if(!in_array($user["hotel"],["roomno","roomsingle","roomdouble"])) echo "checked";?>> Other<br>
    <p id="otherroom" <?php if(in_array($user["hotel"],["roomno","roomsingle","roomdouble"])) echo "style='display: none'";?>>
        Additional information:<br>
        <textarea name="addinfo" id="addinfo" rows="4" cols="50"><?php if(!in_array($user["hotel"],["roomno","roomsingle","roomdouble"])) echo $user["hotel"]; ?></textarea>
        <br>
        <font color="red">
            <label id="addinfo_ID">
        </font>
        <br>
    </p>
    <br> Will there be people accompanying?<br>
    <input type="radio" name="leading_people" value="accno" onclick="isLastChoice2(this.value)"  required <?php if($user["leading_people"] != "1") echo "checked";?>> No <br>
    <input type="radio" name="leading_people" value="accyes" onclick="isLastChoice2(this.value)" required <?php if($user["leading_people"] == "1") echo "checked";?>> Yes <br>
    <br>
    <p id="otheraccompany" <?php if($user["leading_people"] != "1") echo "style='display:none;'"; ?>>
        Will people accompanying you be present at additional events?<br>
        <input type="radio" name="additional_events" value="accevno"  required <?php if($user["additional_events"] != "1") echo "checked";?>> No <br>
        <input type="radio" name="additional_events" value="accevyes" required <?php if($user["additional_events"] == "1") echo "checked";?>> Yes <br>
        <br>
    </p>
    <br>

    <input type="submit" value="Update information">
</form>
<script>
    var dashboardFormData = {
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