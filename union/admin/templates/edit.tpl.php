<?php defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<input type="hidden" name="userid" value="<?=$userid?>">
<input type="hidden" name="forward" value="<?=$PHP_REFERER?>">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <th colspan=2>修改 <?=$username?> 的利润率</th>
    <tr>
      <td width='40%' class='tablerow'><strong>当前利润率</strong></td>
      <td class='tablerow'><?=$profitmargin?>%</td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>新利润率</strong></td>
      <td class='tablerow'><input name='profitmargin' type='text' id='profitmargin' size='3' maxlength='3'>%</td>
    </tr>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width='40%'></td>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>
</body>
</html>