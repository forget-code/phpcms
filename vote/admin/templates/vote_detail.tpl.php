<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?> 

<table cellpadding="2" cellspacing="1" class="tableborder">
	<tr>
		<th colspan=7>投票统计</th>
	</tr>
	<tr align="left">
		<td colspan="3" class="tablerowhighlight">投票总数：<?=$number?></td>
	</tr>
<?php 
foreach($ops AS $op)
{
?>
	<tr>
		<td width="30%" align="left" valign="middle" class="tablerow" ><?=$op['option']?> </td>
		<td class="tablerow" colspan="2">
		<img src="<?=PHPCMS_PATH?>images/bar/bar<?=$op['i']?>.gif" width="<?=$op['lenth']?>" height="11">&nbsp;
		<b><?=$op['number']?></b>&nbsp;(<?=$op['per']?>)
		</td>
	</tr>
<?php
}	
?>
	<tr align="center">
		<td class="tablerowhighlight">用户名</td>
		<td class="tablerowhighlight">投票时间</td>
		<td class="tablerowhighlight">IP</td>
	</tr>
<?php
foreach($memberdata AS $v)
{
?>

<tr align="center" onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
	<td>
		<?php
		if($v['voteuser'] == '')	echo '游客';
		else
		?><a href='<?=PHPCMS_PATH?>member/member.php?username=<?=urlencode($v['voteuser'])?>' target='_blank'><?php echo $v['voteuser'];?>
		</a>	</td>
	<td><?php echo $v['votetime'];?></td>
	<td><?php echo $v['ip'].'-'.$v['vip']['country'];?></td>
</tr>
<?php
}
?>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td height="20" align="center"><?=$pages?></td>
  </tr>
</table>
</body>
</html>