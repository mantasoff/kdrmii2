// V_map popup window
function popUpV_map () {	
	var w;
	w = window.open('http://www.mii.lt/v_map/index.asp?open_map=Vilnius&selected_map_size=3&Xmin=25.1902834210256&Ymin=54.6399309646067&Xmax=25.3531312654525&Ymax=54.7096335577375&tool=print', "Map", 'width=611,height=361,status=no,location=no,scrollbars=no,toolbar=no,menubar=no,resizable=no');
	if (typeof w != "") {
		window.opener=self;
	}
}