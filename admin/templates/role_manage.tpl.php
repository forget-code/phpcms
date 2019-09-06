<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>角色管理</caption>
   <tr>
    <th width="5%">ID</th>
    <th width="20%">名称</th>
    <th>描述</th>
    <th width="10%">人数</th>
    <th width="25%">管理操作</th>
   </tr>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr>
    <td class="align_c"><?=$info['roleid']?></td>
    <td><a href="?mod=<?=$mod?>&file=admin&action=manage&roleid=<?=$info['roleid']?>"><?=$info['name']?></a></td>
    <td><?=$info['description']?></td>
    <td class="align_c"><a href="?mod=<?=$mod?>&file=admin&action=manage&roleid=<?=$info['roleid']?>"><?=$role->count($info['roleid'])?></a></td>
    <td class="align_c"><a href="?mod=<?=$mod?>&file=admin&action=manage&roleid=<?=$info['roleid']?>">成员管理</a><?php if($info['roleid'] > 1){ ?> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&roleid=<?=$info['roleid']?>">修改</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=disable&roleid=<?=$info['roleid']?>&disabled=<?=($info['disabled']==1 ? 0 : 1)?>"><?=($info['disabled']==1 ? '<font color="red">启用</font>' : '禁用')?></a>  | 
    <a href="#" onClick="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&roleid=<?=$info['roleid']?>', '是否删除该角色')">删除</a> <?php }else{ ?> | <font color="#cccccc">修改</font> |  <font color="#cccccc">禁用</font>  |  <font color="#cccccc">删除</font><?php } ?> </td>
</tr>
<?php 
	}
}
?>
</table>
</body>
</html>