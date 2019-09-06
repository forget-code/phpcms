<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form name="myform" method="post" action="">
 <table cellpadding="0" cellspacing="1" class="table_list">
  <caption>定时发布信息列表</caption>
<tr align="center">
<th width="30">选中</th>
<th width="40">ID</th>
<th>标题</th>
<th width="80">状态</th>
<th width="70">录入者</th>
<th width="120">更新时间</th>
<th width="100">管理操作</th>
</tr>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr>
<td><input type="checkbox" name="contentid[]" value="<?=$info['contentid']?>" id="content_<?=$info['contentid']?>" /></td>
<td><?=$info['contentid']?></td>
<td><a href="show.php?contentid=<?=$info['contentid']?>" target="_blank"><?=output::style($info['title'], $info['style'])?></a> <?=$info['thumb'] ? '<font color="red">图</font>' : ''?></td>
<td class="align_c"><?=$STATUS[$info['status']]?></td>
<td class="align_c"><a href="?mod=member&file=member&action=view&userid=<?=$info['userid']?>"><?=$info['username']?></td>
<td class="align_c"><?=date('Y-m-d', $info['inputtime'])?></td>
<td class="align_c">
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=view&catid=<?=$info['catid']?>&contentid=<?=$info['contentid']?>">查看</a> | 
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&catid=<?=$info['catid']?>&contentid=<?=$info['contentid']?>">修改</a> 
</td>
</tr>
<?php 
	}
}
?>
</table>
<div class="button_box">
<span style="width:60px"><a href="###" onclick="javascript:$('input[type=checkbox]').attr('checked', true)">全选</a>/<a href="###" onclick="javascript:$('input[type=checkbox]').attr('checked', false)">取消</a></span>
		<input type="button" name="pass" value="立即发布"  onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=publish&catid=<?=$catid?>&do=publish&forward=<?=urlencode(URL)?>';myform.submit();"> 
		<input type="button" name="reject" value=" 删除 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=publish&catid=<?=$catid?>&do=del&forward=<?=urlencode(URL)?>';myform.submit();"> 
</div>
<div id="pages"><?=$c->pages?></div>
</form>
</body>
</html>