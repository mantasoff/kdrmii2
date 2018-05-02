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
    <label for="title">Title: (Prof/Dr/Mr/Mrs/Ms)</label>
    <select name="title">
        <option value="Prof">Prof</option>
        <option value="Dr">Dr</option>
        <option value="Mr">Mr</option>
        <option value="Mrs">Mrs</option>
        <option value="Ms">Ms</option>
    </select>
    <br> First Name:<br>
    <input type="text" name="firstname" placeholder="First Name" oninput="notEmpty(this.name, this.value)" size="26" required> <br>
    <font color="red">
        <p id="firstname_ID"></p>
    </font>
    Last Name:<br>
    <input type="text" name="lastname" placeholder="Last Name" oninput="notEmpty(this.name, this.value)" size="26" required> <br>
    <font color="red">
        <p id="lastname_ID"></p>
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
    <input type="text" name="phone" placeholder="Phone number" oninput="notEmpty(this.name, this.value)" size="26" required> <br>
    <font color="red">
        <p id="phone_ID"></p>
    </font>
    Article title:<br>
    <input type="text" name="articletitle" placeholder="Article title" oninput="notEmpty(this.name, this.value)" size="26" required> <br>
    <font color="red">
        <p id="articletitle_ID"></p>
    </font>
    Article authors:<br>
    <input type="text" name="articleauthors" placeholder="Article authors" oninput="notEmpty(this.name, this.value)" size="26" required> <br>
    <font color="red">
        <p id="articleauthors_ID"></p>
    </font>
    Article authors affiliations:<br>
    <input type="text" name="articleauthorsaffiliations" placeholder="Affiliations" oninput="notEmpty(this.name, this.value)" size="26" required> <br>
    <font color="red">
        <p id="articleauthorsaffiliations_ID"></p>
    </font>
    Do you need to book the hotel room?<br>
    <input type="radio" name="hotel" value="roomno" onclick="isLastChoice(this.value)" checked required> No<br>
    <input type="radio" name="hotel" value="roomsingle" onclick="isLastChoice(this.value)" required> Single room<br>
    <input type="radio" name="hotel" value="roomdouble" onclick="isLastChoice(this.value)" required> Double room<br>
    <input type="radio" name="hotel" value="roomother" onclick="isLastChoice(this.value)" required> Other<br>
    <p id="otherroom">
        Additional information:<br>
        <textarea type="text" name="addinfo" id="addinfo" rows="4" cols="50"> </textarea>
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
    Do you need prepayment invoice for participation fee?<br>
    <input type="radio" name="invoice_required" value="invno" onclick="isLastChoice3(this.value)" checked required> No <br>
    <input type="radio" name="invoice_required" value="invyes" onclick="isLastChoice3(this.value)" required> Yes <br>
    <br>
    <p id="otherinvoice">
        Name of institution for which prepayment invoice is issued:<br>
        <input type="text" name="institutionname" size="45">
        <br> Address of institution for which prepayment invoice is issued:<br>
        <input type="text" name="institutionaddress" size="45">
        <br> Company code of institution for which prepayment invoice is issued:<br>
        <input type="text" name="institutioncompanycode" size="45">
        <br> Bank account code of institution for which prepayment invoice is issued:<br>
        <input type="text" name="institutionbankcode" size="45">
        <br>
    </p>
    Abstract:<br>
    <textarea type="text" name="abstract" placeholder="Abstract" id="abstractfield" rows="4" cols="50" required> </textarea>
    <br>
    <br>
    <input type="submit" class="g-recaptcha" data-sitekey="6LcMpVYUAAAAAPD0rqA7Bag75oOMoYmrfWKIRdT1" data-callback="recaptchaSubmit" value="Submit">
    <input type="reset" value="Reset">
</form>
<script>
    var registerFormData = {
        registerFields: ([{
            "label": "First Name:",
            "name": "firstname",
            "placeholder": "First Name",
            "required": true
        }, {
            "label": "Last Name:",
            "name": "lastname",
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
            "name": "phone",
            "placeholder": "Phone number",
            "required": true
        }, {
            "label": "Article title:",
            "name": "articletitle",
            "placeholder": "Article title",
            "required": true
        }, {
            "label": "Article authors:",
            "name": "articleauthors",
            "placeholder": "Article authors",
            "required": true
        }, {
            "label": "Article authors affiliations:",
            "name": "articleauthorsaffiliations",
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
        institutionFields: ([{
            "label": "Name of institution for which prepayment invoice is issued:",
            "name": "institutionname"
        }, {
            "label": "Address of institution for which prepayment invoice is issued:",
            "name": "institutionaddress"
        }, {
            "label": "Company code of institution for which prepayment invoice is issued:",
            "name": "institutioncompanycode"
        }, {
            "label": "Bank account code of institution for which prepayment invoice is issued:",
            "name": "institutionbankcode"
        }])
    }
</script>
<script src="{{config.directory}}/scripts/register"></script>

<p></p>
{{include "footer"}}