<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=8>交易查询</th>
  </tr>
  <form method="get" name="search">
  <tr>
    <td align="center" class="tablerow">
	<input type="hidden" name="mod" value="<?=$mod?>">
	<input type="hidden" name="file" value="<?=$file?>">
	<input type="hidden" name="action" value="<?=$action?>">
	<input type="hidden" name="page" value="<?=$page?>">
	类型：
<select name="typeid">
<option value="0">不限</option>
<?php 
if(is_array($types)) 
{
	foreach($types as $id=>$val)
	{
		echo "<option value=\"".$id."\" ".($id==$typeid ? "selected" : "").">".$val['name']."</option>\n";
	}
}
?>
</select>&nbsp;&nbsp;
交易方式：
<select name="paytype">
<option value="0">不限</option>
<?php 
if(is_array($paytypes)) 
{
	foreach($paytypes as $val)
	{
		echo "<option value=\"".$val."\" ".($val==$paytype ? "selected" : "").">".$val."</option>\n";
	}
}
?>
</select>
&nbsp;&nbsp;日期：<input type="text" name="fromdate" size="10" value="<?=$fromdate?>"> - <input type="text" name="todate" size="10" value="<?=$todate?>">&nbsp;&nbsp;用户名：<input type="text" name="username" size="8" value="<?=$username?>">&nbsp;&nbsp;关键词：<input type="text" name="keywords" size="8" value="<?=$keywords?>">&nbsp;&nbsp;<input type="submit" name="search" value="查 询"></td>
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
    <th colspan=12>财务流水</th>
  </tr>
<form method="post" name="myform">
<tr align="center">
<td width="10%" class="tablerowhighlight">日期</td>
<td width="8%"  class="tablerowhighlight">用户名</td>
<?php 
foreach($types as $k=>$v)
{
	echo "<td class=\"tablerowhighlight\">{$v['name']}</td>";
}
?>
<td width="8%"  class="tablerowhighlight">余额</td>
<td width="8%"  class="tablerowhighlight">操作人</td>
<td width="12%"  class="tablerowhighlight">事由</td>
<td width="5%"  class="tablerowhighlight">操作</td>
</tr>
<?php
if(is_array($pays)) 
{
    foreach($pays AS $pay) { 
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&date=<?=$pay['date']?>" title="交易时间：<?=date('Y-m-d h:i:s',$pay['inputtime'])?>"><?=$pay['date']?></a></td>
<td><a href="?mod=member&file=member&action=view&username=<?=urlencode($pay['username'])?>"><?=$pay['username']?></a></td>
<?php 
foreach($types as $k=>$v)
{
	echo "<td>".($pay['typeid']==$k ? $pay['amount'] : '')."</td>";
}
?>
<td><?=$pay['balance']?></td>
<td><a href="?mod=member&file=member&action=view&username=<?=urlencode($pay['inputer'])?>"><?=$pay['inputer']?></a></td>
<td align="left"><?=$pay['note']?></td>
<td><a href="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&payid=<?=$pay['payid']?>','确认删除<?=$pay['typeid']?>金额为<?=$pay['amount']?>元的交易记录吗？')">删除</a></td>
</tr>
<?php
	}
}
?>
<tr align="center">
<td colspan="12" class="tablerowhighlight">合计</td>
</tr>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td></td>
<td></td>
<?php 
foreach($types as $k=>$v)
{
	echo "<td>".(isset($money[$k]) ? $money[$k] : '')."</td>";
}
?>
<td colspan=5 align="left"></td>
</tr>
</table>
</form>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td height="30" align="center"><?=$pages?></td>
  </tr>
</table>

</body>
</html>