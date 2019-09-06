<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="post" id="myform" action="?mod=link&file=link&action=<?=$action?>" enctype="multipart/form-data" onsubmit="return Check()">
<table cellpadding="0" cellspacing="1" class="table_form">
<caption>添加友情链接</caption>
<tr>
	<th width="200"><strong>所属分类</strong></th>
	<td>
	<?=form::select_type('link', 'typeid','',"选择分类",'','require="true" compare=">0" datatype="compare" msg="请选择所属类别"')?>
	</td>
</tr>
<tr >
	<th><strong>链接类型</strong></th>
	<td>
	<input name="linktype" type="radio" value="1" checked="checked" style="border:0" onclick="$('#logolink').show()">
	Logo链接&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="radio" name="linktype" value="0"  style="border:0" onclick="$('#logolink').hide()">
	文字链接</td>
</tr>

<tr >
	<th><strong>网站名称</strong></th>
	<td><input name="name" id="name" size="30"  maxlength="20" require="true" datatype="require" msg="网站名称不能为空" msgid="msgid1">
	<font color="#FF0000"> *</font><span id="msgid1"/></td>
</tr>
<tr >
	<th><strong>链接颜色</strong></th>
	<td><?=form::style('style')?></td>
</tr>

<tr >
	<th><strong>网站地址</strong></th>
	<td><input name="url" id="url" size="30" maxlength="100" type="text" value="http://"  require="true" datatype="url"  msg="网站地址不正确" msgid="msgid2">
	<font color="#FF0000">*</font><span id="msgid2"/></td>
</tr>
<tr id="logolink">
	<th><strong>网站Logo</strong></th>
	<td><?=form::upload_image("logo", 'logo')?>大小规格为88*31像素</td>
	</td>
</tr>
<tr>
	<th><strong>站长姓名</strong></th>
	<td><input name="username" size="30"  maxlength="20" type="text"></td>
</tr>
<tr >
	<th><strong>网站介绍</strong></th>
	<td valign="middle"><textarea name="introduce" cols="40" rows="5" id="introduction"></textarea></td>
</tr>
<tr >
	<th><strong>推荐</strong></th>
	<td><input type='radio' name='elite' value='1' > 是 <input type='radio' name='elite' value='0' checked="checked"> 否</td>
</tr>

<tr>
	<th><strong>批准</strong></th>
	<td><input type='radio' name='passed' value='1' checked> 是 <input type='radio' name='passed' value='0'> 否</td>
</tr>

<tr >
	<th>&nbsp;</th>
	<td>
	<input type="submit" value=" 确定 " name="submit">
	<input type="reset" value=" 清除 " name="reset">
	</td>
</tr>
</table>
</form>
</body>
</html>
<script language="javascript">
<!--
$('form').checkForm(1);
//-->
</script>

