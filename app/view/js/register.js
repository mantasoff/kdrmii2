function recaptchaSubmit(){
    let form = document.getElementsByName("reg_form")[0];
    if(typeof form === "undefined") return;
    if(FrontPage_Form1_Validator(form))
        form.submit();
    else
        grecaptcha.reset();
}

/**
 * Adds error to element if it's empty
 * @param {string} name 
 * @param {string} value 
 */
window.onload = defaultValues;
function notEmpty(name, value) {
  console.log(name);
  var x = value;
	if (x.length < 3)	{
		return document.getElementById(name+"_ID").innerHTML = "Please fill out this field";
  }
  if (x.length >= 3)	{
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

/**
 * Preloads default values to the form
 */
function defaultValues() {
  document.getElementById("otherroom").style.display = "none";
  document.getElementById("otheraccompany").style.display = "none";
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

  if (theForm.first_name.value.length > 64) {
    document.getElementById(theForm.firstname.name+"_ID").innerText = theForm.first_name.placeholder + " too long.";
    theForm[theForm.first_name.name].focus();
    return false;
  } else document.getElementById(theForm.first_name.name+"_ID").innerText = "";

  if (theForm.last_name.value.length > 64) {
    document.getElementById(theForm.last_name.name+"_ID").innerText = theForm.last_name.placeholder + " too long.";
    theForm[theForm.last_name.name].focus();
    return false;
  } else document.getElementById(theForm.last_name.name+"_ID").innerText = "";

  if (theForm.affiliation.value.length > 255) {
    document.getElementById(theForm.affiliation.name+"_ID").innerText = theForm.affiliation.placeholder + " too long.";
    theForm[theForm.affiliation.name].focus();
    return false;
  } else document.getElementById(theForm.affiliation.name+"_ID").innerText = "";

  if (theForm.phone_number.value.length > 18) {
    document.getElementById(theForm.phone_number.name+"_ID").innerText = theForm.phone_number.placeholder + " too long.";
    theForm[theForm.phone_number.name].focus();
    return false;
  } else document.getElementById(theForm.phone_number.name+"_ID").innerText = "";

  if (theForm.article_title.value.length > 255) {
    document.getElementById(theForm.article_title.name+"_ID").innerText = theForm.article_title.placeholder + " too long.";
    theForm[theForm.article_title.name].focus();
    return false;
  } else document.getElementById(theForm.article_title.name+"_ID").innerText = "";

  if (theForm.article_authors.value.length > 300) {
    document.getElementById(theForm.article_authors.name+"_ID").innerText = theForm.article_authors.placeholder + " too long.";
    theForm[theForm.article_authors.name].focus();
    return false;
  } else document.getElementById(theForm.article_authors.name+"_ID").innerText = "";

  if (theForm.article_authors_affiliations.value.length > 300) {
    document.getElementById(theForm.article_authors_affiliations.name+"_ID").innerText = theForm.article_authors_affiliations.placeholder + " too long.";
    theForm[theForm.article_authors_affiliations.name].focus();
    return false;
  } else document.getElementById(theForm.article_authors_affiliations.name+"_ID").innerText = "";

  if (theForm.abstract.value.length > 800) {
    document.getElementById(theForm.abstract.name+"_ID").innerText = theForm.abstract.placeholder + " too long.";
    theForm[theForm.abstract.name].focus();
    return false;
  } else document.getElementById(theForm.abstract.name+"_ID").innerText = "";

  if (theForm.hotel_info.value.length > 64) {
    document.getElementById(theForm.hotel_info.name+"_ID").innerText = theForm.hotel_info.placeholder + " too long.";
    theForm[theForm.hotel_info.name].focus();
    return false;
  } else document.getElementById(theForm.hotel_info.name+"_ID").innerText =  "";

  if (theForm.hotel.value == "roomother") {
    if (theForm.hotel_info.value.length < 1) {
      document.getElementById(theForm.hotel_info.name+"_ID").innerText = "Please fill out his field.";
      theForm[theForm.hotel_info.name].focus();
      return false;
    } else document.getElementById(theForm.hotel_info.name+"_ID").innerText = "";

  }

  return true;
}
