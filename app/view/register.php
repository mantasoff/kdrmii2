{{include "header"}}
<script src='https://www.google.com/recaptcha/api.js'></script>
<p class="MsoNormal">
    <span style="font-size: 10pt; line-height: 107%;">
        We ask those willing to participate and give a talk at the conference to register and send
        us the talk title in Lithuanian and English as well as a short abstract in
        English (up to 300 words). The deadline for registration and abstract
        submission is 10th of September 2018.
    </span>
</p>

<p class="MsoNormal"><span style="font-size: 10pt; line-height: 107%;">&nbsp;</span></p>
<p class="MsoNormal"><span style="font-size: 10pt; line-height: 107%;"></span></p>
{{message}}
<form name="reg_form" action="{{config.directory}}/user/register" method="POST" onsubmit="return FrontPage_Form1_Validator(this)" novalidate>
    <label for="degree">Title: (Prof/Dr/Mr/Mrs/Ms)</label>
    <select name="degree">
        <option value="Prof">Prof</option>
        <option value="Dr">Dr</option>
        <option value="Mr">Mr</option>
        <option value="Mrs">Mrs</option>
        <option value="Ms">Ms</option>
    </select>
    <br> First Name:<br>
    <input type="text" name="first_name" placeholder="First Name" oninput="notEmpty(this.name, this.value)" size="26" required> <br>
    <font color="red">
        <p id="first_name_ID"></p>
    </font>
    Last Name:<br>
    <input type="text" name="last_name" placeholder="Last Name" oninput="notEmpty(this.name, this.value)" size="26" required> <br>
    <font color="red">
        <p id="last_name_ID"></p>
    </font>
    Institution:<br>
    <input type="text" name="institution" placeholder="Institution" oninput="notEmpty(this.name, this.value)" size="26" required> <br>
    <font color="red">
        <p id="institution_ID"></p>
    </font>
    Affiliation:<br>
    <input type="text" name="affiliation" placeholder="Affiliation" oninput="notEmpty(this.name, this.value)" size="26" required> <br>
    <font color="red">
        <p id="affiliation_ID"></p>
    </font>
    E-Mail:<br>
    <input type="email" name="email" placeholder="Email" oninput="notEmpty(this.name, this.value)" size="26" required> <br>
    <font color="red">
        <p id="email_ID"></p>
    </font>
    Phone number:<br>
    <input type="text" name="phone_number" placeholder="Phone number" oninput="notEmpty(this.name, this.value)" size="26" required> <br>
    <font color="red">
        <p id="phone_number_ID"></p>
    </font>
    Article title:<br>
    <input type="text" name="article_title" placeholder="Article title" oninput="notEmpty(this.name, this.value)" size="26" required> <br>
    <font color="red">
        <p id="article_title_ID"></p>
    </font>
    Article authors:<br>
    <input type="text" name="article_authors" placeholder="Article authors" oninput="notEmpty(this.name, this.value)" size="26" required> <br>
    <font color="red">
        <p id="article_authors_ID"></p>
    </font>
    Article authors affiliations:<br>
    <input type="text" name="article_authors_affiliations" placeholder="Affiliations" oninput="notEmpty(this.name, this.value)" size="26" required> <br>
    <font color="red">
        <p id="article_authors_affiliations_ID"></p>
    </font>

    Abstract:<br>
    <textarea type="text" name="abstract" placeholder="Abstract" id="abstractfield" rows="4" cols="50" required></textarea>
    <br>
    <font color="red">
        <p id="abstract_ID"></p>
    </font>
    Do you need to book the hotel room?<br>
    <input type="radio" name="hotel" value="roomno" onclick="isLastChoice(this.value)" checked required> No<br>
    <input type="radio" name="hotel" value="roomsingle" onclick="isLastChoice(this.value)" required> Single room<br>
    <input type="radio" name="hotel" value="roomdouble" onclick="isLastChoice(this.value)" required> Double room<br>
    <input type="radio" name="hotel" value="roomother" onclick="isLastChoice(this.value)" required> Other<br>
    <p id="otherroom">
        Additional information:<br>
        <textarea type="text" name="hotel_info" id="hotel_info" rows="4" cols="50"></textarea>
        <br>
        <font color="red">
            <label id="hotel_info_ID">
        </font>
        <br>
    </p>
    <br> Will there be people accompanying?<br>
    <input type="radio" name="leading_people" value="accno" onclick="isLastChoice2(this.value)" checked required> No <br>
    <input type="radio" name="leading_people" value="accyes" onclick="isLastChoice2(this.value)" required> Yes <br>
    <br>
    <p id="otheraccompany">
        Will people accompanying you be present at additional events?<br>
        <input type="radio" name="additional_events" value="accevno" checked required> No <br>
        <input type="radio" name="additional_events" value="accevyes" required> Yes <br>
        <br>
    </p>
    <br>
    <input type="submit" class="g-recaptcha" data-sitekey="<?php echo \core\Helper::config('app')->recaptcha["site_key"]?>" data-callback="recaptchaSubmit" value="Submit">
    <input type="reset" value="Reset">
    <br>
    <br>
    <a href="{{config.directory}}/user/login">Already registered? Sign in</a>
</form>
<script>
    var registerFormData = {
        registerFields: ([{
            "label": "First Name:",
            "name": "first_name",
            "placeholder": "First Name",
            "required": true
        }, {
            "label": "Last Name:",
            "name": "last_name",
            "placeholder": "Last Name",
            "required": true
        }, {
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
            "label": "E-Mail:",
            "name": "email",
            "placeholder": "Email",
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
            "name": "hotel_info",
            "id": "hotel_info"
        }]),
        abstractField: ([{
            "label": "Abstract:",
            "name": "abstract",
            "placeholder": "Abstract",
            "required": true
        }])
    }
</script>
<script src="{{config.directory}}/scripts/register"></script>

<p></p>
{{include "footer"}}