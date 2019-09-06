<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>作者管理</caption>
<tr>
	<th width="5%"><strong>排序</strong></th>
	<th width="5%"><strong>ID</strong></th>
	<th width="20%"><strong>用户名</strong></th>
	<th width="20%"><strong>姓名</strong></th>
	<th width="5%"><strong>性别</strong></th>
	<th width="10%"><strong>推荐</strong></th>
	<th width="20%"><strong>管理操作</strong></th>
</tr>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr>
    <td class="align_c"><input type="text" name="info[<?=$info['authorid']?>]" value="<?=$info['listorder']?>" size="5"></td>
    <td class="align_c"><?=$info['authorid']?></td>
    <td class="align_c"><?=$info['username']?></td>
    <td class="align_c"><a href="<?=$info['url']?>" target="_blank"><?=$info['name']?></a></td>
    <td class="align_c"><?=$info['gender'] ? '男' : '女'?></td>
    <td class="align_c"><?=$info['elite'] ? '√' : ''?></td>
    <td class="align_c"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&authorid=<?=$info['authorid']?>">修改</a>  | 
    <a href="?mod=<?=$mod?>&file=<?=$file?>&action=disable&authorid=<?=$info['authorid']?>&disabled=<?=($info['disabled']==1 ? 0 : 1)?>"><?=($info['disabled']==1 ? '<font color="blue">启用</font>' : '禁用')?></a>  | 
    <a href="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&authorid=<?=$info['authorid']?>', '是否删除该作者')">删除</a> 
    </td>
</tr>
<?php 
	}
}
?>
</table>
<div class="button_box"><input name="submit" type="submit" size="4" value=" 更新排序 "></div>
<div id="pages"><?=$author->pages?></div>
</form>
</body>
</html>