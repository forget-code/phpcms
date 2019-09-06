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
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>招聘信息查询</caption>
<tr>
<td class="align_c">

<select name='field'>
<option value='title' <?=$field == 'title' ? 'selected' : ''?> >职位名</option>
<option value='username' <?=$field == 'username' ? 'selected' : ''?> >用户名</option>
<option value='companyname' <?=$field == 'companyname' ? 'selected' : ''?> >公司名称</option>
<option value='userid' <?=$field == 'userid' ? 'selected' : ''?> >用户ID</option>
<option value='id' <?=$field == 'id' ? 'selected' : ''?> >ID</option>
</select>
<input type="text" name="q" value="<?=$q?>" size="20" />&nbsp;
发布时间：<?=form::date('inputdate_start', $inputdate_start)?> - <?=form::date('inputdate_end', $inputdate_end)?>&nbsp;
<input type="submit" name="dosubmit" value=" 查询 " /> 
&nbsp;&nbsp;
<?=form::select_type('yp', 'station', 'station', '请选择分类进行管理', $station,'onchange="if(this.value!=\'\'){location=\'?mod=yp&file=job&action=manage&station=\'+this.value;}"',2)?>
</td>
</tr>
</table>
</form>
<form name="myform" method="post" action="">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>管理招聘</caption>
<tr>
<th width="24">选</th>
<th width="40">ID</th>
<th width="150">岗位名称</th>
<th>职位名</th>
<th width="30">点击</th>
<th width="180">公司名称</th>
<th width="105">更新时间</th>
<th width="36">管理</th>
</tr>
<?php
if(is_array($infos)){
	foreach($infos as $info){
		$r = $c->get_count($info['id']);
?>
<tr title="总点击量：<?=$r['hits']?>&#10;今日点击：<?=$r['hits_day']?>&#10;本周点击：<?=$r['hits_week']?>&#10;本月点击：<?=$r['hits_month']?>&#10;排序：<?=$info['listorder']?>">
<td><input type="checkbox" name="id[]" value="<?=$info['id']?>" id="content_<?=$info['id']?>" /></td>
<td><?=$info['id']?></td>
<td class="align_c"><?=$TYPE[$info['station']]['name']?></td>
<td><a href="<?=show_url('job',$info['id'])?>" target="_blank"><?=output::style($info['title'], $info['style'])?></a> <?=$info['thumb'] ? '<font color="red">图</font>' : ''?>&nbsp;<?=$info['elite']?'<font color="green">荐</font>': ''?></td>
<td class="align_c" ><?=$r['hits']?></td>
<td class="align_c"><a href="<?=company_url($info['userid'],$info['sitedomain'])?>"><?=$info['companyname']?></td>
<td class="align_c"><?=date('Y-m-d H:i', $info['updatetime'])?></td>
<td class="align_c">
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&id=<?=$info['id']?>">修改</a>
</td>
</tr>
<?php 
	}
}
?>
</table>
<div class="button_box">
<span style="width:60px"><a href="###" onclick="javascript:$('input[type=checkbox]').attr('checked', true)">全选</a>/<a href="###" onclick="javascript:$('input[type=checkbox]').attr('checked', false)">取消</a></span>
		<?php if($job=='check'){?><input type="button" name="status" value=" 通过审核 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=status&status=99&forward=<?=urlencode(URL)?>';myform.submit();"><?php }?> 
		<input type="button" name="listorder" value=" 排序 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=listorder&catid=<?=$catid?>&forward=<?=urlencode(URL)?>';myform.submit();"> 
		<input type="button" name="delete" value=" 删除 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete&catid=<?=$catid?>&forward=<?=urlencode(URL)?>';myform.submit();"> 
		<input type="button" name="move" value=" 推荐 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=elite&status=1&forward=<?=urlencode(URL)?>';myform.submit();">
		<input type="button" name="move" value=" 取消推荐 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=elite&status=0&forward=<?=urlencode(URL)?>';myform.submit();">
</div>
<div id="pages"><?=$c->pages?></div>
</form>
</body>
</html>