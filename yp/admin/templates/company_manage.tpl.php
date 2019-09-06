<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>管理公司</caption>
<tr>
<td class="align_c">
<form name="search" method="get" action="" style="float:left">
<select name='field'>
<option value='companyname' <?=$field == 'companyname' ? 'selected' : ''?> >公司名</option>
<option value='username' <?=$field == 'username' ? 'selected' : ''?> >用户名</option>
<option value='userid' <?=$field == 'userid' ? 'selected' : ''?> >用户ID</option>
</select>
<input type="text" name="q" value="<?=$q?>" size="20" />&nbsp;
加入时间：<?=form::date('inputdate_start', $inputdate_start)?> - <?=form::date('inputdate_end', $inputdate_end)?>&nbsp;
<input type="hidden" name="mod" value="<?=$mod?>"> 
<input type="hidden" name="file" value="<?=$file?>"> 
<input type="hidden" name="action" value="<?=$action?>"> 
<input type="submit" name="dosubmit" value=" 查询 " />
</form>
</td>

</tr>
</table>

<form name="myform" method="post" action="">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>管理公司</caption>
<tr>
<th width="30">选中</th>
<th width="40">ID</th>
<th width="105">会员名</th>
<th>公司名称</th>
<th width="105">会员组</th>
<th width="50">状态</th>
<th width="50">点击量</th>
<th width="100">服务期截至</th>
<th width="85">管理操作</th>
</tr>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
		$r = $company->get_count($info['userid']);
?>
<tr title="总点击量：<?=$r['hits']?>&#10;今日点击：<?=$r['hits_day']?>&#10;本周点击：<?=$r['hits_week']?>&#10;本月点击：<?=$r['hits_month']?>">
<td><input type="checkbox" name="id[]" value="<?=$info['userid']?>" id="content_<?=$info['contentid']?>" /></td>
<td class="align_c"><?=$info['userid']?></td>
<td class="align_c"><a href="?mod=member&file=member&action=view&userid=<?=$info['userid']?>"><?=$info['username']?></a></td>
<td class="align_l"><?php if($info['companyname']){ ?><a href="<?=company_url($info['userid'],$info['sitedomain'])?>"><?=$info['companyname']?> <?php if($info['elite']) echo "<font color='red'>荐</font>"; } else { echo "未填写";}?></td>
<td class="align_c"><?=$GROUP[$info['groupid']]?></a></td>
<td class="align_c"><?php if($info['status'] == 1) echo '<font color=green>通过</font>';else echo '<font color=red>待审核</font>';?></a></td>
<td class="align_c"><?=$r['hits']?></td>
<td class="align_c"><?php if($info['endtime']) echo date('Y-m-d', $info['endtime']);else echo "永久";?></td>
<td class="align_c">
<a href="?mod=member&file=member&action=edit&userid=<?=$info['userid']?>">修改</a>
</td>
</tr>
<?php 
	}
}
?>
</table>
<div class="button_box">
<span style="width:60px"><a href="###" onclick="javascript:$('input[type=checkbox]').attr('checked', true)">全选</a>/<a href="###" onclick="javascript:$('input[type=checkbox]').attr('checked', false)">取消</a></span>
		<input type="button" name="delete" value=" 删除 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete&forward=<?=urlencode(URL)?>';myform.submit();"> 
		<input type="button" name="move" value=" 推荐 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=elite&status=1&forward=<?=urlencode(URL)?>';myform.submit();"> 
		<input type="button" name="move" value=" 取消推荐 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=elite&status=0&forward=<?=urlencode(URL)?>';myform.submit();"> 
		<input type="button" name="move" value=" 通过审核 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=status&status=1&forward=<?=urlencode(URL)?>';myform.submit();"> 
		<input type="button" name="move" value=" 设为待审 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=status&status=0&forward=<?=urlencode(URL)?>';myform.submit();"> 
</div>
<div id="pages"><?=$company->pages?></div>
</form>
</body>
</html>