<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<form action="?mod=phpcms&file=safe&action=edit_code" method="POST">
<table width="95%" cellpadding="0" class="table_form" cellspacing="1">
 <caption><?=$file_path?>查看代码</caption>
 <tr>
 <td>特征函数</td>
 <td><?php
 if ($func) {
 	 foreach ($func as $val)
	 {
	 	if($val)
	 	{
	 		echo "<input type='button' onclick=\";findInPage(this.form.code,'$val');\" value='".$val."'> ";
	 	}
	 }
 }
 ?></td>
 </tr>
 <tr>
  <td>特征代码</td>
 <td><?php
 if($code)
 {
	 foreach ($code as $val)
	 {
	 	if($val)
	 	{
	 		echo "<input type='button' onclick=\"findInPage(this.form.code,'".htmlentities($val)."');\" value='".htmlentities($val)."'> ";
	 	}
	 }
 }
 ?></td>
 </tr>
 <tr>
 <td valign="top">文件源代码</td>
 <td class="text"><textarea rows="40" cols="100" id="code" name="code">
 <?=$html?>
 </textarea></td>
 </tr>
 <tr>
 <td></td>
 <td> <input type="button" onclick="location.href='?mod=phpcms&file=safe&action=scan_table'" value="返回扫描列表"></td>
 </tr>
</table>
</form>
<script type="text/javascript">
$('#code').css('width',$('.text').width()+'px');
var n = 0;
function findInPage(obj, str) {
	var txt, i, found;
	if (str == "") {
		return false;
	}
	if (document.layers) {
		if (!obj.find(str)) {
			while(obj.find(str, false, true)) {
				n++;
			}
		} else {
			n++;
		}
		if (n == 0) {
			alert('未找到指定字串！');
		}
	}
	if (document.all) {
		txt = obj.createTextRange();
		for (i = 0; i <= n && (found = txt.findText(str)) != false; i++) {
			txt.moveStart('character', 1);
			txt.moveEnd('textedit');
		}
		if (found) {
			txt.moveStart('character', -1);
			txt.findText(str);
			txt.select();
			txt.scrollIntoView();
			n++;
		} else {
			if (n > 0) {
				n = 0;
				findInPage(str);
			} else {
				alert("未找到指定字串！");
			}
		}
	}
	return false;
}
</script>