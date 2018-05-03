function Invoice_Form1_Validator(theForm)
{
  if(!invoiceFormData) return false;
  if (theForm.institutionname.value.length > 255) {
    document.getElementById(theForm.institutionname.name+"_ID").innerText = "Institution name too long.";
    theForm[theForm.institutionname.name].focus();
    return false;
  } else document.getElementById(theForm.institutionname.name+"_ID").innerText = "";

  if (theForm.institutionaddress.value.length > 255) {
    document.getElementById(theForm.institutionaddress.name+"_ID").innerText = "Address too long.";
    theForm[theForm.institutionaddress.name].focus();
    return false;
  } else document.getElementById(theForm.institutionaddress.name+"_ID").innerText = "";

  if (theForm.institutioncompanycode.value.length > 255) {
    document.getElementById(theForm.institutioncompanycode.name+"_ID").innerText = "Company too long.";
    theForm[theForm.institutioncompanycode.name].focus();
    return false;
  } else document.getElementById(theForm.institutioncompanycode.name+"_ID").innerText = "";

  if (theForm.institutionbankcode.value.length > 255) {
    document.getElementById(theForm.institutionbankcode.name+"_ID").innerText = "Bank code too long.";
    theForm[theForm.institutionbankcode.name].focus();
    return false;
  } else document.getElementById(theForm.institutionbankcode.name+"_ID").innerText = "";

  if (theForm.institutionname.value.length < 1) {
    document.getElementById(theForm.institutionname.name+"_ID").innerText = "Please enter institution name.";
    theForm[theForm.institutionname.name].focus();
    return false;
  } else document.getElementById(theForm.institutionname.name+"_ID").innerText = "";

  if (theForm.institutionaddress.value.length < 1) {
    document.getElementById(theForm.institutionaddress.name+"_ID").innerText = "Please enter address.";
    theForm[theForm.institutionaddress.name].focus();
    return false;
  } else  document.getElementById(theForm.institutionaddress.name+"_ID").innerText = "";

  if (theForm.institutioncompanycode.value.length < 1) {
    document.getElementById(theForm.institutioncompanycode.name+"_ID").innerText = "Please enter company code.";
    theForm[theForm.institutioncompanycode.name].focus();
    return false;
  } else document.getElementById(theForm.institutioncompanycode.name+"_ID").innerText = "";

  if (theForm.institutionbankcode.value.length < 1) {
    document.getElementById(theForm.institutionbankcode.name+"_ID").innerText = "Please enter bank code.";
    theForm[theForm.institutionbankcode.name].focus();
    return false;
  } else document.getElementById(theForm.institutionbankcode.name+"_ID").innerText = "";

return true;
}