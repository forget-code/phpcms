<html>
<head>
<title>PHPCMS 程序安装向导</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$CONFIG['charset']?>">
<link rel="shortcut icon" href="favicon.ico" >
<script language="javascript" src="include/js/prototype.js"></script>
<script type="text/javascript">
<!--
function MiniWindow(){
 var str='<object id=miniw type="application/x-oleobject" classid="clsid:adb880a6-d8ff-11cf-9377-00aa003b7a11"><param name="Command" value="MINIMIZE"></object>';
 if(document.body){
  if(!document.getElementById("miniw"))document.body.insertAdjacentHTML("BeforeEnd",str);
  miniw.Click();
 }
}
function CloseWindow()
{
	if (window.confirm("您确定要退出安装吗?"))
	{
		window.close();
	}
}
function opentree(objname)
{
	var obj = document.getElementById(objname);
	if(obj.style.display=='block')
	{
	if(objname=='openmodule')
	document.getElementById('tree2').src='install/images/cle2.gif';
	else 
	document.getElementById('tree1').src='install/images/cle1.gif';
	
	obj.style.display='none';
	}
	else
	{
	if(objname=='openmodule')
	document.getElementById('tree2').src='install/images/opn2.gif';
	else 
	document.getElementById('tree1').src='install/images/opn1.gif';
	obj.style.display='block';
	}
}
function showdescription(introduce)
{
	document.getElementById('introducetd').style.color='#000000';
	document.getElementById('introducetd').innerHTML = introduce;
}
function help(obj,content)
{
	if(document.getElementById(obj).innerHTML=='')
	{
		document.getElementById(obj).innerHTML = content;
	}
	else
	{
		document.getElementById(obj).innerHTML = '';
	}
}
function GetInstallingPage(dourl)
{
 	document.getElementById('InstallingModule').location(dourl);
}
function InstallingFinish() 
{
	window.location="install.php?step=10";
}
</script>
<style>
A:visited	{COLOR: #3A4273; TEXT-DECORATION: none}
A:link		{COLOR: #3A4273; TEXT-DECORATION: none}
A:hover		{COLOR: #3A4273; TEXT-DECORATION: underline}
.ttable {width:502px;background-color:#FFFFFF;}
.btable		{width:502px;background-color:#FFFFFF;border-left:#0016AE 1px solid;border-right:#0016AE 1px solid;border-bottom:#0016AE 1px solid;}
.ltable		{width:500px;background-color:#FFFFFF;border-left:#166AEE 2px solid;border-right:#166AEE 2px solid;border-bottom:#166AEE 2px solid;}
.tr-bottom  {font-family:宋体;color:#000000;background-color:#ECE9D8;border-top:#0016AE 1px solid;height:46px;}
.tr-bottom-bg {background:url(install/images/top-bg.gif);}
.td-left-top {background:url(install/images/left-top-bg.gif);width:5px;height:5px;}
.td-right-top {background:url(install/images/right-top-bg.gif);width:5px;height:5px;}
.td-l-top {background:url(install/images/l-top-bg.gif);width:100%;height:5px;}
.tr-l-bottom {background:url(install/images/l-bottom-bg.gif);height:23px;}
.txttitle {font-family: Tahoma, Verdana, Verdana,宋体; FONT-SIZE: 12px;color:#FFFFFF;font-weight:bold;}
.disabletxt{color:#ACA899;}
.tdtxt {font-family: Tahoma, Verdana, Verdana,宋体; FONT-SIZE: 12px;color:#0000FF;line-height:24px;}
input,select {font-family:Verdana,Verdana,宋体; font-size:12px;BORDER-TOP-WIDTH:1px; PADDING-RIGHT:1px; PADDING-LEFT:1px; BORDER-LEFT-WIDTH:1px; FONT-SIZE:12px; BORDER-LEFT-COLOR:#cccccc; BORDER-BOTTOM-WIDTH:1px; BORDER-BOTTOM-COLOR:#cccccc; PADDING-BOTTOM:1px; BORDER-TOP-COLOR:#cccccc; PADDING-TOP:1px; HEIGHT:18px; BORDER-RIGHT-WIDTH:1px; BORDER-RIGHT-COLOR:#cccccc}
input.btn {font-size: 12px;color: #000000;background-color: #FFFFFF;background-image: url(install/images/button_bg.jpg);border: 1px solid #7789AA;font-family: Verdana,Tahoma, Verdana;padding: 2px 3px;cursor:pointer;height:23px;}
body {font-family: Tahoma, Verdana, Verdana,宋体; FONT-SIZE: 9pt; scrollbar-base-color: #E3E3EA; scrollbar-arrow-color: #5C5C8D}
.inputck {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #7F9DB9;
	border: 1px solid #7F9DB9;
	height: 20px;
	line-height:16px;
}

td {FONT-SIZE: 9pt;}
.textarea {font-family: "MS Sans Serif"; width: 450px; background-color: #FFFFFF; height: 160px; clip:  rect(   ); font-size: 9pt}
.style1 {color: #3366CC}
</style>
<body>