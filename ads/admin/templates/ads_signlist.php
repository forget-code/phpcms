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
  <tr>
    <th colspan=14><a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&channelid=<?=$channelid?>"><font color="white">广告管理</font></a></th>
  </tr>
<tr align="center">
<td width="5%" class="tablerowhighlight">选中</td>
<td width="5%" class="tablerowhighlight">ID</td>
<td width="*" class="tablerowhighlight">广告名称</td>
<td width="5%" class="tablerowhighlight">类型</td>
<td width="5%" class="tablerowhighlight">频道</td>
<td width="15%" class="tablerowhighlight">广告位名</td>
<td width="10%" class="tablerowhighlight">客户名称</td>
<td width="8%" class="tablerowhighlight">发布日期</td>
<td width="8%" class="tablerowhighlight">结束日期</td>
<td width="12%" class="tablerowhighlight">管理操作</td>
</tr>
<?php 
if(is_array($adss)){
	foreach($adss as $ads){
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input type="checkbox" name="adsid[]"  id="adsid[]" value="<?=$ads['adsid']?>"></td>
<td><?=$ads['adsid']?></td>
<td> <A HREF="?mod=ads&file=ads&action=view&adsid=<?=$ads['adsid']?>" target="_blank"><?=$ads['adsname']?></A></td>
<td><?=$ads['typename']?></td>
<td><?=$ads['channelname']?></td>
<td><?=$ads['placename']?></td>
<td><?=$ads['username']?></td>
<td><?=$ads['fromdate']?></td>
<td><?=$ads['todate']?></td>
<td><A HREF="?mod=ads&file=ads&action=pass&adsid=<?=$ads['adsid']?>">审核通过</A></td>
</tr>
<?php 
	}
}
?>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全选/反选</td>
    <td>
<input type="submit" name="submit" value="批量审核通过" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=pass'">&nbsp;&nbsp;
<input type="submit" name="submit" value="批量删除" onClick="if(confirm('确认删除记录吗？')) document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete'">&nbsp;&nbsp;
</td>
  </tr></form>
</table>
<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align=center><?=$pages?></td>
  </tr>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
</body>
</html>