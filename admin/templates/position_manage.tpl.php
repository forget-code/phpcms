<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>推荐位管理</caption>
    <tr>
        <th width="5%">排序</th>
        <th width="5%">ID</th>
        <th>推荐位名称</th>
        <th>数据量</th>
        <th width="25%">管理操作</th>
    </tr>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
    <tr>
        <td class="align_c"><input type="text" name="info[<?=$info['posid']?>]" value="<?=$info['listorder']?>" size="5"></td>
        <td class="align_c"><?=$info['posid']?></td>
        <td class="align_c"><a href="<?=$info['url']?>" target="_blank"><?=$info['name']?></a></td>
        <td class="align_c"><?=$pos->count($info['posid'])?></td>
        <td class="align_c"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&posid=<?=$info['posid']?>">修改</a>  | <a href="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&posid=<?=$info['posid']?>', '是否删除该推荐位')">删除</a> </td>
    </tr>
<?php 
	}
}
?>
</table>
<div class="button_box"> <input name="dosubmit" type="submit" value=" 更新排序 " /></div>
<div id="pages"><?=$pos->pages?></div>
</form>
</body>
</html>