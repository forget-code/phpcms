<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=8>批量设置会员组</th>
  </tr>
<form method="post" name="search" action="?">
<tr>
<td align="center" width="10%" class="tablerowhighlight">用户名</td>
<td class="tablerow">
<?php 
foreach($userid as $i=>$id)
{
	echo "<input type='checkbox' name='userid[]'  id='userid[]' value='$id' checked> $member[$id] &nbsp;&nbsp;";
	if($i && $i%9 == 0) echo '<br />';
}
?>
</td>
</tr>
<tr>
<td align="center" width="10%" class="tablerowhighlight">会员组</td>
<td class="tablerow"><?=$groupids?> &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="ischargebynewgroup" value="1"> <font color="blue">把会员组计费方式、有效期、点数默认值应用到用户吗？</font></td>
</tr>
<tr>
<td colspan=2 height="30" class="tablerow" align="center">
<input name='mod' type='hidden' value='<?=$mod?>'>
<input name='file' type='hidden' value='<?=$file?>'>
<input name='action' type='hidden' value='<?=$action?>'>
<input name='forward' type='hidden' value='<?=$PHP_REFERER?>'>
<input name='dosubmit' type='submit' value=' 批量移动 '>
</td>
  </tr>
</form>
</table>
</body>
</html>
