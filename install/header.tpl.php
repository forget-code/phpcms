<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8>">
<title><?php echo $steps[$step];?> - Phpcms2008 安装向导</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<style type="text/css">
<!--
*{margin:0; padding:0;}
body {font-family: Arial, Helvetica, sans-serif,"宋体";font-size: 12px;line-height: 210%;font-weight: normal;color: #333333;text-decoration: none;background: #0cf url(install/images/line.jpg) repeat-x 0 0 ;}
a {	text-decoration:none; color:#fff;}
a:hover { text-decoration:underline;}
li{ list-style:none;}
input, textarea, select, button, file {	font-size:12px;}
.txt_box {	font-family:"宋体";	font-size:12px;	border:1px solid #dcdcdc;}
#main{ background:url(install/images/bg.jpg) no-repeat 0 0; width:935px; min-height:600px; height:600px;  margin:0 auto; position:relative;}
#top{ position:absolute; top:20px; right:0; color:#fff; font-weight:bold;}
#ads{ position:absolute; top:35px; left:0; padding-left:220px;color:#fff; font-size:16px; font-weight:bold;}
#left { position:absolute; top:138px; left:20px; width:160px; float:left;}
#left li{height:50px;font-size:14px; font-weight:bold; color:#fff; text-decoration:none; padding-left:20px;}
#left li#now{ background:url(install/images/now.png) no-repeat 0 5px; color:#ff0;}
#right{ position:absolute; top:90px;  left:216px; width:700px;}
#right h3{ font-size:14px; color:#fff;}
#right h3 span{ font-size:24px; padding-right:20px; font-style:italic;}
.info{ color:#fff; text-indent:2em; margin:10px 0;}
.info a,.suc a{ color:#ff0;}
.btn{ background:url(install/images/btn.jpg) repeat-x 0 0; text-align:center; border:1px solid #00719b; padding:0 8px; color:#fff; cursor:pointer; height:29px; line-height:29px; font-weight:bold; display:block; float:left; margin:10px 15px 0 0;}
.btn2{ background:url(install/images/btn.jpg) repeat-x 0 0; text-align:center; border:1px solid #00719b; padding:0 0px; color:#fff; cursor:pointer; height:29px; line-height:29px; font-weight:bold; display:block; float:left; margin:10px 0px 0 0;width:600px;}
.content{ min-height:300px; color:#fff; margin:auto 10px; padding:10px;}
.c{color:#fff;}
caption{ background:#0592BA; text-align:left; font-size:14px; font-weight:bold; height:24px; line-height:24px; padding-left:10px; margin:10px 0; }
table{ margin-top:10px;}
td{ height:30px; line-height:30px;}
#introducetd{ padding:10px 10px 5px; color:#fff; height:100px; border:1px solid #fff;}
.table_list{ border:1px solid #fff; border-width:1px 0 0 1px; }
.table_list td,.table_list th{ color:#f5f5f5; padding:3px 5px; line-height:16px;border:1px solid #fff; border-width:0 1px 1px 0; }
.suc{ background:url(install/images/finished.png) no-repeat 0 0; height:110px; width:450px; margin:0px auto; padding-left:150px; line-height:30px; color:#fff; padding-top:0px;}
-->
</style>
<script language="JavaScript" src="images/js/jquery.min.js"></script>
<script language="JavaScript" src="images/js/css.js"></script>
<script type="text/javascript">
<!--
function showdescription(introduce)
{
	document.getElementById('introducetd').style.color='#000000';
	document.getElementById('introducetd').innerHTML = introduce;
}
//-->
</script>
</head>
<body>
<div id="main">
<div id="ads">—— 中国领先的网站内容管理系统！</div>
<div id="top"><a href="http://www.phpcms.cn" target="_blank">官方网站</a>　|　<a href="http://bbs.phpcms.cn" target="_blank">官方论坛</a></div>
  <div id="left">
    <ul>
<?php
foreach($steps as $k=>$v)
{
	$selected = $k == $step ? 'id="now"' : '';
    echo "<li {$selected}>{$v}</li>";
}
?>
    </ul>
  </div>
  <div id="right">
    <h3><span><?php echo $step;?></span><?php echo $steps[$step];?></h3>