/**
 * Adds error to element if it's empty
 * @param {string} name 
 * @param {string} value 
 */
window.onload = defaultValues;
function notEmpty(name, value) {
  var x = value;
	if (x.length === 0)	{
		return document.getElementById(name+"_ID").innerHTML = "Please fill out this field";
  }
  if (x.length > 0)	{
		return document.getElementById(name+"_ID").innerHTML = "";
	}
}

/**
 * 
 * @param {string} name 
 * @param {string} value 
 */
function isLastChoice(value) {
  let x = value;
	if (x == "roomother")	{
    document.getElementById("otherroom").style.display = "inline";
  }
  if (x != "roomother")	{
    document.getElementById("otherroom").style.display = "none";
    document.getElementById("addinfo").value = null;
	}
}

function isLastChoice2(value) {
  let x = value;
	if (x == "accyes")	{
    document.getElementById("otheraccompany").style.display = "inline";
  }
  if (x != "accyes")	{
    document.getElementById("otheraccompany").style.display = "none";
	}
}

function isLastChoice3(value) {
  let x = value;
	if (x == "invyes")	{
    document.getElementById("otherinvoice").style.display = "inline";
  }
  if (x != "invyes")	{
    document.getElementById("otherinvoice").style.display = "none";
    document.getElementById("institutionname").value = null;
    document.getElementById("institutionaddress").value = null;
    document.getElementById("institutioncompanycode").value = null;
    document.getElementById("institutionbankcode").value = null;
	}
}

/**
 * Preloads default values to the form
 */
function defaultValues() {
  document.getElementById("otherroom").style.display = "none";
  document.getElementById("otheraccompany").style.display = "none";
  document.getElementById("otherinvoice").style.display = "none";
}

/**
 * Validates form passed by reference
 * @param {form} theForm 
 */
function FrontPage_Form1_Validator(theForm)
{
  // registerFormData is declared in "register" view
  if(!registerFormData) return false;
  var registerFields = registerFormData.registerFields;

  /**
   * Iterate through register form fields and check if
   * required fields are filled
   */
  
  for(var i = 0; i < registerFields.length; i++) {    
    if (registerFields[i].required && (theForm[registerFields[i].name].value.length < 3)) {
      document.getElementById(registerFields[i].name+"_ID").innerText = "Please enter a valid " + registerFields[i].placeholder + ".";
      theForm[registerFields[i].name].focus();
      return false;
    }
    else document.getElementById(registerFields[i].name+"_ID").innerText = "";
  }

  /**
   * email validation
   */
  var regexp =  /^[A-Za-z0-9.]+@[A-Za-z]+.[A-Za-z0-9.]+$/;
  if (theForm.email.value.match(regexp) == null) {
    document.getElementById(theForm.email.name+"_ID").innerText = "Please enter a valid " + theForm.email.placeholder + ".";      
    theForm[theForm.email.name].focus();
    return false;
  }
  else document.getElementById(theForm.email.name+"_ID").innerText = "";

  /**
   * abstract validation
   */
  if (theForm.abstract.value.length < 1) {
    document.getElementById(theForm.abstract.name+"_ID").innerText = "Please enter a valid " + theForm.abstract.placeholder + ".";
    theForm[theForm.abstract.name].focus();
    return false;
  }
  else document.getElementById(theForm.abstract.name+"_ID").innerText = "";

  /**
   * field length limit validation
   */
  if (theForm.email.value.length > 100) {
    document.getElementById(theForm.email.name+"_ID").innerText = theForm.email.placeholder + " too long.";
    theForm[theForm.email.name].focus();
    return false;
  } else document.getElementById(theForm.email.name+"_ID").innerText = "";

  if (theForm.institution.value.length > 100) {
    document.getElementById(theForm.institution.name+"_ID").innerText = theForm.institution.placeholder + " too long.";
    theForm[theForm.institution.name].focus();
    return false;
  } else document.getElementById(theForm.institution.name+"_ID").innerText = "";

  if (theForm.firstname.value.length > 64) {
    document.getElementById(theForm.firstname.name+"_ID").innerText = theForm.firstname.placeholder + " too long.";
    theForm[theForm.firstname.name].focus();
    return false;
  } else document.getElementById(theForm.firstname.name+"_ID").innerText = "";

  if (theForm.lastname.value.length > 64) {
    document.getElementById(theForm.lastname.name+"_ID").innerText = theForm.lastname.placeholder + " too long.";
    theForm[theForm.lastname.name].focus();
    return false;
  } else document.getElementById(theForm.lastname.name+"_ID").innerText = "";

  if (theForm.affiliation.value.length > 255) {
    document.getElementById(theForm.affiliation.name+"_ID").innerText = theForm.affiliation.placeholder + " too long.";
    theForm[theForm.affiliation.name].focus();
    return false;
  } else document.getElementById(theForm.affiliation.name+"_ID").innerText = "";

  if (theForm.phone.value.length > 18) {
    document.getElementById(theForm.phone.name+"_ID").innerText = theForm.phone.placeholder + " too long.";
    theForm[theForm.phone.name].focus();
    return false;
  } else document.getElementById(theForm.phone.name+"_ID").innerText = "";

  if (theForm.articletitle.value.length > 255) {
    document.getElementById(theForm.articletitle.name+"_ID").innerText = theForm.articletitle.placeholder + " too long.";
    theForm[theForm.articletitle.name].focus();
    return false;
  } else document.getElementById(theForm.articletitle.name+"_ID").innerText = "";

  if (theForm.articleauthors.value.length > 300) {
    document.getElementById(theForm.articleauthors.name+"_ID").innerText = theForm.articleauthors.placeholder + " too long.";
    theForm[theForm.articleauthors.name].focus();
    return false;
  } else document.getElementById(theForm.articleauthors.name+"_ID").innerText = "";

  if (theForm.articleauthorsaffiliations.value.length > 300) {
    document.getElementById(theForm.articleauthorsaffiliations.name+"_ID").innerText = theForm.articleauthorsaffiliations.placeholder + " too long.";
    theForm[theForm.articleauthorsaffiliations.name].focus();
    return false;
  } else document.getElementById(theForm.articleauthorsaffiliations.name+"_ID").innerText = "";

  if (theForm.abstract.value.length > 300) {
    document.getElementById(theForm.abstract.name+"_ID").innerText = theForm.abstract.placeholder + " too long.";
    theForm[theForm.abstract.name].focus();
    return false;
  } else document.getElementById(theForm.abstract.name+"_ID").innerText = "";

  if (theForm.addinfo.value.length > 64) {
    document.getElementById(theForm.addinfo.name+"_ID").innerText = theForm.addinfo.placeholder + " too long.";
    theForm[theForm.addinfo.name].focus();
    return false;
  } else document.getElementById(theForm.addinfo.name+"_ID").innerText =  "";

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

  /**
   * dependent field validation
   */
  if (theForm.invoice_required.value == "invyes") {
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

  }
  if (theForm.hotel.value == "roomother") {
    if (theForm.addinfo.value.length < 1) {
      document.getElementById(theForm.addinfo.name+"_ID").innerText = "Please fill out his field.";
      theForm[theForm.addinfo.name].focus();
      return false;
    } else document.getElementById(theForm.addinfo.name+"_ID").innerText = "";

  }

  return true;
}
