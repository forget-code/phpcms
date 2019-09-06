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
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="25">
  <tr>
    <td>当前位置：<a href="?mod=phpcms&file=templateproject&action=manage">模板方案管理</a> > </td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=7>模板方案管理</th>
  </tr>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=update">
<tr align="center">
<td width="25%" class="tablerowhighlight">模板方案名称</td>
<td width="15%" class="tablerowhighlight">模板方案目录</td>
<td width="20%" class="tablerowhighlight">修改时间</td>
<td width="10%" class="tablerowhighlight">系统默认</td>
<td width="30%" class="tablerowhighlight">管理操作</td>
</tr>
<?php 
if(is_array($templateprojects)){
	foreach($templateprojects as $templateproject){
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input type="text" name="templateprojectname[<?=$templateproject['dir']?>]" size="20" value="<?=$templateproject['name']?>"></td>
<td align="left"><?=$templateproject['dir']?></td>
<td><?=$templateproject['mtime']?></td>
<td><?php if($templateproject['isdefault']){?>√<?php }?></td>
<td>
<?php if($templateproject['isdefault']){?><span class="gray">设为默认</span><?php }else{ ?><a href="?mod=<?=$mod?>&file=<?=$file?>&action=setdefault&templateproject=<?=$templateproject['dir']?>">设为默认</a><?php } ?> | 
<a href="?mod=<?=$mod?>&file=template&action=manage&project=<?=$templateproject['dir']?>">管理模板</a> | 
<a href="?mod=<?=$mod?>&file=skin&action=manage&project=<?=$templateproject['dir']?>">管理风格</a> | 
<?php if($templateproject['isdefault']){?><span class="gray">删除</span><?php }else{ ?><a href="?mod=<?=$mod?>&file=<?=$file?>&action=delete&project=<?=$templateproject['dir']?>">删除</a><?php } ?> </td>
</tr>
<?php 
	}
}
?>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left">&nbsp;&nbsp;<input type="submit" name="submit" value=" 更新模板方案名称 "></td>
  </tr>
</table>
</form>
<br/>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <td class="submenu" align=center>提示信息</td>
  </tr>
  <tr>
    <td class="tablerow">
	1、所有模板方案都保存在 <font color="red">./templates/</font> 目录下（如果需要在线修改，请通过ftp将该目录设置为 777 ，并应用到子目录）<br/>
	2、网站当前使用的模板方案为：<font color="red"><?=$templateprojectnames[$defaulttemplate]?></font> ，保存路径为： <font color="red">./templates/<?=$defaulttemplate?>/</font> ，其他模板方案的变化不会影响网站前台的显示。<br/>
	3、如果您需要增加网站模板方案，请把新的模板方案上传至 <font color="red">./templates/</font> 目录 <br/>
	4、如果您需要应用新的网站模板方案，请把该模板方案设置为系统默认方案 <br/>
	</td>
  </tr>
</table>
</body>
</html>