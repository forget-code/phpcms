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
    <th colspan=13><a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&channelid=<?=$channelid?>"><font color="white">广告位管理</font></a></th>
  </tr>
<tr align="center">
<td width="5%" class="tablerowhighlight">选中</td>
<td width="5%" class="tablerowhighlight">ID</td>
<td width="*" class="tablerowhighlight">广告位名称</td>
<td width="8%" class="tablerowhighlight">模版名</td>
<td width="8%" class="tablerowhighlight">所属频道</td>
<td width="10%" class="tablerowhighlight">版位尺寸</td>
<td width="5%" class="tablerowhighlight">状态</td>
<td width="10%" class="tablerowhighlight">广告价格</td>
<td width="8%" class="tablerowhighlight">当前客户</td>
<td width="8%" class="tablerowhighlight">截至日期</td>
<td width="18%" class="tablerowhighlight">管理操作</td>
</tr>
<?php 
if(is_array($places)){
	foreach($places as $place){
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input type="checkbox" name="placeid[]"  id="placeid[]" value="<?=$place[placeid]?>"></td>
<td><?=$place['placeid']?></td>
<td> <A HREF="?mod=ads&file=place&action=view&placeid=<?=$place['placeid']?>" target="_blank"><?=$place['placename']?></A></td>
<td><?=$templatenames[$place['templateid'].".html"]?></td>
<td><?=$_CHANNEL[$place[channelid]][channelname]?></td>
<td><?=$place['width']?>x<?=$place['height']?></td>
<td><?=$place['passed']?"开放":"锁定"?></td>
<td><?=$place['price']?></td>
<td><?=$place['username']?></td>
<td><?=$place['todate']?></td>
<td><A HREF="?mod=ads&file=place&action=edit&placeid=<?=$place['placeid']?>">编辑</A> | 
<A HREF="?mod=ads&file=place&action=loadjs&placeid=<?=$place['placeid']?>">调用代码</A>
</td>
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
<input type="submit" name="submit" value="批量锁定" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=lock&val=0'">&nbsp;&nbsp;
<input type="submit" name="submit" value="批量解锁" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=lock&val=1'">&nbsp;&nbsp;
<input type="submit" name="submit" value="批量删除" onClick="if(confirm('确认删除此条记录吗？所属的广告将一并删除！不可恢复！')) document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete'">&nbsp;&nbsp;
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