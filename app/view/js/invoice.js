function validate(validations, form){
  for(let i = 0; i < validations.length; i++){
        console.log(validations[i]);
    }
    return false;
}
function Invoice_Form1_Validator(theForm)
{
  if(!invoiceValidation) return false;
  var invoiceFields = invoiceValidation.invoiceFields;

  for(var i = 0; i < invoiceFields.length; i++) {
        console.log(invoiceFields[i].name);
        if (invoiceFields[i].required && (theForm[invoiceFields[i].name].value.length < 3)) {
            document.getElementById(invoiceFields[i].name+"_ID").innerText = "Please enter a valid " + invoiceFields[i].placeholder + ".";
            theForm[invoiceFields[i].name].focus();
            return false;
        }
        else document.getElementById(invoiceFields[i].name+"_ID").innerText = "";
    }


  if (theForm.company_name.value.length > 255) {
    document.getElementById(theForm.company_name.name+"_ID").innerText = "Institution name too long.";
    theForm[theForm.company_name.name].focus();
    return false;
  } else document.getElementById(theForm.company_name.name+"_ID").innerText = "";

  if (theForm.company_address.value.length > 255) {
    document.getElementById(theForm.company_address.name+"_ID").innerText = "Address too long.";
    theForm[theForm.company_address.name].focus();
    return false;
  } else document.getElementById(theForm.company_address.name+"_ID").innerText = "";

  if (theForm.company_code.value.length > 255) {
    document.getElementById(theForm.company_code.name+"_ID").innerText = "Company too long.";
    theForm[theForm.company_code.name].focus();
    return false;
  } else document.getElementById(theForm.company_code.name+"_ID").innerText = "";

  if (theForm.bank_code.value.length > 255) {
    document.getElementById(theForm.bank_code.name+"_ID").innerText = "Bank code too long.";
    theForm[theForm.bank_code.name].focus();
    return false;
  } else document.getElementById(theForm.bank_code.name+"_ID").innerText = "";

  if (theForm.company_name.value.length < 1) {
    document.getElementById(theForm.company_name.name+"_ID").innerText = "Please enter institution name.";
    theForm[theForm.company_name.name].focus();
    return false;
  } else document.getElementById(theForm.company_name.name+"_ID").innerText = "";

  if (theForm.company_address.value.length < 1) {
    document.getElementById(theForm.company_address.name+"_ID").innerText = "Please enter address.";
    theForm[theForm.company_address.name].focus();
    return false;
  } else  document.getElementById(theForm.company_address.name+"_ID").innerText = "";

  if (theForm.bank_code.value.length < 1) {
    document.getElementById(theForm.bank_code.name+"_ID").innerText = "Please enter company code.";
    theForm[theForm.bank_code.name].focus();
    return false;
  } else document.getElementById(theForm.bank_code.name+"_ID").innerText = "";

  if (theForm.company_code.value.length < 1) {
    document.getElementById(theForm.company_code.name+"_ID").innerText = "Please enter bank code.";
    theForm[theForm.company_code.name].focus();
    return false;
  } else document.getElementById(theForm.company_code.name+"_ID").innerText = "";

return true;
}