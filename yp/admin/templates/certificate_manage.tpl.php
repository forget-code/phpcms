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
  <caption>证书查询</caption>
<tr>
<td class="align_c">

<select name='field'>
<option value='username' <?=$field == 'username' ? 'selected' : ''?> >用户名</option>
<option value='userid' <?=$field == 'userid' ? 'selected' : ''?> >用户ID</option>
<option value='companyname' <?=$field == 'companyname' ? 'selected' : ''?> >公司名称</option>
<option value='id' <?=$field == 'id' ? 'selected' : ''?> >ID</option>
</select>
<input type="hidden" name="job" value="<?=$job?>"/>
<input type="text" name="q" value="<?=$q?>" size="20" />&nbsp;
添加时间：<?=form::date('inputdate_start', $inputdate_start)?> - <?=form::date('inputdate_end', $inputdate_end)?>&nbsp;
<input type="submit" name="dosubmit" value=" 查询 " /> 
</td>
</tr>
</table>
</form>
<form name="myform" method="post" action="">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>管理证书</caption>
<tr>
<th width="36">选择</th>
<th width="40">ID</th>
<th width="130">图片</th>
<th>证书名称</th>
<th>发证机构</th>
<th>公司名称</th>
<th width="120">添加时间</th>
<th width="36">管理<div id='FilePreview' style='Z-INDEX: 1000; LEFT: 0px; WIDTH: 10px; POSITION: absolute; TOP: 0px; HEIGHT: 10px; display: none;'></div></th>
</tr>
<?php
if(is_array($infos)){
	foreach($infos as $info){
	$r = $c->get_companyinfo('companyname',$info['userid']);
?>
<tr>
<td><input type="checkbox" name="id[]" value="<?=$info['id']?>" id="content_<?=$info['id']?>" /></td>
<td><?=$info['id']?></td>
<td class="align_c"><a href="<?=$info['thumb']?>" target="_blank" onMouseOut='javascript:FilePreview("<?=$info['thumb']?>", 0);' onMouseOver='javascript:FilePreview("<?=$info['thumb']?>", 1);'><img src="<?=$info['thumb']?>" width="120"></a></td>
<td class="align_l"><?=$info['name']?></td>
<td class="align_l"><?=$info['organization']?></td>
<td class="align_l"><?=$r['companyname']?></td>
<td class="align_c"><?=date('Y-m-d H:i', $info['addtime'])?></td>
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
<?php if($job=='check') {
?>
		<input type="button" name="status" value=" 通过审核 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=status&status=1&forward=<?=urlencode(URL)?>';myform.submit();"> 
		<input type="button" name="status" value=" 不符合要求 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=status&status=0&forward=<?=urlencode(URL)?>';myform.submit();"> 
<?php } ?>
		<input type="button" name="delete" value=" 删除 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete&forward=<?=urlencode(URL)?>';myform.submit();"> 
</div>
<div id="pages"><?=$c->pages?></div>
</form>
</body>
</html>