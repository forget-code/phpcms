<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=9>模块管理</th>
  </tr>
<tr align="center">
<td width="18%" class="tablerowhighlight">模块名称</td>
<td width="10%" class="tablerowhighlight">模块目录</td>
<td width="29%" class="tablerowhighlight">管理员</td>
<td width="8%" class="tablerowhighlight">版本号</td>
<td width="10%" class="tablerowhighlight">更新日期</td>
<td width="25%" class="tablerowhighlight">管理操作</td>
</tr>
<?php 
if(is_array($modules)){
	foreach($modules as $module){
?>
<tr align="center" onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><a href="?mod=phpcms&file=module&action=view&moduleid=<?=$module['moduleid']?>" title="发布日期：<?=$module['publishdate']?><?="\n"?>安装日期：<?=$module['installdate']?>"><?=$module['name']?></a></td>
<td><?=$module['module']?></td>
<td align="left"><?=$module['admin']?></td>
<td><?=$module['version']?></td>
<td><?=$module['updatedate']?></td>
<td>
<a href="?mod=phpcms&file=module&action=faq&moduleid=<?=$module['moduleid']?>" title="点击查看使用帮助">帮助</a> | 
<a href="?mod=<?=$module['module']?>&file=setting">配置</a> | 
<?php
if($module['iscore'])
{
	echo "<font color='#BBBBBB'>禁止</font> | <font color='#BBBBBB'>禁止</font>";
}
else 
{
	if($module['disabled'])	echo "<a href=\"?mod=phpcms&file=module&action=disable&value=0&moduleid=".$module['moduleid']."\">启用</a> | ";

	else echo "<a href=\"?mod=phpcms&file=module&action=disable&value=1&moduleid=".$module['moduleid']."\">禁用</a> | ";
?>
<a href="javascript:if(confirm('确认卸载该模块吗？将会删除该模块所有数据')) location='?mod=phpcms&file=module&action=uninstall&modulename=<?=$module['module']?>'">卸载</a>
<? } ?>
</td>
</tr>
<?php 
	}
}
?>
</table>
</body>
</html>