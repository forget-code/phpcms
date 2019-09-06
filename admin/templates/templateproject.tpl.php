<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=update">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>模板方案管理</caption>
<tr>
<th>方案名称</th>
<th width="100">模板目录</th>
<th width="120">修改时间</th>
<th width="60">系统默认</th>
<th width="250">管理操作</th>
</tr>
<?php 
if(is_array($templateprojects)){
	foreach($templateprojects as $templateproject){
?>
<tr>
<td><input type="text" name="templateprojectname[<?=$templateproject['dir']?>]" size="30" value="<?=$templateproject['name']?>"></td>
<td class="align_l"><?=$templateproject['dir']?></td>
<td class="align_c"><?=$templateproject['mtime']?></td>
<td class="align_c"><?php if($templateproject['isdefault']){?>√<?php }?></td>
<td class="align_c">
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
<div class="button_box"><input type="submit" name="submit" value=" 更新模板方案名称 "></div>
</form>
<table cellpadding="2" cellspacing="1" border="0" class="table_info" >
    <caption>提示信息</caption>
  <tr>
    <td>
	1、所有模板方案都保存在 <font color="red">./templates/</font> 目录下（如果需要在线修改，请通过ftp将该目录设置为 777 ，并应用到子目录）<br/>
	2、网站当前使用的模板方案为：<font color="red"><?=$projects[TPL_NAME]?></font> ，保存路径为： <font color="red">./templates/<?=TPL_NAME?>/</font> ，其他模板方案的变化不会影响网站前台的显示。<br/>
	3、如果您需要增加网站模板方案，请把新的模板方案上传至 <font color="red">./templates/</font> 目录 <br/>
	4、如果您需要应用新的网站模板方案，请把该模板方案设置为系统默认方案 <br/>
	</td>
  </tr>
</table>
</body>
</html>