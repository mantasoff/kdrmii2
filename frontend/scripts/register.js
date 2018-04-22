function notEmpty(name, value) {
    var x = document.getElementsByName("name").value;
	//if (x.length > 0)	{
		return document.getElementById("message1").innerHTML = "You wrote: " + x;
	//}
}