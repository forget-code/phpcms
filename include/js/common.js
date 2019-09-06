function openwinx(url,name,w,h) { 
    window.open(url,name,"top=100,left=400,width=" + w + ",height=" + h + ",toolbar=no,menubar=no,scrollbars=yes,resizable=no,location=no,status=no")
}
function Dialog(url,name,w,h){
	return showModalDialog(url, name, 'dialogWidth:'+w+'px; dialogHeight:'+h+'px; help: no; scroll: yes; status: no');
}
function setidval(id,value) { 
    document.getElementById(id).innerHTML = value;
}

function getidval(id) { 
    return document.getElementById(id).innerHTML;
}

function checkall(form) {
	for(var i = 0;i < form.elements.length; i++) {
		var e = form.elements[i];
		if (e.name != 'chkall' && e.disabled != true) {
			e.checked = form.chkall.checked;
		}
	}
}

function redirect(url) {
	window.location.replace(url);
}

function confirmurl(url,message){
         if(confirm(message)){
            location.href=url;
         }
}

function confirmform(form,message){
         if(confirm(message)){
            form.submit();
         }
}

function setcookie(name, value) //设置名称为name,值为value的Cookie 
{
        name = cookiepre+name;
        var argc = setcookie.arguments.length; 
	var argv = setcookie.arguments; 
	var path = (argc > 3) ? argv[3] : null; 
	var domain = (argc > 4) ? argv[4] : null; 
	var secure = (argc > 5) ? argv[5] : false; 
	document.cookie = name + "=" + value + 
	((path == null) ? "" : ("; path=" + path)) + 
	((domain == null) ? "" : ("; domain=" + domain)) + 
	((secure == true) ? "; secure" : ""); 
} 

function deletecookie(name) //删除名称为name的Cookie 
{
        var exp = new Date(); 
	exp.setTime (exp.getTime() - 1); 
	var cval = getcookie(name);
        name = cookiepre+name;
	document.cookie = name + "=" + cval + "; expires=" + exp.toGMTString(); 
} 


function clearcookie() //清除COOKIE 
{ 
	var temp=document.cookie.split(";"); 
	var loop3; 
	var ts; 
	for (loop3=0;loop3;){ 
	   ts=temp[loop3].split("=")[0]; 
	   if (ts.indexOf('mycat')!=-1) 
	      deletecookie(ts); //如果ts含“mycat”则执行清除 
	} 
} 


function getcookieval(offset)  //取得项名称为offset的cookie值 
{
	var endstr = document.cookie.indexOf (";", offset); 
	if (endstr == -1) 
	endstr = document.cookie.length; 
	return unescape(document.cookie.substring(offset, endstr)); 
} 


function getcookie(name) //取得名称为name的cookie值 
{
        name = cookiepre+name;
	var arg = name + "="; 
	var alen = arg.length; 
	var clen = document.cookie.length; 
	var i = 0; 
	while (i < clen) { 
	var j = i + alen; 
	if (document.cookie.substring(i, j) == arg) 
	return getcookieval(j); 
	i = document.cookie.indexOf(" ", i) + 1; 
	if (i == 0) break; 
	} 
	return null; 
}

var tID=0;
function ShowTabs(ID){
  var tTabTitle=document.getElementById("TabTitle"+tID);
  var tTabs=document.getElementById("Tabs"+tID);
  var TabTitle=document.getElementById("TabTitle"+ID);
  var Tabs=document.getElementById("Tabs"+ID);
  if(ID!=tID){
    tTabTitle.className='title1';
    TabTitle.className='title2';
    tTabs.style.display='none';
    Tabs.style.display='';
    tID=ID;
  }
}

function ChangeInput (objSelect,objInput){
	if (!objInput) return;
	var str = objInput.value;
	var arr = str.split(",");
	for (var i=0; i<arr.length; i++){
	  if(objSelect.value==arr[i])return;
	}
	if(objInput.value=='' || objInput.value==0 || objSelect.value==0){
	   objInput.value=objSelect.value
	}else{
	   objInput.value+=','+objSelect.value
	}
}

function Change2Input (objSelect,objInput1,objInput2){
	if (!objInput1) return;
	if (!objInput2) return;
	var str = objSelect.value;
	var arr = str.split(",");
	objInput1.value=arr[0]
	objInput2.value=arr[1]
}

var flag=false; 
function setpicWH(ImgD,w,h){ 
	var image=new Image(); 
	image.src=ImgD.src; 
	if(image.width>0 && image.height>0){ 
	flag=true; 
	if(image.width/image.height>= w/h){ 
	if(image.width>w){  
	ImgD.width=w; 
	ImgD.height=(image.height*w)/image.width; 
	ImgD.style.display="block";
	}else{ 
	ImgD.width=image.width;  
	ImgD.height=image.height; 
	ImgD.style.display="block";
	} 
	} 
	else{ 
	if(image.height>h){  
	ImgD.height=h; 
	ImgD.width=(image.width*h)/image.height; 
	ImgD.style.display="block"; 
	}else{ 
	ImgD.width=image.width;  
	ImgD.height=image.height; 
	ImgD.style.display="block";
	} 
	} 
	} 
}
var Browser = new Object();

Browser.isMozilla = (typeof document.implementation != 'undefined') && (typeof document.implementation.createDocument != 'undefined') && (typeof HTMLDocument!='undefined');
Browser.isIE = window.ActiveXObject ? true : false;
Browser.isFirefox = (navigator.userAgent.toLowerCase().indexOf("firefox")!=-1);
Browser.isSafari = (navigator.userAgent.toLowerCase().indexOf("safari")!=-1);
Browser.isOpera = (navigator.userAgent.toLowerCase().indexOf("opera")!=-1);

var Common = new Object();
Common.htmlEncode = function(str) 
{
	return str.replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

// 去除字符串的首尾的空格
Common.trim = function(str) {
	return str.replace(/(^\s*)|(\s*$)/g, "");
}

// 返回字符串的实际长度, 一个汉字算2个长度
Common.strlen = function (str){
   return str.replace(/[^\x00-\xff]/g, "**").length;
}


// 检查是否为 2006-05-01 的日期格式
Common.isdate =function (str){
   var result=str.match(/^(\d{4})(-|\/)(\d{1,2})\2(\d{1,2})$/);
   if(result==null) return false;
   var d=new Date(result[1], result[3]-1, result[4]);
   return (d.getFullYear()==result[1] && d.getMonth()+1==result[3] && d.getDate()==result[4]);
}

// 判断输入是否是一个整数
Common.isnumber = function(val) {
    var reg = /[\d|\.|,]+/;
    return reg.test(val);
}

// 判断输入是否是一个由 0-9 / A-Z / a-z 组成的字符串
Common.isalphanumber= function (str){
	var result=str.match(/^[a-zA-Z0-9]+$/);
	if(result==null) return false;
	return true;
}

Common.isint = function(val) {
    var reg = /\d+/;
    return reg.test(val);
}

Common.isemail = function( email )
{
    var reg = /([\w|_|\.|\+]+)@([-|\w]+)\.([A-Za-z]{2,4})/;

    return reg.test( email );
}

Common.fixeventargs = function(e) 
{
    var evt = (typeof e == "undefined") ? window.event : e;
    return evt;
}

Common.srcelement = function(e)
{
    if (typeof e == "undefined") e = window.event;
    var src = document.all ? e.srcElement : e.target;

    return src;
}

Common.isdatetime = function(val)
{
	var result=str.match(/^(\d{4})(-|\/)(\d{1,2})\2(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$/);
	if(result==null) return false;
	var d= new Date(result[1], result[3]-1, result[4], result[5], result[6], result[7]);
	return (d.getFullYear()==result[1]&&(d.getMonth()+1)==result[3]&&d.getDate()==result[4]&&d.getHours()==result[5]&&d.getMinutes()==result[6]&&d.getSeconds()==result[7]);
}

