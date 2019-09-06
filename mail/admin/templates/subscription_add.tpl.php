<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script language="JavaScript">
function CheckForm()
{
	if($('#period').val()=='')
	{
		alert('请填写期刊数！');
		$('#period').focus();
		return false;
	}
	if($('#typeid').val() == 0)
	{
		alert('请选择订阅分类！');
		$('#typeid').focus();
		return false;
	}
	if($('#title').val()=='')
	{
		alert('请填写邮件标题！');
		$('#title').focus();
		return false;
	}
}
</script>

<body>
<?=$menu?>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=add">
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>添加期刊</caption>
  <tr>
    <th width="20%"><strong>期刊号：</strong></th>
    <td>第
	<input name="setting[period]" type="text" id="period" <?php if (isset($period)) {echo "value=\"".$period."\"";}else{echo "value=\"".date('m')."\"";} ?> size="3" />期&nbsp;</td>
  </tr>
  <tr>
    <th><strong>订阅分类：</strong></th>
    <td><?=form::select_type('mail','setting[typeid]', 'typeid', '类别')?>  <a href="?mod=mail&file=type&action=add&forward=<?=urlencode(URL)?>">添加分类</a></td>
  </tr>
  <tr>
    <th><font color="Red">*</font> <strong>邮件标题：</strong></th>
    <td><input type="text" name="setting[title]" id="title" size="50" /></td>
  </tr>
  <tr>
    <th><font color="Red">*</font> <strong>邮件内容：</strong></th>
    <td>
		<textarea name="setting[content]"  id='content' cols="60" rows="16"></textarea>
		<?=form::editor('content','introduce','100%',400)?>
	</td>
  </tr>
  <tr>
    <th>&nbsp;</th>
    <td><input name="dosubmit" type="submit" size="4" value="确定" onclick="return CheckForm();">
     </td>
  </tr>
</table>
</form>
</body>
</html>
