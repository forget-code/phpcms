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
    <td>当前位置：<a href="?mod=phpcms&file=templateproject&action=manage">模板方案管理</a> > <a href="?mod=phpcms&file=template&action=manage&project=<?=$project?>&module=<?=$module?>"><?=$projectname?> - 风格管理</a></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=7>风格管理</th>
  </tr>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=update">
<tr align="center">
<td width="25%" class="tablerowhighlight">风格名称</td>
<td width="20%" class="tablerowhighlight">风格目录</td>
<td width="20%" class="tablerowhighlight">修改时间</td>
<td width="15%" class="tablerowhighlight">系统默认</td>
<td width="20%" class="tablerowhighlight">管理操作</td>
</tr>
<?php 
if(is_array($skins)){
	foreach($skins as $skin){
?>
<tr align=center onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input type="text" name="skinname[<?=$skin['dir']?>]" size="20" value="<?=$skin['name']?>"></td>
<td align="left"><?=$skin['dir']?></td>
<td><?=$skin['mtime']?></td>
<td><?php if($skin['isdefault']){?>√<?php }?></td>
<td><?php if($skin['isdefault']){?><span class="gray">设为默认</span><?php }else{ ?><a href="?mod=<?=$mod?>&file=<?=$file?>&action=setdefault&skin=<?=$skin['dir']?>&project=<?=$project?>">设为默认</a><?php } ?> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&skin=<?=$skin['dir']?>&project=<?=$project?>">修改</a> | 
<?php if($skin['isdefault']){?><span class="gray">删除</span><?php }else{ ?><a href="?mod=<?=$mod?>&file=<?=$file?>&action=delete&skin=<?=$skin['dir']?>&project=<?=$project?>">删除</a><?php } ?></td>
</tr>
<?php 
	}
}
?>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left">&nbsp;&nbsp;<input type="submit" name="submit" value=" 更新风格名称 "></td>
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
	1、当前模板方案的风格保存在 <font color="red">./templates/<?=$project?>/skins/</font>  目录（您可以在线修改风格的样式表文件）<br/>
	2、当前系统默认风格为：<font color="red"><?=$skinname?></font> ，保存路径为： <font color="red">./templates/<?=$defaulttemplate?>/</font> ，其他模板方案的变化不会影响网站前台的显示。<br/>
	</td>
  </tr>
</table>
</body>
</html>