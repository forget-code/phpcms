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
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=8>模块管理</th>
  </tr>
<tr align="center">
<td width="12%" class="tablerowhighlight">模块名称</td>
<td width="10%" class="tablerowhighlight">模块目录</td>
<td width="8%" class="tablerowhighlight">可复制</td>
<td width="10%" class="tablerowhighlight">作者</td>
<td width="15%" class="tablerowhighlight">E-mail</td>
<td width="20%" class="tablerowhighlight">网站地址</td>
<td width="10%" class="tablerowhighlight">安装日期</td>
<td width="15%" class="tablerowhighlight">管理操作</td>
</tr>
<?php 
if(is_array($modules)){
	foreach($modules as $module){
?>
<tr align="center"  align=center onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><?=$module['modulename']?></td>
<td><?=$module['module']?></td>
<td><?php if($module['enablecopy']){?>是<?php }?></td>
<td><?=$module['author']?></td>
<td><a href="<?=PHPCMS_PATH?>mail/sendmail.php?mailto=<?=$module['authoremail']?>"  target="_blank"><?=$module['authoremail']?></a></td>
<td><a href="<?=$module['authorsite']?>" target="_blank"><?=$module['authorsite']?></a></td>
<td><?=$module['updatetime']?></td>
<td><a href='?file=module&action=setting&module=<?=$module['module']?>'>配置</a> | <?php if($module[passed]){?><a href='?file=module&action=pass&value=0&modid=<?=$module['modid']?>'>禁用</a><?php }else{ ?><a href='?file=module&action=pass&value=1&modid=<?=$module['modid']?>'>启用</a><?php } ?> | <a href='?mod=phpcms&file=module&action=delete&modid=<?=$module['modid']?>'>卸载</a></td>
</tr>
<?php 
	}
}
?>
</table>
</body>
</html>