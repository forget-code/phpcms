<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>关联链接管理</caption>
    <tr>
        <th width="5%"><strong>排序</strong></th>
        <th width="5%"><strong>ID</strong></th>
        <th><strong>关键词</strong></th>
        <th width="20%"><strong>链接地址</strong></th>
        <th width="20%"><strong>管理操作</strong></th>
    </tr>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
    <tr>
        <td class="align_c"><input type="text" name="info[<?=$info['keylinkid']?>]" value="<?=$info['listorder']?>" size="5"></td>
        <td class="align_c"><?=$info['keylinkid']?></td>
        <td><a href="<?=$info['url']?>" target="_blank"><?=$info['word']?></a></td>
        <td><?=$info['url']?></td>
        <td class="align_c"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&keylinkid=<?=$info['keylinkid']?>">修改</a>  | <a href="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&keylinkid=<?=$info['keylinkid']?>','是否删除该关联链接')">删除</a> </td>
    </tr>
<?php 
	}
}
?>
</table>
    <div class="button_box">
    	<input name="submit" type="submit" size="4" value=" 更新排序 ">
    </div>
    <div id="pages">
		<?=$keylink->pages?>
    </div>
</form>
</body>
</html>