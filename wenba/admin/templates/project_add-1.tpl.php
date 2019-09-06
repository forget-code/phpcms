<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
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
	<th colspan="3">会员头衔添加----添加</th>
</tr>
<tr align="center">
<td width="33%" class="tablerowhighlight">等级</td>
<td class="tablerowhighlight">头衔</td>
<td width="33%" class="tablerowhighlight">积分</td>
</tr>
<?php for($i=0; $i<$actor_num; $i++) {?>
<tr align="center">
<td class="tablerow"><input name='grade[]' type='text' id='grade<?=$i?>' size='20' maxlength='30'></td>
<td class="tablerow"><input name='actors[]' type='text' id='actor<?=$i?>' size='30' maxlength='30'></td>
<td class="tablerow"><input name='min[]' type='text' id='min<?=$i?>' size='6' maxlength='10'>&nbsp;&nbsp;---&nbsp;&nbsp;<input name='max[]' type='text' id='max<?=$i?>' size='6' maxlength='10'></td>
</tr>
<?php }?>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width='40%'><input name='typeid' type='hidden' value='<?=$member_actor?>'></td>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>