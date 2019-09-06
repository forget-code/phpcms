<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script type="text/javascript">
function dosubmit(mod, func)
{
	var tagname = document.myform.tagname;
	document.myform.action = '?mod='+mod+'&file=tag&action=add&function='+func+'&job=edittemplate&tagname='+tagname;
	document.myform.submit();
}
</script>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
	<tr>
		<td></td>
	</tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
<?php if($listtags1){ ?>
  <tr>
    <th colspan=3>[<?=$templateinfo?>.html] 未定义的标签列表</th>
  </tr>
<tr align="center">
<td class="tablerowhighlight" width="40%">选择标签</td>
<td class="tablerowhighlight" width="30%">选择标签类型</td>
<td class="tablerowhighlight" width="30%">创建标签</td>
</tr>
<form name="myform" method="post" target="_blank" action="?">
<?php 
foreach($listtags1 AS $n=>$tagname)
{
	$tag = $tags[$tagname];
?>
<tr>
<td class="tablerow">
<input type="radio" name="tagname" value="<?=$tagname?>" <?=($n ? '' : 'checked')?>>
{tag_<?=$tagname?>}
</td>
<?php if($n==0){ ?>
<td rowspan="<?=count($listtags1)?>" class="tablerow" align="center">
<div style="height:30px">
<select name="func" size="2" style="font-family:arial;width:150;height:300">
<option value="" style="background:blue;color:#ffffff;">==栏目/类别/专题==</option>
<option value="phpcms_cat">栏目标签</option>
<option value="phpcms_type">类别标签</option>
<option value="phpcms_special_list">专题列表</option>
<option value="phpcms_special_slide">专题幻灯片</option>
<option value="" style="background:blue;color:#ffffff;">==公告/投票/链接==</option>
<option value="announce_list">公告标签</option>
<option value="vote_list">投票标签</option>
<option value="link_list">链接标签</option>
<?php 
	foreach($MODULE as $m){
	if(!$m['iscopy']) continue;
?>
<option value="" style="background:blue;color:#ffffff;">==<?=$m['name']?>标签==</option>
<option value="<?=$m['module']?>_list"><?=$m['name']?>标题列表</option>
<option value="<?=$m['module']?>_thumb"><?=$m['name']?>图片列表</option>
<option value="<?=$m['module']?>_slide"><?=$m['name']?>幻灯片</option>
<option value="<?=$m['module']?>_related">相关<?=$m['name']?></option>
<?php } ?>
</select>
</div>
</td>
<td rowspan="<?=count($listtags1)?>" class="tablerow">
&nbsp;&nbsp;<input type="button" value="创建标签" style="height:50" onClick="javascript:if(myform.func.value != ''){s = myform.func.value.split('_'); dosubmit(s[0], myform.func.value);}else{alert('请选择标签类型！')}">
</td>
<?php } ?>
</tr>
<?php 
}
?>
</form>
  <tr align="center">
    <td colspan=3 class="tablerow">
	</td>
  </tr>
<?php } ?>
  <tr>
    <th colspan=3>[<?=$templateinfo?>.html] 已定义的标签列表</th>
  </tr>
<tr align="center">
<td class="tablerowhighlight" width="40%">标签</td>
<td class="tablerowhighlight" width="30%">所属模块</td>
<td class="tablerowhighlight" width="30%">管理操作</td>
</tr>
<?php 
foreach($listtags2 AS $tagname)
{
	$tag = $tags[$tagname];
	preg_match("/^(([a-z0-9]+)[_][^(]+)[(]/", $tag, $m);
	$function = $m[1];
	$tagmod = $m[2];
	$jscode = strpos($tag, '$') ? '无' : '&lt;script type=&#34;text/javascript&#34; src=&#34;'.$PHP_SITEURL.'js.php?tag='.urlencode($tagname).'&#34;>&lt;/script&gt;';
?>
<tr align="center" onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td align="center"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=quickoperate&operate=edit&tagname=<?=urlencode($tagname)?>" target="_blank">{tag_<?=$tagname?>}</td>
<td align="center"><?=$MODULE[$tagmod]['name']?></td>
<td>
<a href="?mod=phpcms&file=tag&action=quickoperate&operate=preview&job=edittemplate&tagname=<?=urlencode($tagname)?>" target="_blank">预览</a> | 
<a href="?mod=phpcms&file=tag&action=quickoperate&operate=edit&job=edittemplate&tagname=<?=urlencode($tagname)?>" target="_blank">编辑</a> |
<a href="?mod=phpcms&file=tag&action=quickoperate&operate=copy&job=edittemplate&tagname=<?=urlencode($tagname)?>" target="_blank">复制</a>
</td>
</tr>
<?php 
}
?>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
	<tr>
		<td align="center"><input type="button" value="关闭窗口" onClick="window.close();"></td>
	</tr>
</table>
</body>
</html>