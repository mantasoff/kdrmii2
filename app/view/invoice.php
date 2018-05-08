{{include "header"}}
{{message}}
<br>
<a href="{{config.directory}}/dashboard"><input class="top" type="button" value="Profile"></a>
Please enter information regarding invoice.
<form name="invoice_form" method="POST" onsubmit="return Invoice_Form1_Validator(this)" novalidate>
    <fieldset <?php if($invoice["generated"] == 1) echo "disabled"; ?>>
    <br><br>
    Name of institution for which prepayment invoice is issued:<br>
    <input type="text" name="company_name" id="company_name" size="45" value="{{invoice.company_name}}">
    <br>
    <font color="red">
        <label id="company_name_ID">
    </font>
    <br>
    Address of institution for which prepayment invoice is issued:<br>
    <input type="text" name="company_address" id="company_address" size="45" value="{{invoice.company_address}}">
    <br>
    <font color="red">
        <label id="company_address_ID">
    </font>
    <br>
    Company code of institution for which prepayment invoice is issued:<br>
    <input type="text" name="company_code" id="company_code" size="45" value="{{invoice.company_code}}">
    <br>
    <font color="red">
        <label id="company_code_ID">
    </font>
    <br>
    Bank account code of institution for which prepayment invoice is issued:<br>
    <input type="text" name="bank_code" id="bank_code" size="45" value="{{invoice.bank_code}}">
    <br>
    <font color="red">
        <label id="bank_code_ID">
    </font>
    <br>
    <input type="submit" value="Update Invoice">
    </fieldset>
</form>
<script>
    var invoiceValidation = {
        invoiceFields: [{
            "label": "Name of institution for which prepayment invoice is issued:",
            "name": "company_name",
            "id": "company_name"
        }, {
            "label": "Address of institution for which prepayment invoice is issued:",
            "name": "company_address",
            "id": "company_address"
        }, {
            "label": "Company code of institution for which prepayment invoice is issued:",
            "name": "company_code",
            "id": "company_code"
        }, {
            "label": "Bank account code of institution for which prepayment invoice is issued:",
            "name": "bank_code",
            "id": "bank_code"
        }]
    }
</script>
<script src="{{config.directory}}/scripts/invoice"></script>
{{include "footer"}}