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
<table cellpadding="2" cellspacing="1" class="tableborder"><form method="post" name="myform">
<th colspan=2><a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage"><font color="white">采集内容查看</font></a></th> 
<tr align="center">
<td width="10%" class="tablerowhighlight">标签名</td>
<td width="90%" class="tablerowhighlight">标签内容</td>
</tr>
<?php 
if(is_array($labels)){
	foreach($labels as $labelkey=>$labelvalue){
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><strong><?=$labelkey?></strong></td>
<td align="left"><?=$labelvalue?></td>
</tr>
<?php 
	}
}
?>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><input type="button" name="submits" value="返回" onClick="history.back(-1);">
 </td>
  </tr>
</table>
</body>
</html>