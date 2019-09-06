<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=update">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>风格管理</caption>
<tr>
<th>风格名称</th>
<th width="100">风格目录</th>
<th width="120">修改时间</th>
<th width="80">系统默认</th>
<th width="200">管理操作</th>
</tr>
<?php 
if(is_array($skins)){
	foreach($skins as $skin){
?>
<tr>
<td class="align_l"><input type="text" name="skinname[<?=$skin['dir']?>]" size="30" value="<?=$skin['name']?>"></td>
<td class="align_l"><?=$skin['dir']?></td>
<td class="align_c"><?=$skin['mtime']?></td>
<td class="align_c"><?php if($skin['isdefault']){?>√<?php }?></td>
<td class="align_c"><?php if($skin['isdefault']){?><span class="gray">设为默认</span><?php }else{ ?><a href="?mod=<?=$mod?>&file=<?=$file?>&action=setdefault&skin=<?=$skin['dir']?>&project=<?=$project?>">设为默认</a><?php } ?> | 
<?php if($skin['isdefault']){?><span class="gray">删除</span><?php }else{ ?><a href="?mod=<?=$mod?>&file=<?=$file?>&action=delete&skin=<?=$skin['dir']?>&project=<?=$project?>">删除</a><?php } ?></td>
</tr>
<?php 
	}
}
?>
</table>
<div class="button_box"><input type="submit" name="submit" value=" 更新风格名称 "></div>
</form>
<table cellpadding="0" cellspacing="1" border="0" class="table_info" >
  <tr>
    <caption>提示信息</caption>
  <tr>
    <td>
	1、当前模板方案的风格保存在 <font color="red">./templates/<?=$project?>/skins/</font>  目录<br/>
	2、当前系统默认风格为：<font color="red"><?=$skinname?></font> ，保存路径为： <font color="red">./templates/<?=TPL_NAME?>/skins/<?=TPL_CSS?>/</font> ，其他模板方案的变化不会影响网站前台的显示。<br/>
	</td>
  </tr>
</table>
</body>
</html>