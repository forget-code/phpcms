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
  <caption>人才查询</caption>
<tr>
<td class="align_c">

<select name='field'>
<option value='school' <?=$field == 'school' ? 'selected' : ''?> >毕业院校</option>
<option value='specialty' <?=$field == 'specialty' ? 'selected' : ''?> >专业</option>
<option value='truename' <?=$field == 'truename' ? 'selected' : ''?> >真实姓名</option>
<option value='username' <?=$field == 'username' ? 'selected' : ''?> >用户名</option>
<option value='userid' <?=$field == 'userid' ? 'selected' : ''?> >用户ID</option>
<option value='applyid' <?=$field == 'applyid' ? 'selected' : ''?> >ID</option>
</select>
<input type="text" name="q" value="<?=$q?>" size="20" />&nbsp;
发布时间：<?=form::date('inputdate_start', $inputdate_start)?> - <?=form::date('inputdate_end', $inputdate_end)?>&nbsp;
<input type="submit" name="dosubmit" value=" 查询 " /> 
&nbsp;&nbsp;
<?=form::select_type('yp', 'station', 'station', '按欲从事工作进行管理', $station,'onchange="if(this.value!=\'\'){location=\'?mod=yp&file=talent&action=manage&station=\'+this.value;}"',2)?>
</td>
</tr>
</table>
</form>
<form name="myform" method="post" action="">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>管理人才</caption>
<tr>
<th width="24">选</th>
<th width="40">ID</th>
<th width="80">姓名</th>
<th width="130">欲从事</th>
<th width="40">经验</th>
<th width="180">毕业院校</th>
<th width="150">专业</th>
<th width="40">学历</th>
<th width="70">薪资要求</th>
<th width="30">点击</th>
<th width="105">更新时间</th>
<th width="36">管理</th>
</tr>
<?php
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr>
<td><input type="checkbox" name="id[]" value="<?=$info['applyid']?>" id="content_<?=$info['applyid']?>" /></td>
<td><?=$info['applyid']?></td>
<td class="align_c"><a href="<?=$M['url']?>apply.php?applyid=<?=$info['applyid']?>"><?=$info['truename']?></a><?php if($info['elite']) echo "<font color='red'><sup>荐</sup></font>";?></td>
<td class="align_c"><?=$TYPE[$info['station']]['name']?></td>
<td class="align_c"><?=$info['experience']?>年</td>
<td class="align_l"><?=$info['school']?></td>
<td class="align_l"><?=$info['specialty']?></td>
<td class="align_c"><?=$info['edulevel']?></td>
<td class="align_c"><?php if($info['pay']) echo $info['pay'];else echo '面议';?></td>
<td class="align_c"><?=$info['hits']?></td>
<td class="align_c"><?=date('Y-m-d', $info['edittime'])?></td>
<td class="align_c">
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&applyid=<?=$info['applyid']?>">修改</a>
</td>
</tr>
<?php 
	}
}
?>
</table>
<div class="button_box">
<span style="width:60px"><a href="###" onclick="javascript:$('input[type=checkbox]').attr('checked', true)">全选</a>/<a href="###" onclick="javascript:$('input[type=checkbox]').attr('checked', false)">取消</a></span>
		<input type="button" name="delete" value=" 删除 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete&catid=<?=$catid?>&forward=<?=urlencode(URL)?>';myform.submit();"> 
		<input type="button" name="move" value=" 推荐 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=elite&status=1&forward=<?=urlencode(URL)?>';myform.submit();">
		<input type="button" name="move" value=" 取消推荐 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=elite&status=0&forward=<?=urlencode(URL)?>';myform.submit();">
</div>
<div id="pages"><?=$c->pages?></div>
</form>
</body>
</html>