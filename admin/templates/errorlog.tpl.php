<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=update">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=6>PHP 错误日志</th>
  </tr>
<tr align="center">
<td width="4%" class="tablerowhighlight">ID</td>
<td width="40%" class="tablerowhighlight">路径</td>
<td width="6%" class="tablerowhighlight">行数</td>
<td width="30%" class="tablerowhighlight">提示</td>
<td width="8%" class="tablerowhighlight">级别</td>
<td width="12%" class="tablerowhighlight">时间</td>
</tr>
<?php 
if(is_array($logarr)){
	foreach($logarr as $log){
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><?=$log['errornum']?></td>
<td align="left"><?=$log['scriptname']?></td>
<td><?=$log['scriptlinenum']?></td>
<td align="left"><?=$log['errormsg']?></td>
<td><?=$log['errortype']?></td>
<td><?=$log['datetime']?></td>
</tr>
<?php 
	}
}
?>
</table>
</form>

</body>
</html>