function notEmpty(name, value) {
    var x = value;
	if (x.length > 0)	{
		return document.getElementById(name+"_ID").innerHTML = "You wrote: " + x;
	}
}