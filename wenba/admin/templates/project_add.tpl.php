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
	if ($('actor_num').value=='') {
	alert("请填写头衔数");
	$('actor_num').focus();
	return false;
}
}
</script>

<?=$menu?>
<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage">会员头衔管理首页</a> &gt;&gt; 添加头衔</td>
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
	<th colspan="6">会员头衔添加----设置</th>
</tr>
<tr>
	<td width="20%" align="right" valign="middle" class='tablerow'>请选择头衔的系列:&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td width="80%" align="left" valign="middle" colspan="5" class='tablerow'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$type_selected?></td>
</tr>
<tr>
	<td width="20%" align="right" valign="middle" class='tablerow'>此系列分多少个头衔:&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td width="80%" align="left" valign="middle" colspan="5" class='tablerow'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='actor_num' type='text' id='actor_num' value='18' size='20' maxlength='10'></td>
</tr>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width='40%'></td>
     <td><input type="submit" name="dosubmit" value=" 下一步 ">&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>