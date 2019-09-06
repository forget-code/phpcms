<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=5>推广联盟访问记录</th>
  </tr>
<tr align="center">
<td width="*" class="tablerowhighlight">来源地址</td>
<td width="15%" class="tablerowhighlight">访问IP</td>
<td width="16%" class="tablerowhighlight">访问时间</td>
<td width="12%" class="tablerowhighlight">注册用户</td>
<td width="16%"  class="tablerowhighlight">注册时间</td>
</tr>
<?php
if(is_array($visits)) 
{
foreach($visits AS $visit) {
?>
<tr height="20" align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><a href="<?=$visit['referer']?>" target="_blank" title="<?=$visit['referer']?>"><?=str_cut($visit['referer'], 50)?></a></td>
<td><a href="http://www.phpcms.cn/ip.php?ip=<?=$visit['visitip']?>" target="_blank" title="查看IP来源"><?=$visit['visitip']?></a></td>
<td><?=$visit['visittime']?></td>
<td><a href="?mod=member&file=member&action=view&username=<?=urlencode($visit['regusername'])?>"><?=$visit['regusername']?></a></td>
<td><?=$visit['regtime']?></td>
</tr>
<?php
	}
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