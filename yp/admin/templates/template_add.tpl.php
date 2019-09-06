<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>

<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>管理信息</caption>
  <tr>
    <td><a href='?mod=yp&file=template' >公司模板管理</a> | <a href='?mod=yp&file=template&action=add' ><font color="#ff0000">添加模板风格</font></a></td>
  </tr>
</table>
<form name="myform" method="post" action="?mod=yp&file=template&action=add">
<input type="hidden" name="forward" value="?mod=phpcms&file=area&action=manage" />
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>添加模板风格</caption>
  <tr>
      <th width="25%"><strong>模板类型</strong></th>
      <td>
<select name="tplname" onchange="$('#changetplname').html(this.value);">
<?php
foreach($list_names AS $info)
{
	echo "<option value='$info'>$info</option>";
}
?>
</select> 添加模板类型方法例如：templates/<?=TPL_NAME?>/yp/com_<span id="changetplname" style="color:red"><?=$list_names[0]?></span>-index.html
</td>
    </tr>
	
  <tr>
  <th><strong>中文名</strong></th>
  <td>
	<input type="text" name="filename" require="true" datatype="limit" min="1" max="50"  msg="字符长度范围必须为1到50位"><font color="red">*</font>
  </td>
  </tr>
<tr>
  <th><strong>缩略图</strong></th>
  <td>
	<input name='thumb' type='text' id='thumb' size='70' value=''>  <input type='button' value='上传缩略图' onclick="javascript:openwinx('?mod=phpcms&file=upload&uploadtext=thumb&type=thumb&width=600&height=300','upload_thumb','350','350')">
  </td>
  </tr>	
  <tr>
  <th><strong>CSS 路径</strong></th>
  <td>
	<font color='red'><?=WEB_SKIN?></font><input name='style' type='text' id='style' size='20' value='' regexp="^[a-z0-9_]+\.css$" require="true" datatype="limit|custom" min="1" max="50"  msg="字符长度范围必须为1到50位|只能为数字、和字母，下划线、且后缀必须为.css">
  </td>
  </tr>
  <tr>
  <th><strong>使用权限</strong></th>
  <td>
	<?=$arrgroupid_used?>
  </td>
  </tr>
	<tr>
      <th></th>
      <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
    </tr>
</table>
</form>
</body>
</html>
<script LANGUAGE="javascript">
<!--
$().ready(function() {
	  $('form').checkForm(1);
	});
//-->
</script>