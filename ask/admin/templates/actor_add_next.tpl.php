<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<?=$menu?>
<form name="myform" action="" method="post" onsubmit="return doCheck();">
<table width="100%" cellpadding="3" cellspacing="1"  class="table_list">
<caption>会员头衔添加----设置</caption>

<tr >
<th width="33%">等级</th>
<th>头衔</th>
<th>积分</th>
</tr>
<?php for($i=0; $i<$actor_num; $i++) {?>
<tr >
<td class="align_c"><input name='grade[]' type='text' id='grade<?=$i?>' size='20' maxlength='30'></td>
<td class="align_c"><input name='actors[]' type='text' id='actor<?=$i?>' size='30' maxlength='30'></td>
<td class="align_c"><input name='min[]' type='text' id='min<?=$i?>' size='6' maxlength='10'>&nbsp;&nbsp;---&nbsp;&nbsp;<input name='max[]' type='text' id='max<?=$i?>' size='6' maxlength='10'></td>
</tr>
<?php }?>
</table>
<table width="100%" height="25" cellpadding="0" cellspacing="1">
  <tr>
     <td width='40%'><input name='typeid' type='hidden' value='<?=$typeid?>'></td>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>