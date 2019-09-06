<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<script type="text/javascript" src="images/js/validator.js"></script>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&typeid=<?=$typeid?>&module=<?=$module?>" method="post" name="myform">
<table cellpadding="0" cellspacing="1" class="table_form">
    <caption>修改分类</caption>
	<tr>
      <th width="30%"><strong>分类名称</strong></th>
      <td><input type="text" name="info[name]" value="<?=$name?>" size="30" require="true" datatype="limit" min="1" max="50"  msg="字符长度范围必须为1到50位" msgid="msgid1"> <?=form::style('info[style]', $style)?><font color="red">*</font><span id="msgid1"></span></td>
    </tr>
	<tr>
      <th><strong>分类描述</strong></th>
      <td><textarea name="info[description]" rows="2" cols="20" id="description" class="inputtext"  style="height:100px;width:300px;"><?=$description?></textarea></td>
    </tr>
	<tr>
      <th><strong>分类目录</strong></th>
      <td><input type="text" name="info[typedir]" value="<?=$typedir?>" size="30" regexp="^[a-z0-9_]+$" require="true" datatype="limit|custom|ajax" url="?mod=<?=$mod?>&file=<?=$file?>&action=checkdir&typeid=<?=$typeid?>" min="1" max="50"  msg="字符长度范围必须为1到50位|只能为数字、和字母，下划线|" msgid="msgid2"> <font color="red">*</font><span id="msgid2"></span></td>
    </tr>	<tr>
      <th><strong>分类模板</strong></th>
      <td><?=form::select_template('phpcms', 'info[template]', 'template', $template, 'require="true" datatype="limit" msg="请选择分类模板"', 'type')?></td>
    </tr>
    <tr>
      <th></th>
      <td>
	  <input type="hidden" name="forward" value="?mod=<?=$mod?>&file=<?=$file?>&action=manage&module=<?=$module?>">
	  <input type="submit" name="dosubmit" value=" 确定 ">
      &nbsp; <input type="reset" name="reset" value=" 清除 ">
	  </td>
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