<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form name="myform" method="post" action="">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>回收站管理</caption>
<tr>
<th width="30">选中</th>
<th width="40">ID</th>
<th>标题</th>
<th width="80">状态</th>
<th width="70">录入者</th>
<th width="120">更新时间</th>
<th width="170">管理操作</th>
</tr>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr>
<td class="align_c"><input type="checkbox" name="contentid[]" value="<?=$info['contentid']?>" id="content_<?=$info['contentid']?>" /></td>
<td><?=$info['contentid']?></td>
<td><a href="show.php?id=<?=$info['contentid']?>" target="_blank"><?=output::style($info['title'], $info['style'])?></a></td>
<td class="align_c"><?=$STATUS[$info['status']]?></td>
<td class="align_c"><a href="?mod=member&file=member&action=view&userid=<?=$info['userid']?>"><?=$info['username']?></td>
<td class="align_c"><?=date('Y-m-d H:i', $info['updatetime'])?></td>
<td class="align_c">
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=view&contentid=<?=$info['contentid']?>">查看</a> | 
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&contentid=<?=$info['contentid']?>">修改</a> | 
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=log_list&contentid=<?=$info['contentid']?>">日志</a> 
<?php if(isset($MODULE['comment'])){ ?> | <a href="?mod=comment&file=comment&keyid=phpcms-content-title-<?=$info['contentid']?>">评论</a> <?php } ?>
</td>
</tr>
<?php 
	}
}
?>
</table>
<div class="button_box">
<span style="width:60px"><a href="###" onclick="javascript:$('input[type=checkbox]').attr('checked', true)">全选</a>/<a href="###" onclick="javascript:$('input[type=checkbox]').attr('checked', false)">取消</a></span>
		<input type="button" name="delete" value="彻底删除" onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete&catid=<?=$catid?>&forward=<?=urlencode(URL)?>';myform.submit();"> 
		<input type="button" name="clear" value="清空回收站" onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=clear&catid=<?=$catid?>&forward=<?=urlencode(URL)?>';myform.submit();"> 
		<input type="button" name="restore" value=" 还原 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=restore&catid=<?=$catid?>&forward=<?=urlencode(URL)?>';myform.submit();"> 
		<input type="button" name="restoreall" value="全部还原" onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=restoreall&catid=<?=$catid?>&forward=<?=urlencode(URL)?>';myform.submit();"> 
</div>
<div id="pages"><?=$c->pages?></div>
</form>
</body>
</html>