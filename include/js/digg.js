function InitAjax()
{
　var ajax=false;
　try {
　　ajax = new ActiveXObject("Msxml2.XMLHTTP");
　} catch (e) {
　　try {
　　　ajax = new ActiveXObject("Microsoft.XMLHTTP");
　　} catch (E) {
　　　ajax = false;
　　}
　}
　if (!ajax && typeof XMLHttpRequest!='undefined') {
　　ajax = new XMLHttpRequest();
　}
　return ajax;
}

function getAjax(httpurl,requests,div)
{
　if (typeof(httpurl,requests,div) == 'undefined')
　{
　　return false;
　}
	var url = httpurl+requests;
	var show = document.getElementById(div);
　var ajax = InitAjax();
　ajax.open("GET", url, true);
　ajax.onreadystatechange = function() {
　　if (ajax.readyState == 4 && ajax.status == 200) {
　　　show.innerHTML = ajax.responseText;
　　}
　}
　ajax.send(null);
}