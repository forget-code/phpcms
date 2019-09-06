<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<style>
#Filter,#MsgBox {display:none;}
#Filter { position: absolute; top: 0; left: 0; height: 800px; width: 100%;	background:#F6FBFE; filter: alpha(opacity=40); 	-moz-opacity: 0.40;opacity: 0.4; 	text-align: left; z-index: 999999;}
#MsgBox { position:absolute; top:100px; left: 0; width:360px; background:#fff; z-index:9999999999; text-align:left; clear: both; border: 1px solid #78A3D2;}
#msgtitle{ color: #1E5494; font-size: 12px;	font-weight: bold; text-align: left; background-color: #C9DEF6; text-indent:8px;	overflow: hidden; line-height: 24px; width:100%; height:24px; margin-bottom:5px; }
#msgclose{ float: right; border: 1px solid #1E5494; padding: 0 2px 0 2px;}
#msgclose a{ text-decoration: none;	color: #1E5494;}
#msgtitlecontent{ float: left;}
#msgcontent{ margin:0 5px; height:220px; overflow:auto;}
</style>
<link href="templates/default/skins/default/modal.css" rel="stylesheet" type="text/css" />
<form action="?mod=phpcms&file=safe&action=setting" target="dosubmit" method="POST" onsubmit="return postupdate()">
<table width="95%" cellpadding="0" cellspacing="1" class="table_form">
 <caption>木马扫描</caption>
<tbody>
<tr>
<th valign="top"><strong>扫描范围</strong></th>
<td>
<ul id="file" style="list-style:none; height:200px;overflow:auto;width:300px;">
<li><input type="checkbox" name="dir[]" value="./"<?php if(in_array('./',$safe['dir']))echo 'checked'?>> <img src="admin/skin/images/folder-open.gif"> ./</li>
<?php foreach ($dir_list as $val):?>
<li><input type="checkbox" name="dir[]" value="<?=$val?>"<?php if(in_array($val,$safe['dir']))echo 'checked'?>> <img src="admin/skin/images/folder-open.gif"> <?=$val?></li>
<?php endforeach;?>
</ul>
</td>
</tr>
<tr>
<th><strong>文件类型</strong></th>
<td><input type="text" name="file_type" value="<?=$safe['file_type']?>"> 多个请用‘|’进行分隔</td>
</tr>
<tr>
<th><strong>特征函数</strong></th>
<td><input type="text" name="func" value="<?=$safe['func']?>" size="50"> 多个请用‘|’进行分隔</td>
</tr>
<tr>
<th><strong>特征代码</strong></th>
<td><input type="text" name="code" value="<?=htmlentities($safe['code'])?>" size="50"> 多个请用‘|’进行分隔</td>
</tr>
<tr>
<th><strong>MD5校验镜像</strong></th>
<td><select name="md5_file">
<?php foreach($md5_file as $key=>$val):?>
<option value="<?=$val?>" <?php if($val == $safe['md5_file'])echo('selected')?>><?=$val?></option>
<?php endforeach;?>
</select>
</td>
</tr>
<tr>
<td></td>
<td><input type="submit" name="dosubmit" value="开始扫描"></td>
</tr>
</tbody>
</table>
</form>
<iframe name="dosubmit" id="dosubmit" width="0" height="0"></iframe>
<script type="text/javascript">
function postupdate()
{
	myalert('扫描进行中');
}

function setting()
{
	showmsgs('写入配置信息完成。');
	scan_file_type();
}

function scan_file_type()
{
	showmsgs('正在进行文件类型筛选...');
	$.get('?mod=phpcms&file=safe&action=scan_file_type',function(data){
		if(data == 'ok'){
		showmsgs('文件类型筛选完成。');
		scan_file_md5();
		}
	})
}


function scan_file_md5()
{
	showmsgs('正在进行文件修改历史对比...');
	$.get('?mod=phpcms&file=safe&action=scan_file_md5',function(data){
		if(data == 'ok'){
		showmsgs('文件修改历史对比完成。');
		scan_backdoor();
		}
	})
}

function scan_backdoor()
{
	showmsgs('正在进行特征函数扫描...');
	$.get('?mod=phpcms&file=safe&action=scan_func',function(data){
		if(data == 'ok'){
		showmsgs('特征函数扫描完成。');
		scan_code();
		}
	})
}

function scan_code()
{
	showmsgs('正在进行特征代码扫描...');
	$.get('?mod=phpcms&file=safe&action=scan_code',function(data){
		if(data == 'ok'){
		showmsgs('特征代码扫描完成。');
		scan_table();
		}
	})
}

function scan_table()
{
	showmsgs('正在为您准备扫描报表...');
	setTimeout('location.href="?mod=phpcms&file=safe&action=scan_table"',3000);
}

function showmsgs(obj)
{
	$('#showmsgs').append("<br>"+obj);
}

function myalert(title){
objwidth=360;
objheight=240;
if(!title) title = '扫描进行中';
var nLeft=(document.body.scrollWidth-objwidth)/2;
if(objheight)$('#MsgBox').height(objheight);
$('#MsgBox').width(objwidth);
$("#MsgBox").css('left',nLeft+'px');
$("#MsgBox").show();
$("#Filter").show();
$('#msgtitlecontent').html(title);
}

function closemyalert()
{
$("#MsgBox").hide();
$("#Filter").hide();
}
document.writeln("<div id=\"Filter\"> <\/div>");
document.writeln("<div id=\"MsgBox\">");
document.writeln("<div id=\"msgtitle\"><span id=\"msgtitlecontent\"><\/span>");
document.writeln("<\/div><span id=\"msgcontent\"><span id=\"showmsgs\">正在写入配置信息...</span><span><img src=\"admin/skin/images/loading.gif\"></span><\/span>");
document.writeln("<\/div>");

</script>
</body>
</html>