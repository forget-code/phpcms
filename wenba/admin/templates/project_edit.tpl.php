<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>

<script type="text/javascript">
function doCheck(){
	if ($('member_actor').value=='') {
	alert("请选择头衔系列");
	$('member_actor').focus();
	return false;
	}
	if ($('grade').value=='') {
	alert("请填写级别");
	$('grade').focus();
	return false;
}
	if ($('actor').value=='') {
	alert("请填写头衔");
	$('actor').focus();
	return false;
}
	if ($('min').value=='') {
	alert("请填写最少积分");
	$('min').focus();
	return false;
}
}
</script>
<?=$menu?>
<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage">会员头衔管理首页</a> &gt;&gt; 修改头衔</td>
  </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="10"> </td>
</tr>
</table>
<form name="myform" action="<?php echo $curUri; ?>" method="post" onsubmit="return doCheck();">
<table width="100%" cellpadding="3" cellspacing="1" align="center" class="tableborder">
<tr>
	<th colspan="2">会员头衔修改</th>
</tr>
<tr>
<td width="20%" align="right" valign="middle" class='tablerow'>所属系列:&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td width="80%" align="left" valign="middle" colspan="5" class='tablerow'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$type_selected?><input name='id' type='hidden' value='<?=$id?>'><input name="type" type="hidden" value="<?=$typeid?>" /></td>
</tr>
<tr>
<td width="20%" align="right" valign="middle" class='tablerow'>级别:&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td width="80%" align="left" valign="middle" colspan="5" class='tablerow'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='grade' type='text' id='grade' value='<?=$grade?>' size='20' maxlength='10'></td>
</tr>
<tr>
<td width="20%" align="right" valign="middle" class='tablerow'>头衔:&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td width="80%" align="left" valign="middle" colspan="5" class='tablerow'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='actor' type='text' id='actor' value='<?=$actor?>' size='20' maxlength='10'></td>
</tr>
<tr>
<td width="20%" align="right" valign="middle" class='tablerow'>积分:&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td width="80%" align="left" valign="middle" colspan="5" class='tablerow'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='min' type='text' id='min' size='6' maxlength='10' value="<?=$min?>">&nbsp;&nbsp;---&nbsp;&nbsp;<input name='max' type='text' id='max' size='6' maxlength='10' value="<?=$max?>"></td>
</tr>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width='40%'></td>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
