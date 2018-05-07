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

function Dashboard_Form1_Validator(theForm)
{
  if(!dashboardFormData) return false;
      var registerFields = dashboardFormData.registerFields;

      for (var i = 0; i < registerFields.length; i++) {
          if (registerFields[i].required && (theForm[registerFields[i].name].value.length < 3)) {
              document.getElementById(registerFields[i].name + "_ID").innerText = "Please enter a valid " + registerFields[i].placeholder + ".";
              theForm[registerFields[i].name].focus();
              return false;
          }
          else document.getElementById(registerFields[i].name + "_ID").innerText = "";
      }
      /**
       * abstract validation
       */
      if (theForm.abstract.value.length < 1) {
          document.getElementById(theForm.abstract.name + "_ID").innerText = "Please enter a valid " + theForm.abstract.placeholder + ".";
          theForm[theForm.abstract.name].focus();
          return false;
      }
      else document.getElementById(theForm.abstract.name + "_ID").innerText = "";

      /**
       * field limit validation
       */

      if (theForm.institution.value.length > 100) {
          document.getElementById(theForm.institution.name + "_ID").innerText = theForm.institution.placeholder + " too long.";
          theForm[theForm.institution.name].focus();
          return false;
      } else document.getElementById(theForm.institution.name + "_ID").innerText = "";

      if (theForm.affiliation.value.length > 255) {
          document.getElementById(theForm.affiliation.name + "_ID").innerText = theForm.affiliation.placeholder + " too long.";
          theForm[theForm.affiliation.name].focus();
          return false;
      } else document.getElementById(theForm.affiliation.name + "_ID").innerText = "";

      if (theForm.phone.value.length > 18) {
          document.getElementById(theForm.phone.name + "_ID").innerText = theForm.phone.placeholder + " too long.";
          theForm[theForm.phone.name].focus();
          return false;
      } else document.getElementById(theForm.phone_number.name + "_ID").innerText = "";

      if (theForm.article_title.value.length > 255) {
          document.getElementById(theForm.article_title.name + "_ID").innerText = theForm.article_title.placeholder + " too long.";
          theForm[theForm.article_title.name].focus();
          return false;
      } else document.getElementById(theForm.article_title.name + "_ID").innerText = "";

      if (theForm.article_authors.value.length > 300) {
          document.getElementById(theForm.article_authors.name + "_ID").innerText = theForm.article_authors.placeholder + " too long.";
          theForm[theForm.article_authors.name].focus();
          return false;
      } else document.getElementById(theForm.article_authors.name + "_ID").innerText = "";

      if (theForm.article_authors_affiliations.value.length > 300) {
          document.getElementById(theForm.article_authors_affiliations.name + "_ID").innerText = theForm.article_authors_affiliations.placeholder + " too long.";
          theForm[theForm.article_authors_affiliations.name].focus();
          return false;
      } else document.getElementById(theForm.article_authors_affiliations.name + "_ID").innerText = "";

      if (theForm.abstract.value.length > 800) {
          document.getElementById(theForm.abstract.name + "_ID").innerText = theForm.abstract.placeholder + " too long.";
          theForm[theForm.abstract.name].focus();
          return false;
      } else document.getElementById(theForm.abstract.name + "_ID").innerText = "";

      if (theForm.hotel_info.value.length > 64) {
          document.getElementById(theForm.hotel_info.name + "_ID").innerText = theForm.hotel_info.placeholder + " too long.";
          theForm[theForm.hotel_info.name].focus();
          return false;
      } else document.getElementById(theForm.hotel_info.name + "_ID").innerText = "";
  return true;
}