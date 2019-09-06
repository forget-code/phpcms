<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>

<script type="text/javascript">
function doCheck(){
	if ($('#member_actor').val()=='') {
	alert("请选择头衔系列");
	$('#member_actor').focus();
	return false;
	}
	if ($('#grade').val()=='') {
	alert("请填写级别");
	$('#grade').focus();
	return false;
}
	if ($('#actor').val()=='') {
	alert("请填写头衔");
	$('#actor').focus();
	return false;
}
	if ($('#min').val()=='') {
	alert("请填写最少积分");
	$('#min').focus();
	return false;
}
}
</script>
<?=$menu?>
<form name="myform" action="" method="post" onsubmit="return doCheck();">
<table width="100%" cellpadding="3" cellspacing="1"  class="table_form">
<caption>会员头衔修改</caption>
<tr>
<th width="25%">所属系列：</th>
<td width="80%" align="left" valign="middle" colspan="5" >
<input name='id' type='hidden' value='<?=$id?>'>
<?=$type_selected?></td>
</tr>
<tr>
<th>级别：</th>
<td width="80%" align="left" valign="middle" colspan="5" ><input name='info[grade]' type='text' id='grade' value='<?=$grade?>' size='20' maxlength='10'></td>
</tr>
<tr>
<th>头衔：</th>
<td width="80%" align="left" valign="middle" colspan="5" ><input name='info[actor]' type='text' id='actor' value='<?=$actor?>' size='20' maxlength='10'></td>
</tr>
<tr>
<th>积分：</th>
<td width="80%" align="left" valign="middle" colspan="5" ><input name='info[min]' type='text' id='min' size='6' maxlength='10' value="<?=$min?>">&nbsp;&nbsp;---&nbsp;&nbsp;<input name='info[max]' type='text' id='max' size='6' maxlength='10' value="<?=$max?>"></td>
</tr>
</table>
<div class="button_box">
<input type="submit" name="dosubmit" value=" 确定 ">
</div>
</form>
</body>
</html>
