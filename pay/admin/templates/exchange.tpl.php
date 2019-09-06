<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
	<tr>
		<td></td>
	</tr>
</table>
<?=$menu?>
<table cellpadding="2" cellspacing="1" border="0" align="center" class="tableBorder">
  <tr>
    <td class="submenu" align="center"> 交易记录查询 </td>
  </tr>
<form method="get" name="search">
  <tr>
    <td class="tablerow" align="center">
	<input type="hidden" name="mod" value="<?=$mod?>">
	<input type="hidden" name="file" value="<?=$file?>">
	<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
	  <tr>
		<td align="right">用户名：<input name='username' type='text' value="<?=$username?>" size=12></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;
		<select name="type">
		<option value="">交易类型</option> 
		<option value="money" <?=($type == 'money') ? 'selected' : ''?>>资金</option> 
		<option value="point" <?=($type == 'point') ? 'selected' : ''?>>点数</option> 
		<option value="credit" <?=($type == 'credit') ? 'selected' : ''?>>积分</option> 
		<option value="time" <?=($type == 'time') ? 'selected' : ''?>>有效期</option> 
		</select> &nbsp;&nbsp; 
开始日期：<?=date_select('begindate', $begindate)?>
&nbsp;&nbsp;&nbsp;&nbsp;截止日期：<?=date_select('enddate', $enddate)?>
		<input name='submit' type='submit' value=' 查询 '>
	    </td>
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
<form method="post" name="myform">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="9">用户交易记录</th>
  </tr>
<tr align="center">
<td width="12%" class="tablerowhighlight">用户名</td>
<td width="10%" class="tablerowhighlight">交易类型</td>
<td width="10%" class="tablerowhighlight">交易额度</td>
<td width="20%" class="tablerowhighlight">交易时间</td>
<td width="12%" class="tablerowhighlight">IP</td>
<td width="*" class="tablerowhighlight">说明</td>
</tr>
<?php 
if(is_array($exchanges))
{
    foreach($exchanges as $exchange)
	{ ?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><a href="?mod=member&file=member&action=view&username=<?=urlencode($exchange['username'])?>"><?=$exchange['username']?></a></td>
<td><?=$types[$exchange['type']]?></td>
<td style="color:<?=$exchange['value']>0 ? 'red' : 'blue'?>"><?=$exchange['value']?><?=$units[$exchange['type'].$exchange['unit']]?></td>
<td><?=$exchange['addtime']?></td>
<td><?=$exchange['ip']?></td>
<td><?=$exchange['note']?></td>
</tr>
<?php
	} 
}
?>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td align="center"><?=$pages?></td>
  </tr>
</table>
</form>
</body>
</html>
