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
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=3>phpcms数据库备份</th>
  </tr>
<form method="post" name="myform" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>">
<tr align="center">
<td width="20%" class="tablerowhighlight">	<input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='check' checked>全选/反选 </td>
<td width="40%" class="tablerowhighlight">数据库表</td>
<td width="40%" class="tablerowhighlight">记录条数</td>
</tr>
<?php 
if(is_array($phpcmstables)){
	foreach($phpcmstables as $k => $tablename){
?>
  <tr>
    <td class="tablerow" align="center">
<input type="checkbox" name="tables[]" value="<?=$tablename?>" checked>
	</td>
    <td class="tablerow">
	<?=$tablename?>
	</td>
    <td class="tablerow" align="center">
	<?=$phpcmsresults[$k]?>
	</td>
</tr>
<?php 
	}
}
?>
  <tr>
    <td colspan=3 class="tablerowhighlight" align="center">分卷备份设置</td>
  </tr>
  <tr>
    <td colspan=3 class="tablerow" align="center">每个分卷文件大小：<input type=text name="sizelimit" value="2048" size=5>K</td>
  </tr>
  <tr>
    <td colspan=3 class="tablerow" align="center"><input type="submit" name="submit" value=" 开始备份数据 "></td>
  </tr>
	</form>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=3>数据库中其他程序数据表备份</th>
  </tr>
<form method="post" name="myformother" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>">
<tr align="center">
<td width="20%" class="tablerowhighlight"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='check' checked>全选/反选 </td>
<td width="40%" class="tablerowhighlight">数据库表</td>
<td width="40%" class="tablerowhighlight">记录条数</td>
</tr>
<?php 
if(is_array($othertables)){
	foreach($othertables as $k => $tablename){
?>
  <tr>
    <td class="tablerow" align="center">
<input type="checkbox" name="tables[]" value="<?=$tablename?>" checked>
	</td>
    <td class="tablerow">
	<?=$tablename?>
	</td>
    <td class="tablerow" align="center">
	<?=$otherresults[$k]?>
	</td>
</tr>
<?php 
	}
}
?>
  <tr>
    <td colspan=3 class="tablerowhighlight" align="center">分卷备份设置</td>
  </tr>
  <tr>
    <td colspan=3 class="tablerow" align="center">每个分卷文件大小：<input type=text name="sizelimit" value="2048" size=5>K</td>
  </tr>
  <tr>
    <td colspan=3 class="tablerow" align="center"><input type="submit" name="submit" value=" 开始备份数据 "></td>
  </tr>
	</form>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td align="center"><?=$pages?></td>
  </tr>
</table>
</body>
</html>