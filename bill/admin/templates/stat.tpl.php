<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <td class="submenu" align="center"> 奖励记录查询 </td>
  </tr>
<form method="get" name="search">
  <tr>
    <td class="tablerow" align="center">
	<input type="hidden" name="mod" value="<?=$mod?>">
	<input type="hidden" name="file" value="<?=$file?>">
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td align="right">userid：<input name='userid' type='text' value="<?=$userid?>" size=5></td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;<select name="year">
<?php for($i=2007; $i<=date('Y'); $i++){ ?>
<option value="<?=$i?>"><?=$i?>年</option> 
<?php } ?>
</select> &nbsp;&nbsp; <input name='submit' type='submit' value=' 查询 '></td>
  </tr>
</table>

	</td>
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
    <th colspan=8><?=$year?>年奖励统计</th>
  </tr>
<form method="post" name="myform">
<tr align="center">
<td width="25%" class="tablerowhighlight">月份</td>
<td width="25%" class="tablerowhighlight">点数</td>
<td width="25%" class="tablerowhighlight">天数</td>
<td width="25%" class="tablerowhighlight">金额</td>
</tr>
<?php
foreach($bills AS $bill)
{
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><?=$bill['month']?></td>
<td><?=$bill['points']?></td>
<td><?=$bill['days']?></td>
<td><?=$bill['money']?></td>
</tr>
<?php 
$points += $bill['points'];
$days += $bill['days'];
$money += $bill['money'];
}
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td class="tablerowhighlight">合计</td>
<td class="tablerowhighlight"><?=$points?></td>
<td class="tablerowhighlight"><?=$days?></td>
<td class="tablerowhighlight"><?=$money?></td>
</tr>
</table>
</form>
</body>
</html>