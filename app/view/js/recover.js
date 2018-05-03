function Recover_Form1_Validator(theForm)
{
  if(!recoverFormData) return false;
  if (theForm.email.value.length < 1) {
    document.getElementById(theForm.email.name+"_ID").innerText = "Please enter email.";
    theForm[theForm.email.name].focus();
    return false;
  }
  var regexp =  /^[A-Za-z0-9.]+@[A-Za-z]+.[A-Za-z0-9.]+$/;
  if (theForm.email.value.match(regexp) == null) {
    document.getElementById(theForm.email.name+"_ID").innerText = "Please enter a valid email.";      
    theForm[theForm.email.name].focus();
    return false;
  }
  else document.getElementById(theForm.email.name+"_ID").innerText = "";

return true;
}