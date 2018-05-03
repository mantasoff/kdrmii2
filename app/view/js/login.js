function Login_Form1_Validator(theForm)
{
  if(!loginFormData) return false;
  if (theForm.email.value.length < 1) {
    document.getElementById(theForm.email.name+"_ID").innerText = "Please enter email.";
    theForm[theForm.email.name].focus();
    return false;
  }
  else document.getElementById(theForm.email.name+"_ID").innerText = "";
  if (theForm.password.value.length < 1) {
    document.getElementById(theForm.password.name+"_ID").innerText = "Please enter password.";
    theForm[theForm.password.name].focus();
    return false;
  }
  else document.getElementById(theForm.password.name+"_ID").innerText = "";
  var regexp =  /^[A-Za-z0-9.]+@[A-Za-z]+.[A-Za-z0-9.]+$/;
  if (theForm.email.value.match(regexp) == null) {
    document.getElementById(theForm.email.name+"_ID").innerText = "Please enter a valid email.";      
    theForm[theForm.email.name].focus();
    return false;
  }
  else document.getElementById(theForm.email.name+"_ID").innerText = "";

return true;
}