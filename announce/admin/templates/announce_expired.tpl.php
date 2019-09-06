<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="post" name="myform">
<table cellpadding="0" cellspacing="1" class="table_list">
<caption>过期公告</caption>
<tr>
	<th>选中</th>
	<th>标题</th>
	<th>开始时间</th>
	<th>结束时间</th>
	<th>作者</th>
	<th>浏览次数</th>
	<th>发表时间</th>
	<th>管理操作</th>
</tr>
<? if(is_array($annou)) foreach($annou AS $annou) { ?>
<tr>
	<td class="align_c"><input type="checkbox" name="aid[]" value="<?=$annou['announceid']?>"></td>
	<td><?=$annou['title']?></td>
	<td class="align_c"><?=$annou['fromdate']?></td>
	<td class="align_c"><?=$annou['todate']?></td>
	<td><?=$annou['username']?></td>
	<td class="align_c"><?=$annou['hits']?></td>
	<td class="align_c"><?=$annou['addtime']?></td>
	<td class="align_c"><a href="<?php echo PHPCMS_PATH.$mod."/?announceid=".$annou['announceid'];?>" title="前台预览"  target="_blank">前台</a> |  
		<a href='?mod=announce&file=announce&action=edit&aid=<?=$annou['announceid']?>'>修改</a></td>
</tr>

<? } ?>

</table>

<div class="button_box">
	<a href="#" onClick="javascript:$('input[type=checkbox]').attr('checked', true)">全选</a>/<a href="#" onClick="javascript:$('input[type=checkbox]').attr('checked', false)">取消</a>
	<input name="submit1" type="submit"  value="删除选定的公告" onClick="document.myform.action='?mod=announce&file=announce&action=delete';return confirm('您确定要删除吗？')">&nbsp;&nbsp;
</div>
</form>
<div id="pages"><?=$a->pages?></div>
</body>
</html>