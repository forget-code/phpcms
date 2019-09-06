<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>关键词管理</caption>
    <tr>
        <th width="5%"><strong>排序</strong></th>
        <th><strong>关键词</strong></th>
        <th width="10%"><strong>引用次数</strong></th>
        <th width="20%"><strong>最后引用</strong></th>
        <th width="10%"><strong>点击次数</strong></th>
        <th width="20%"><strong>最后访问</strong></th>
        <th width="20%"><strong>管理操作</strong></th>
    </tr>
<?php
if(is_array($infos)){
	foreach($infos as $info){
?>
    <tr>
        <td class="align_c"><input name='listorder[<?=$info['tagid']?>]' type='text' size='3' value='<?=$info['listorder']?>'></td>
        <td class="align_c"><a href="tag.php?tag=<?=urlencode($info['tag'])?>" target="_blank"><span  class="<?=$info['style']?>"><?=$info['tag']?></span></a></td>
        <td class="align_c"><?=$info['usetimes']?></td>
         <td class="align_c"><?=$info['lastusetime'] ? date('Y-m-d H:i', $info['lastusetime']):''?></td>
       <td class="align_c"><?=$info['hits']?></td>
        <td class="align_c"><?=$info['lasthittime']?date('Y-m-d H:i', $info['lasthittime']):''?></td>
        <td class="align_c"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&tag=<?=urlencode($info['tag'])?>">修改</a> | <a href="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&tagid=<?=$info['tagid']?>', '是否删除该关键词')">删除</a> </td>
    </tr>
<?php
	}
}
?>
</table>
<div class="button_box"><input name="submit" type="submit" size="4" value=" 排序 "></div>
<div id="pages"><?=$keyword->pages?></div>
</form>
</body>
</html>