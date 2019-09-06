var oPopup = window.createPopup();
var oPopupBody = oPopup.document.body;
var oPopupSize = 30;
var space = 10;
function fnClick() {
	try {
		var objEvt = evt.target;
	} catch (e) {
		var objEvt = event.srcElement;
	}
	window.returnValue = objEvt.src;
	window.close();
}
function fnOver() {
	try {
		var objEvt = evt.target;
		var x = evt.x;
		var y = evt.y;
	} catch (e) {
		var objEvt = event.srcElement;
		var x = window.event.x;
		var y = window.event.y;
	}
	objEvt.style.borderStyle = "inset";
	objEvt.style.borderWidth = "1px";
	objEvt.style.borderColor = "#ffffff";
	oPopupBody.innerHTML = "<table width='100%' height='100%' border='1' bordercolor='#ff0000' cellpadding='0' cellspacing='0' align='center'><tr><td width='100%' height='100%' align='center' valign='middle'><img src='" + objEvt.src + "' border='0' width='80%'></td></tr></table>";
	var imgLeft;
	var imgTop;
	if (x + oPopupSize > document.body.clientWidth - space) {
		imgLeft = x - oPopupSize - space;
	} else {
		imgLeft = x + space;
	}
	if (y + oPopupSize > document.body.clientHeight - space) {
		imgTop = y - oPopupSize - space;
	} else {
		imgTop = y + space;
	}
	oPopup.show(imgLeft,imgTop,oPopupSize,oPopupSize,document.body);
}
function fnOut() {
	oPopup.hide()
	try {
		var objEvt = evt.target;
	} catch (e) {
		var objEvt = event.srcElement;
	}
	objEvt.style.borderStyle = "none";
}
if (window.attachEvent) {
	for (var i = 0; i < document.images.length; i++) {
		document.images[i].attachEvent("onclick",fnClick);
		document.images[i].attachEvent("onmouseover",fnOver);
		document.images[i].attachEvent("onmouseout",fnOut);
	}
} else {
	for (var i = 0; i < document.images.length; i++) {
		document.images[i].addEventListener("click",fnClick,false);
		document.images[i].addEventListener("mouseover",fnOver,false);
		document.images[i].addEventListener("mouseout",fnOut,false);
	}
}