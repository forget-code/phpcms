<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<script type="text/javascript" src="images/js/thickbox.js"></script>
<link type="text/css" rel="stylesheet" href="<?=$mod;?>/images/ThickBox.css" media="screen"/>
<style type="text/css">
.gray1{color:#fff;!important;text-decoration:none; position:absolute;}
</style>
<?=$menu?>
<form name="search" method="get" action="">
<input type="hidden" name="mod" value="<?=$mod?>"> 
<input type="hidden" name="file" value="<?=$file?>"> 
<input type="hidden" name="action" value="<?=$action?>"> 
<input type="hidden" name="catid" value="<?=$catid?>">
<table cellpadding="0" cellspacing="1" class="table_list">
  <tr>
    <th>选择栏目</th>
    <th>搜索</th>
  </tr>
<tr>
<td width="30%" class="align_c"><?=form::select_category($mod, 0, 'category[parentid]', 'parentid', '--请选择栏目进行管理 --', $catid,"onchange=\"if(this.value!=''){location='?mod=$mod&file=$file&action=$action&job=$job&elite=$elite&catid='+this.value;}\"")?></td>
<td class="align_c">
<select name='field'>
<option value='title' <?=$field == 'title' ? 'selected' : ''?> >标题</option>
<option value='username' <?=$field == 'username' ? 'selected' : ''?> >用户名</option>
<option value='userid' <?=$field == 'userid' ? 'selected' : ''?> >用户ID</option>
<option value='vid' <?=$field == 'vid' ? 'selected' : ''?> >ID</option>
</select>
<input type="text" name="q" value="<?=$q?>" size="20" />&nbsp;
发布时间：<?=form::date('inputdate_start')?> - <?=form::date('inputdate_end')?>&nbsp;
<input type="submit" name="dosubmit" value=" 查询 " />
</td>
</tr>
</table>
</form>
<form name="myform" method="post" action="">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>信息管理</caption>
<tr>
<th width="30">选中</th>
<th width="50">排序</th>
<th width="40">ID</th>
<th width="98">图片</th>
<th>标题</th>
<th width="50">点击量</th>
<th width="70">发布人</th>
<th width="105">更新时间</th>
<th width="120">管理操作</th>
</tr>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
		$r = $v->get_count($info['vid']);
?>
<tr>
<td><input type="checkbox" name="vid[]" value="<?=$info['vid']?>" id="check_vid" boxid="check_vid"/></td>
<td class="align_c"><input type="text" name="listorders[<?=$info['vid']?>]" value="<?=$info['listorder']?>" size="4" /></td>
<td><?=$info['vid']?></td>
<td height="72" align="center"> <?php if($info['thumb']) {?><span class="gray1"><?=format_time($info['timelen'])?></span>
<?php if(preg_match('/http:\/\//',$info['thumb'])) {?>
<a href="?mod=<?=$mod?>&file=video&action=selectpic&vid=<?=$info['vid']?>&KeepThis=true&TB_iframe=true&height=300&width=379" target="_blank" title="选择缩略图《3G iPhone》" class="thickbox"><img src="<?=$info['thumb'];?>" width="93" height="70" alt="选择缩略图" id="thumb<?=$info['vid']?>"/></a>
<?php } else {?>
<img src="<?=$info['thumb'];?>" width="93" height="70"/>
<?php }}?></td>

<td><a href="<?=video_show_url($info['vid'],$info['url'])?>" target="_blank"><?=output::style($info['title'], $info['style'])?></a>&nbsp;<?=$info['posids']?'<font color="green">荐</font>': ''?>&nbsp;<?=$info['typeid']?'<font color="blue">类</font>': ''?>
</br></br>所属分类：<?=$CATEGORY[$info['catid']]['catname']?>

</td>
<td class="align_c" title="总点击量：<?=$r['hits']?>&#10;今日点击：<?=$r['hits_day']?>&#10;本周点击：<?=$r['hits_week']?>&#10;本月点击：<?=$r['hits_month']?>"><?=$r['hits']?></td>
<td class="align_c"><a href="?mod=member&file=member&action=view&userid=<?=$info['userid']?>"><?=$info['username']?></td>
<td class="align_c"><?=date('Y-m-d H:i', $info['updatetime'])?></td>
<td class="align_c">
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&catid=<?=$catid?>&vid=<?=$info['vid']?>">编辑视频</a>
<?php if(isset($MODULE['comment'])){ ?></br> <a href="?mod=comment&file=comment&keyid=<?=$mod?>-video-title-<?=$info['vid']?>">查看评论</a> <?php } ?>
</br><a href="?mod=<?=$mod?>&file=<?=$file?>&action=priview&vid=<?=$info['vid']?>&keepThis=true&TB_iframe=true&height=293&width=385" class="thickbox">预览视频</a>
</td>
</tr>
<?php 
	}
}
?>
</table>

<div class="button_box">

<span style="width:60px">全选<input boxid='check_vid' type='checkbox' onclick="checkall('check_vid')" ></span>
<?php
if($status==3) {
?>
		<input type="button" name="listorder" value=" 通过审核 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=check&catid=<?=$catid?>&forward=<?=urlencode(URL)?>';myform.submit();"> 
<?php } ?>
<?php
if($status==90) {
?>
		<input type="button" name="listorder" value=" 发布上线 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=publish&catid=<?=$catid?>&forward=<?=urlencode(URL)?>';myform.submit();"> 
<?php } ?>

		<?php if($specialid) {?><input type="button" name="move" value=" 加入到专辑→<?=$specialname?> " onclick='insert_special()'><?php }?>
		<input type="button" name="listorder" value=" 排序 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=listorder&catid=<?=$catid?>&processid=<?=$processid?>&forward=<?=urlencode(URL)?>';myform.submit();"> 
		<input type="button" name="delete" value=" 删除 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=cancel&catid=<?=$catid?>&processid=<?=$processid?>&forward=<?=urlencode(URL)?>';myform.submit();"> 
		<?php if(array_key_exists('posids', $model_field->fields) && !check_in($_roleid, $model_field->fields['posids']['unsetroleids'])) {?> <?=form::select($POS, 'posid', 'posid', '', '', '', "onchange=\"myform.action='?mod={$mod}&file={$file}&action=posid&catid={$catid}&processid={$processid}';myform.submit();\"")?> <?php } ?>
	
</div>

<div id="pages"><?=$v->pages?></div>
</form>
<br></br>
<SCRIPT LANGUAGE="JavaScript">
<!--
function insert_special()
{
	$("#special_div").hide();
	myform.action='?mod=<?=$mod?>&file=video&action=add_to_special&specialid=<?=$specialid?>';myform.submit();
}
//-->
</SCRIPT>
</body>
</html>