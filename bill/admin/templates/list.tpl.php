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
userid：<input name='userid' type='text' value="<?=$userid?>" size=4>
IP：<input name='ip' type='text' value="<?=$ip?>" size=12>
来路：<input name='refurl' type='text' value="<?=$refurl?>" size=12>
开始日期：<?=date_select('begindate', $begindate)?>
&nbsp;&nbsp;&nbsp;&nbsp;截止日期：<?=date_select('enddate', $enddate)?>
	<input name='submit' type='submit' value=' 查询 '></td>
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
    <th colspan=8>奖励记录</th>
  </tr>
<form method="post" name="myform">
<tr align="center">
<td width="8%" class="tablerowhighlight">userid</td>
<td width="15%" class="tablerowhighlight">IP</td>
<td width="47%" class="tablerowhighlight">来路</td>
<td width="10%" class="tablerowhighlight">奖励</td>
<td width="20%" class="tablerowhighlight">访问时间</td>
</tr>
<?php
foreach($bills AS $bill)
{
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><a href="?mod=member&file=member&action=view&userid=<?=urlencode($bill['userid'])?>" class="member_url"><?=$bill['userid']?></a></td>
<td><a href="?mod=<?=$mod?>&file=<?=$file?>&ip=<?=$bill['ip']?>"><?=$bill['ip']?></a></td>
<td><a href="<?=$bill['refurl']?>" target="_blank"><?=$bill['refurl']?></a></td>
<td><?=$bill['number']?><?php if($bill['type'] == 'points'){ ?>点 <?php }elseif($bill['type'] == 'days'){ ?>天 <?php }else{ ?> 元 <?php } ?></td>
<td><?=$bill['addtime']?></td>
</tr>
<? } ?>
</table>
</form>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td height="20" align="center"><?=$pages?></td>
  </tr>
</table>
</body>
</html>