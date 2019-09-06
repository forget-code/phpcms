<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
<table width="100%" cellpadding="3" cellspacing="1" align="center" class="tableborder">
	<thead>
		<tr>
			<th colspan="9" align="left"><?php echo $title; ?></th>
		</tr>
	</thead>
	<tbody class="trbg1">
		<tr>
			<td width="5%" align="center" valign="middle" class="tablerowhighlight">排名</td>
			<td width="15%" align="center" valign="middle" class="tablerowhighlight">用户名</td>
			<td width="8%" align="center" valign="middle" class="tablerowhighlight">积分</td>
			<td width="15%" align="center" valign="middle" class="tablerowhighlight">等级</td>
			<td width="15%" align="center" valign="middle" class="tablerowhighlight">在线时间</td>
			<td width="17%" align="center" valign="middle" class="tablerowhighlight">最后登录</td>
			<td width="8%" align="center" valign="middle" class="tablerowhighlight">登录次数</td>
			<td width="6%" align="center" valign="middle" class="tablerowhighlight">回答数</td>
			<td width="8%" align="center" valign="middle" class="tablerowhighlight">被采纳数</td>
		</tr>
<?php
	foreach ($members_list as $members) {
?>
		<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
			<td align="center" valign="middle"><?php echo $members['orderid'];?></td>
			<td align="center" valign="middle"><?php echo $members['username'];?></td>
			<td align="center" valign="middle"><?php if($members['num']) echo $members['num']; else echo $members['credit'];?></td>
			<td align="center" valign="middle"><?php echo $members['grade'];?></td>
			<td align="center" valign="middle"><?php echo $members['totalonline_hour'].'时'.$members['totalonline_minute'].'分';?></td>
			<td align="center" valign="middle"><?php echo $members['lastlogintime'];?></td>
			<td align="center" valign="middle"><?php echo $members['logintimes'];?></td>			
			<td align="center" valign="middle"><?php echo $members['answercounts'];?></td>
			<td align="center" valign="middle"><?php echo $members['acceptcount'];?></td>
		</tr>
<?php
}
?>		
</tbody>
</table>
<br />
<?php
if ($total) {
?>
<div style="text-align:center"><?php echo $phpcmspage; ?></div>
<?php
}
?>
</body>
</html>