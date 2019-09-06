<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form name="search" method="get" action="">
<input type="hidden" name="mod" value="<?=$mod?>"> 
<input type="hidden" name="file" value="<?=$file?>"> 
<input type="hidden" name="action" value="<?=$action?>"> 
<input type="hidden" name="catid" value="<?=$catid?>"> 
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>搜索信息</caption>
<tr>
<td align="center">
<?=form::select_type('phpcms', 'typeid','typeid','类别', $typeid)?>
<input type="hidden" name="areaid" id="areaid" value="">
<span id="load_areaid"></span>
<a href="javascript:areaid_reload();">重选</a>
<script type="text/javascript">
function areaid_load(id)
{
	$.get('load.php', { field: 'areaid', id: id },
		  function(data){
			$('#load_areaid').append(data);
		  });
}
function areaid_reload()
{
	$('#load_areaid').html('');
	areaid_load(0);
}
areaid_load(0);
</script>
&nbsp;
<select name='field'>
<option value='title' <?=$field == 'title' ? 'selected' : ''?> >标题</option>
<option value='userid' <?=$field == 'userid' ? 'selected' : ''?> >发布人</option>
<option value='contentid' <?=$field == 'contentid' ? 'selected' : ''?> >ID</option>
</select>
<input type="text" name="q" value="<?=$q?>" size="15" />&nbsp;
发布时间：<?=form::date('inputdate_start', $inputdate_start)?> - <?=form::date('inputdate_end', $inputdate_end)?>&nbsp;
<input type="submit" name="dosubmit" value=" 查询 " />
</td>
</tr>
</table>
</form>
<form name="myform" method="post" action="">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>搜索结果</caption>
<tr>
<th width="30">选中</th>
<th width="40">排序</th>
<th width="40">ID</th>
<th>标题</th>
<th width="80">状态</th>
<th width="70">录入者</th>
<th width="120">更新时间</th>
<th width="165">管理操作</th>
</tr>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr>
<td><input type="checkbox" name="contentid[]" value="<?=$info['contentid']?>" id="content_<?=$info['contentid']?>" /></td>
<td class="align_c"><input type="text" name="listorders[<?=$info['contentid']?>]" value="<?=$info['listorder']?>" size="3" /></td>
<td><?=$info['contentid']?></td>
<td><a href="<?=$info['url']?>" target="_blank"><?=output::style($info['title'], $info['style'])?></a> <?=$info['thumb'] ? '<font color="red">图</font>' : ''?>&nbsp;<?=$info['posids']?'<font color="green">荐</font>': ''?></td>
<td class="align_c"><?=$STATUS[$info['status']]?></td>
<td class="align_c"><a href="?mod=member&file=member&action=view&userid=<?=$info['userid']?>"><?=$info['username']?></td>
<td class="align_c"><?=date('Y-m-d H:i', $info['updatetime'])?></td>
<td class="align_c">
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=view&catid=<?=$catid?>&contentid=<?=$info['contentid']?>">查看</a> | 
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&catid=<?=$catid?>&contentid=<?=$info['contentid']?>">修改</a> | 
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=log_list&catid=<?=$catid?>&contentid=<?=$info['contentid']?>">日志</a>
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
		<input type="button" name="listorder" value=" 排序 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=listorder&catid=<?=$catid?>&processid=<?=$processid?>&forward=<?=urlencode(URL)?>';myform.submit();"> 
		<input type="button" name="delete" value=" 删除 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=cancel&catid=<?=$catid?>&processid=<?=$processid?>&forward=<?=urlencode(URL)?>';myform.submit();"> 
</div>
<div id="pages"><?=$c->pages?></div>
</form>
</body>
</html>