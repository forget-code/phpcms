<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>

<script type="text/javascript">
function doCheck(){
	if(document.myform.member_actor.value==''){
	alert("请选择头衔系列");
	document.myform.member_actor.focus();
	return false;
	}
	if (document.myform.actor_num.value=='') {
	alert("请填写头衔数");
	document.myform.actor_num.focus();
	return false;
}
}
</script>
<?=$menu?>

<form name="myform" action="" method="post" onsubmit="return doCheck();">
<table width="100%" cellpadding="3" cellspacing="1"  class="table_form">
<caption>会员头衔添加----设置</caption>
<tr>
	<th width="25%">请选择头衔的系列:&nbsp;&nbsp;&nbsp;&nbsp;</th>
	<td width="80%" align="left" valign="middle" colspan="5" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$type_selected?></td>
</tr>
<tr>
	<th>此系列分多少个头衔:&nbsp;&nbsp;&nbsp;&nbsp;</th>
	<td width="80%" align="left" valign="middle" colspan="5" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='actor_num' type='text' id='actor_num' value='18' size='20' maxlength='10'></td>
</tr>
</table>
<div class="button_box">
<input type="submit" name="dosubmit" value=" 下一步 ">
</div>
</form>
</body>
</html>