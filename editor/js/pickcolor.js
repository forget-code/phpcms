function PickColor()
{
	var sColor = document.getElementById('ColorSelect').ChooseColorDlg();
	var color = sColor.toString(16);
	while (color.length<6){color="0"+color};
	window.color = "#"+color;
	return "#"+color;
}
document.write('<object id="ColorSelect" classid="clsid:3050f819-98b5-11cf-bb82-00aa00bdce0b" width="0px" height="0px"></object>');