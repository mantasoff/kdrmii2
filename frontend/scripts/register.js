/**
 * Adds error to element if it's empty
 * @param {string} name 
 * @param {string} value 
 */
function notEmpty(name, value) {
  var x = value;
	if (x.length === 0)	{
		return document.getElementById(name+"_ID").innerHTML = "Please fill out this field";
	}
}

/**
 * 
 * @param {string} name 
 * @param {string} value 
 */
function isLastChoice(name, value) {

}

/**
 * Preloads default values to the form
 */
function defaultValues() {
	return document.getElementById("addinfo").innerHTML.hidden(true);
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
   * 
   * !!! registerFormData still has registerRoom, registerRoomOther 
   * and institutionFields that have to be validated too
   */
  
  for(var i = 0; i < registerFields.length; i++) {    
    if (registerFields[i].required && (theForm[registerFields[i].name].value.length == 0)) {
      alert("Please enter a valid " + registerFields[i].placeholder + ".");
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
