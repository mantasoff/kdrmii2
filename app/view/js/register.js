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
	}
}
//abstract
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
    if (registerFields[i].required && (theForm[registerFields[i].name].value.length == 0)) {
      document.getElementById(registerFields[i].name+"_ID").innerText = "Please enter a valid " + registerFields[i].placeholder + ".";
      theForm[registerFields[i].name].focus();
      return false;
    }
  }

  /**
   * Check if article title is filled and then if more
   * required data is given
   */
  if (theForm.articletitle.value.length > 0) {
		  if (theForm.articleauthors.value.length == 0) {
		  alert("Please enter article authors.");
		  theForm.article_authors.focus();
		  return false;
		}

		if (theForm.article_authors_affiliations.value.length == 0) {
		  alert("Please enter article authors affiliations.");
		  theForm.articleauthorsaffiliations.focus();
		  return (false);
		}
  }

  // TODO: Validate registerRoom, registerRoomOther, institutionFields

  return true;
}
