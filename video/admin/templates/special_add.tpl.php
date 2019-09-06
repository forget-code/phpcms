<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<script type="text/javascript" src="images/js/validator.js"></script>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" method="post" name="myform">
<input type="hidden" name="forward" id="forward" value='<?=$forward?>'>
<table cellpadding="0" cellspacing="1" class="table_form">
    <caption>添加专辑</caption>
	<tr>
      <th><strong>专辑名称</strong></th>
      <td><input type="text" name="info[title]" id="title" size="50" require="true" datatype="limit" min="1" max="50"  msg="字符长度范围必须为1到50位" msgid="msgid1"> <?=form::style('info[style]')?><span id="msgid1"></span></td>
    </tr>
    <tr>
      <th><strong>缩略图</strong></th>
      <td>
	  <?=form::upload_image('info[thumb]', 'thumb', '', 50, '', 'require="true" datatype="limit" msg="请上传缩略图" msgid ="msgid2"')?><span id="msgid2"></span>
    </td>
    </tr>
    <tr>
      <th><strong>专辑横幅</strong></th>
      <td>
	  <?=form::upload_image('info[banner]', 'banner', '', 50)?>
    </td>
    </tr>
    <tr>
      <th><strong>专辑简介</strong></th>
      <td><textarea name="info[description]" id="description" cols="60" rows="5"></textarea>  <?=form::editor('description','standard','100%', 200)?></td>
    </tr>
	<tr>
      <th><strong>专辑页模板</strong></th>
      <td><?=form::select_template($mod, 'info[template]', 'template', 'special', 'require="true" datatype="limit" msg="请选择模板" msgid="msgid3"', 'special')?> <font color="red">*</font><span id="msgid3"></span></td>
    </tr>
	<tr>
      <th><strong>状态</strong></th>
      <td>
	  <input type="radio" name="info[disabled]" id="disabled" value="0" checked> 发布
	  <input type="radio" name="info[disabled]" id="disabled" value="1"> 暂停
	  <input type="hidden" name="filesize" id="filesize" value="">
	  </td>
    </tr>
	<tr>
      <td></td>
      <td><input type="submit" name="dosubmit" value=" 确定 "> &nbsp;&nbsp; <input type="reset" name="reset" value=" 清除 "> </td>
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