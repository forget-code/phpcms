<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=8>咨询查询</th>
  </tr>
  <form method="get" name="search">
  <tr>
    <td align="center" class="tablerow">
	<input type="hidden" name="mod" value="<?=$mod?>">
	<input type="hidden" name="file" value="<?=$file?>">
	<input type="hidden" name="departmentid" value="<?=$departmentid?>">
	<input type="hidden" name="page" value="<?=$page?>">
		<input type='radio' name='status' value='0' <?=($status == 0 ? 'checked' : '')?>> 未处理 &nbsp;&nbsp;&nbsp;&nbsp; 
		<input type='radio' name='status' value='1' <?=($status == 1 ? 'checked' : '')?>> 处理中 &nbsp;&nbsp;&nbsp;&nbsp; 
		<input type='radio' name='status' value='2' <?=($status == 2 ? 'checked' : '')?>> 已处理 &nbsp;&nbsp;&nbsp;&nbsp; 
		<input type='radio' name='status' value='3' <?=($status == 3 ? 'checked' : '')?>> 拒绝处理 &nbsp;&nbsp;&nbsp;&nbsp; 
         关键词：<input type="text" name="keywords" size="20" value="<?=$keywords?>">&nbsp;&nbsp;<input type="submit" name="search" value=" 查询 "></td>
  </tr>
  </form>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=9> <?php if($departmentid){ echo '['.$departments[$departmentid]['department'].']'; } ?> 咨询管理</th>
  </tr>
<form method="post" name="myform">
<tr align="center">
<td width="5%" class="tablerowhighlight">选中</td>
<td width="*" class="tablerowhighlight">咨询主题</td>
<td width="10%" class="tablerowhighlight">部门</td>
<td width="15%"  class="tablerowhighlight">咨询时间</td>
<td width="8%"  class="tablerowhighlight">状态</td>
<td width="15%"  class="tablerowhighlight">最后回复</td>
</tr>
<?php
if(is_array($asks)) 
{
foreach($asks AS $ask) { ?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input type="checkbox" name="askid[]"  id="askid[]" value="<?=$ask['askid']?>"></td>
<td align="left"><a href="?mod=ask&file=ask&action=reply&askid=<?=$ask['askid']?>">·<?=$ask['subject']?></a></td>
<td><?=$departments[$ask['departmentid']]['department']?></td>
<td><?=$ask['addtime']?></td>
<td><?=$STATUS[$ask['status']]?></td>
<td><?=$ask['lastreply']?></td>
</tr>
<?php
	}
}
?>

</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全部选中</td>
    <td>
		<input name="submit1" type="submit"  value="删除主题" onClick="document.myform.action='?mod=ask&file=ask&action=delete'">&nbsp;&nbsp;
    </td>
  </tr>
</table>
</form>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td height="20" align="center"><?=$pages?></td>
  </tr>
</table>

</body>
</html>