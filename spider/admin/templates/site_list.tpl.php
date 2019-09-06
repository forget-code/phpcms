<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder"><form method="post" name="myform">
  <tr>
    <th colspan=14><a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage"><font color="white">采集站点管理</font></a></th>
  </tr>
<tr align="center">
<td width="5%" class="tablerowhighlight">选中</td>
<td width="5%" class="tablerowhighlight">ID</td>
<td width="*" class="tablerowhighlight">站点名称</td>
<td width="20%" class="tablerowhighlight">站点URL</td>
<td width="20%" class="tablerowhighlight">站点描述</td>
<td width="33%" class="tablerowhighlight">管理操作</td>
</tr>
<?php 
if(is_array($sites)){
	foreach($sites as $site){
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input type="checkbox" name="siteid[]"  id="siteid[]" value="<?=$site['Id']?>"></td>
<td><?=$site['Id']?></td>
<td> <A HREF="?mod=spider&file=sitemgr&action=modify&siteid=<?=$site['Id']?>" title="编辑该站点规则"><?=$site['SiteName']?></A></td>
<td> <a href="<?=$site['SiteUrl']?>" target="_blank"><?=$site['SiteUrl']?></a></td>
<td><?=$site['Description']?></td>
<td align="left">&nbsp;<a href="javascript:openwinx('?mod=<?=$mod?>&file=<?=$file?>&action=catchsiteinfo&sitename=<?=$site['SiteName']?>&siteid=<?=$site['Id']?>','共享站点规则','830','580')">共享</a>
<A HREF="?mod=spider&file=sitemgr&action=modify&siteid=<?=$site['Id']?>">编辑</A>
<A HREF="javascript:if(confirm('确认删除该站点吗?')) location='?mod=spider&file=sitemgr&action=delete&siteid=<?=$site['Id']?>'">删除</A>
<a href="?mod=<?=$mod?>&file=sitemgr&action=siteout&siteid=<?=$site['Id']?>&sname=<?=urlencode($site['SiteName'])?>">导出站点规则</A>
<A HREF="?mod=spider&file=jobmgr&action=add&loadsiterule=<?=$site['Id']?>"><font color='blue'>添加任务</font></A>
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
	采集站点管理是方便您对采集的来源站进行分类管理，先建立采集站点再在其下面建立采集任务！
	</td>
  </tr>
</table>
</body>
</html>