<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myform" method="post" action="">
<input type="hidden" name="mod" value="<?=$mod?>">
<input type="hidden" name="file" value="<?=$file?>">
<input type="hidden" name="action" value="listorder">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>会员组管理</caption>
<tr>
<th width="5%"><strong>排序</strong></th>
<th width="10%"><strong>会员组</strong></td>
<th width="*"><strong>服务</strong></th>
<th width="5%"><strong>会员数</strong></th>
<th width="10%"><strong>发布</strong></th>
<th width="10%"><strong>访问</strong></th>
<th width="10%"><strong>系统组</strong></th>
<th width="15%"><strong>管理操作</strong></th>
</tr>
<?php 
if(is_array($groups))
{
  foreach($groups as $group){
?>
<tr>
<td class="align_c"><input type="text" name="listorders[<?=$group['groupid']?>]" value="<?=$group['listorder']?>" size="3"></td>
<td class="align_c"><a href="?mod=member&file=member&action=manage&groupid=<?=$group['groupid']?>"><?=$group['name']?></a></td>
<td><?=str_cut(strip_tags($group['description']), 50)?></td>
<td class="align_c"><a href="?mod=member&file=member&action=manage&groupid=<?=$group['groupid']?>"><?=$member_admin->count_member("groupid=$group[groupid]")?></a></td>
<td class="align_c"><?=$group['allowpost']?'<font color="red">√</font>':''?></td>
<td class="align_c"><?=$group['allowvisit']?'<font color="red">√</font>':''?></td>
<td class="align_c"><?=$group['issystem']?'<font color="red">√</font>':''?></td>
<td class="align_c">
<a href='?mod=<?=$mod?>&file=<?=$file?>&action=edit&groupid=<?=$group['groupid']?>'>修改</a>
<?php if (!$group['issystem']) { ?>
 | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=disabled&groupid=<?=$group['groupid']?>&val=<?=($group['disabled']) ? '0' : '1'?>"><?=($group['disabled']==1 ? '<font color="blue">启用</font>' : '禁用')?></a> | <a href='#' onClick="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&groupid=<?=$group['groupid']?>', '是否删除该用户组')">删除</a>
<?php }else{ ?>
| <font color="#cccccc">禁用</font> | <font color="#cccccc">删除</font>
<?php } ?>
</td>
</tr>
<?php } 
}
?>
</table>
<div class="button_box">
	<input type='submit' name="dosubmit" value='排序'>
</div>
</form>
</body>
</html>