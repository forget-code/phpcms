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
<td width="4%" class="tablerowhighlight">ID</td>
<td width="*" class="tablerowhighlight">广告名称</td>
<td width="5%" class="tablerowhighlight">频道</td>
<td width="15%" class="tablerowhighlight">广告位名</td>
<td width="5%" class="tablerowhighlight">点击</td>
<td width="5%" class="tablerowhighlight">浏览</td>
<td width="8%" class="tablerowhighlight">客户名称</td>
<td width="8%" class="tablerowhighlight">发布日期</td>
<td width="8%" class="tablerowhighlight">结束日期</td>
<td width="5%" class="tablerowhighlight">状态</td>
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
<td><?=$ads['channelname']?></td>
<td><?=$ads['placename']?></td>
<td><?=$ads['hits']?></td>
<td><?=$ads['views']?></td>
<td><a href="<?=PHPCMS_PATH?>member/member.php?username=<?=$ads['username']?>" target="_blank"><?=$ads['username']?></a></td>
<td><?=$ads['fromdate']?></td>
<td><?=$ads['todate']?></td>
<td><?=$ads['overtime']?></td>
<td><A HREF="?mod=ads&file=ads&action=edit&adsid=<?=$ads['adsid']?>">编辑</A>
| <?php if($ads[status]){?><A HREF="?mod=ads&file=place&action=loadjs&placeid=<?=$ads['placeid']?>">调用代码</A><?php }else{ ?><span class="gray">调用代码</span><?php }?>
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
<input type="submit" name="submit" value="批量删除" onClick="if(confirm('确认删除记录吗？')) document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete'">&nbsp;&nbsp;
</td>
  </tr></form>
</table>
<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align=center><?=$pages?></td>
  </tr>
</table>

<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <td class="submenu" align=center>提示信息</td>
  </tr>
  <tr>
    <td class="tablerow">
	如果您想调用广告，请进广告位管理获取广告位JS调用代码。
	</td>
  </tr>
</table>
</body>
</html>