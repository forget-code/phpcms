<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="post" name="myform">
<table cellpadding="0" cellspacing="1" class="table_list">
<caption>管理公告</caption>
<tr align="center">
	<th width="35" >选中</th>
	<th >标题</th>
	<th >开始日期</th>
	<th >结束日期</th>
	<th>录入者</th>
	<th width="60" >浏览次数</th>
	<th width="140" >发表时间</th>
	<th width="100" >管理操作</th>
</tr>
<? if(is_array($annou)) foreach($annou AS $annou) { ?>
<tr>
	<td class="align_c"><input type="checkbox" name="aid[]" value="<?=$annou['announceid']?>"></td>
	<td><?=$annou['title']?></td>
	<td class="align_c"><?=$annou['fromdate']?></td>
	<td class="align_c"><?=$annou['todate']?></td>
	<td class="align_c"><?=$annou['username']?></td>
	<td class="align_c"><?=$annou['hits']?></td>
	<td class="align_c"><?=$annou['addtime']?></td>
	<td class="align_c"><a href="<?=PHPCMS_PATH.$mod."/?announceid=".$annou['announceid'];?>" title="前台预览"  target="_blank">前台</a> |
		<a href='?mod=announce&file=announce&action=edit&aid=<?=$annou['announceid']?>'>修改</a></td>
</tr>
<? } ?>
</table>
<div class="button_box">
		<a href="#" onClick="javascript:$('input[type=checkbox]').attr('checked', true)">全选</a>/<a href="#" onClick="javascript:$('input[type=checkbox]').attr('checked', false)">取消</a>
        <input name='submit' type='submit' value='取消批准选定的公告' onClick="document.myform.action='?mod=announce&file=announce&action=approval&passed=0'">&nbsp;&nbsp;
		<input name="submit" type="submit"  value="删除选定的公告" onClick="document.myform.action='?mod=announce&file=announce&action=delete';return confirm('您确定要删除吗？')">&nbsp;&nbsp;
</div>
</form>

<div id="pages"><?=$a->pages?></div>


</body>
</html>