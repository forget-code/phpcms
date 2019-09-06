<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&keyid=<?=$keyid?>">

<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="6">推荐位置管理</th>
  </tr>
<tr align="center">
<td class="tablerowhighlight">删除</td>
<td class="tablerowhighlight">ID</td>
<td class="tablerowhighlight">排序</td>
<td class="tablerowhighlight">位置名称</td>
<td class="tablerowhighlight">所属模块/频道</td>
</tr>
<?php 
	foreach($poss as $id=>$pos)
	{ 
?>
<tr align="left" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td align="center"><input type="checkbox" name="delete[<?=$id?>]" id="posid<?=$id?>" value="1" /></td>
<td align="center"><?=$id?></td>
<td align="center"><input type="text" name="listorder[<?=$id?>]" value="<?=$pos['listorder']?>" size="3"></td>
<td align="center"><input type="text" name="name[<?=$id?>]" value="<?=$pos['name']?>" size="20"></td>
<td align="center">
<?php 
if($keyid)
{
	echo is_numeric($keyid) ? $CHANNEL[$keyid]['channelname'] : $MODULE[$keyid]['name'];
	echo "<input type='hidden' name='keyid".$id."' value='{$pos['keyid']}'>";
}
else
{
    echo keyid_select("keyid".$id, "", $pos['keyid']);
}
?>
</td>
</tr>
<?php 
	}
?>
<tr align="left" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td align="center"></td>
<td align="center">增加：</td>
<td align="center"><input type="text" name="newlistorder" value="<?=$newlistorder?>" size="3"></td>
<td align="center"><input type="text" name="newname" size="20"></td>
<td align="center">
<?php 
if($keyid)
{
	echo is_numeric($keyid) ? $CHANNEL[$keyid]['channelname'] : $MODULE[$keyid]['name'];
	echo "<input type='hidden' name='newkeyid' value='$keyid'>";
}
else
{
    echo keyid_select('newkeyid', '');
}
?>
</td>
</tr>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="15%">
	<input name='chkall' title="全部选中" type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox' /> 全选/不选
	</td>
	<td>
	<input name="dosubmit" type="submit" value=" 更新推荐位置 " />
	</td>
  </tr>
</table>
</form>

</body>
</html>