{{include "header"}}
<br>
{{message}}
Please enter information regarding invoice.
<form name="invoice_form" method="POST" onsubmit="return Invoice_Form1_Validator(this)" novalidate>
    <br><br>
    Name of institution for which prepayment invoice is issued:<br>
    <input type="text" name="institutionname" id="institutionname" size="45">
    <br>
    <font color="red">
        <label id="institutionname_ID">
    </font>
    <br>
    Address of institution for which prepayment invoice is issued:<br>
    <input type="text" name="institutionaddress" id="institutionaddress" size="45">
    <br>
    <font color="red">
        <label id="institutionaddress_ID">
    </font>
    <br>
    Company code of institution for which prepayment invoice is issued:<br>
    <input type="text" name="institutioncompanycode" id="institutioncompanycode" size="45">
    <br>
    <font color="red">
        <label id="institutioncompanycode_ID">
    </font>
    <br>
    Bank account code of institution for which prepayment invoice is issued:<br>
    <input type="text" name="institutionbankcode" id="institutionbankcode" size="45">
    <br>
    <font color="red">
        <label id="institutionbankcode_ID">
    </font>
    <br>
    <input type="submit" value="Update Invoice">
</form>
<script>
    var invoiceFormData = {
        institutionFields: ([{
            "label": "Name of institution for which prepayment invoice is issued:",
            "name": "institutionname",
            "id": "institutionname"
        }, {
            "label": "Address of institution for which prepayment invoice is issued:",
            "name": "institutionaddress",
            "id": "institutionaddress"
        }, {
            "label": "Company code of institution for which prepayment invoice is issued:",
            "name": "institutioncompanycode",
            "id": "institutioncompanycode"
        }, {
            "label": "Bank account code of institution for which prepayment invoice is issued:",
            "name": "institutionbankcode",
            "id": "institutionbankcode"
        }])
    }
</script>
<script src="{{config.directory}}/scripts/invoice"></script>
{{include "footer"}}