var xmlHttp;
var msXml = new Array();
msXml[0] = "Microsoft.XMLHTTP";
msXml[1] = "MSXML2.XMLHTTP.5.0";
msXml[2] = "MSXML2.XMLHTTP.4.0";
msXml[3] = "MSXML2.XMLHTTP.3.0";
msXml[4] = "MSXML2.XMLHTTP";
if (window.xmlHttpRequest) {
	xmlHttp = new xmlHttpRequest();
} else {
	for (var i = 0; i < msXml.length; i++) {
		try {
			xmlHttp = new ActiveXObject(msXml[i]);
			break;
		} catch (e) {
			xmlHttp = new XMLHttpRequest();
		}
	}
}