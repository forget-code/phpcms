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
<form action="?mod=<?=$mod?>&file=<?=$file?>&dosubmit=1" method="post">
<table width="95%" cellpadding="0" cellspacing="1" class="table_form">
 <caption>文件校验</caption>
<tbody>
<tr>
<th valign="top"><strong>校验范围</strong></th>
<td>
<ul id="file" style="list-style:none; height:200px;overflow:auto;width:300px;">
<li><input type="checkbox" name="dirs[]" value="" checked /> <img src="admin/skin/images/folder-open.gif"> ./</li>
<?php foreach($dirs as $val){ ?>
<li><input type="checkbox" name="dirs[]" value="<?=$val?>" <?php if(in_array($val, $checked_dirs))echo 'checked'?> /> <img src="admin/skin/images/folder-open.gif"> ./<?=$val?></li>
<?php }?>
</ul>
</td>
</tr>
<tr>
<th><strong>文件类型</strong></th>
<td><input type="text" name="exts" value="php|js|html"> 多个请用‘|’进行分隔</td>
</tr>
<tr>
<th><strong>MD5校验镜像</strong></th>
<td>
<select name="md5_file">
<?php foreach($md5_files as $v)
{
?>
<option value="<?=$v?>"><?=$v?></option>
<?php } ?>
</select>
</td>
</tr>
<tr>
<td></td>
<td><input type="submit" name="dosubmit" value="开始校验"></td>
</tr>
</tbody>
</table>
</form>
</body>
</html>