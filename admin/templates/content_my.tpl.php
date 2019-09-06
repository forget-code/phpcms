<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="0" cellspacing="1" class="table_list">
<caption>信息状态</caption>
<tr>
<td>
<strong>状态：</strong>
<input type="radio" name="status" value="-1" <?=$status==-1 ? 'checked' : ''?> onclick="window.location='?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&catid=<?=$catid?>&status=-1'">全部  
<?php 
foreach($STATUS as $k=>$v) {
?>
<input type="radio" name="status" value="<?=$k?>" <?=$status==$k ? 'checked' : ''?> onclick="window.location='?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&catid=<?=$catid?>&status=<?=$k?>'"><?=$v?> 
<?php } ?>
</td>
</tr>
</table>

<form name="myform" method="post" action="">
 <table cellpadding="0" cellspacing="1" class="table_list">
  <caption>我发布的信息管理</caption>
<tr align="center">
<th width="30">选中</th>
<th width="40">ID</th>
<th>标题</th>
<th width="80">状态</th>
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
<td class="align_c"><?=date('Y-m-d H:i', $info['updatetime'])?></td>
<td class="align_c">
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=my_view&contentid=<?=$info['contentid']?>">查看</a> | 
<?php if($info['status'] > -1 && $info['status'] < 4){ ?>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=my_edit&contentid=<?=$info['contentid']?>">修改</a>
<?php }else{ ?>
<font color="#cccccc">修改</font>
<?php } ?>
</tr>
<?php 
	}
}
?>
</table>
<div class="button_box">
<span style="width:60px"><a href="###" onclick="javascript:$('input[type=checkbox]').attr('checked', true)">全选</a>/<a href="###" onclick="javascript:$('input[type=checkbox]').attr('checked', false)">取消</a></span>
<?php if($status == 0){ ?>
		<input type="button" name="contribute" value=" 重新投稿 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=my_contribute&catid=<?=$catid?>&forward=<?=urlencode(URL)?>';myform.submit();"> 
		<input type="button" name="delete" value=" 彻底删除 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=my_delete&catid=<?=$catid?>&forward=<?=urlencode(URL)?>';myform.submit();"> 
<?php }elseif($status == 1){ ?>
		<input type="button" name="contribute" value=" 重新投稿 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=my_contribute&catid=<?=$catid?>&forward=<?=urlencode(URL)?>';myform.submit();"> 
		<input type="button" name="delete" value=" 删除 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=my_delete&catid=<?=$catid?>&forward=<?=urlencode(URL)?>';myform.submit();"> 
<?php }elseif($status == 2){ ?>
		<input type="button" name="contribute" value=" 投稿 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=my_contribute&catid=<?=$catid?>&forward=<?=urlencode(URL)?>';myform.submit();"> 
		<input type="button" name="delete" value=" 删除 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=my_delete&catid=<?=$catid?>&forward=<?=urlencode(URL)?>';myform.submit();"> 
<?php }elseif($status == 3){ ?>
		<input type="button" name="contribute" value=" 取消投稿 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=my_cancelcontribute&catid=<?=$catid?>&forward=<?=urlencode(URL)?>';myform.submit();"> 
		<input type="button" name="delete" value=" 删除 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=my_delete&catid=<?=$catid?>&forward=<?=urlencode(URL)?>';myform.submit();"> 
<?php } ?>
</div>
<div id="pages"><?=$c->pages?></div>
</form>
</body>
</html>