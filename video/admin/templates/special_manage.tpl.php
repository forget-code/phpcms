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
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>专辑查询</caption>
<tr>
<td class="align_c">
<select name='field'>
<option value='title' <?=$field == 'title' ? 'selected' : ''?>>专辑名称</option>
<option value='description' <?=$field == 'description' ? 'selected' : ''?>>专辑介绍</option>
<option value='username' <?=$field == 'username' ? 'selected' : ''?>>用户名</option>
<option value='userid' <?=$field == 'userid' ? 'selected' : ''?>>用户ID</option>
<option value='specialid' <?=$field == 'specialid' ? 'selected' : ''?>>专辑ID</option>
</select>

<input type="text" name="q" value="<?=$q?>" size="20" />

发布时间：<?=form::date('createdate_start', $createdate_start)?> - <?=form::date('createdate_end', $createdate_end)?>
<input type="submit" name="dosubmit" value=" 查询 " /></td>
</tr>
</table>
</form>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption><?=$typeid ? $types[$typeid]['name'] : ''?> 专辑列表</caption>
<tr>
<th width="30">ID</th>
<th>排序</th>
<th>专辑信息</th>
<th width="60">操作</th>
</tr>
<?php
if(is_array($data)){
	foreach($data as $r){
		if(!$r['thumb']) $r['thumb'] = 'images/nopic.gif';
?>
<tr>
<td><?=$r['specialid']?></td>
<td><input type='text' name='listorder[<?=$r['specialid']?>]' value="<?=$r['listorder']?>" size="4"></td>
<td>
<div style="margin-bottom:5px;height:20px;font-size:16px;font-weight:bold;border-bottom:1px dotted #ccc"><a href="<?=$r['url']?>" target="_blank"><?=output::style($r['title'], $r['style'])?></a></div>
<div>
<a href="<?=video_special_url($r['specialid'])?>" target="_blank"><img src="<?=$r['thumb']?>" width="146" height="112" style="border:1px solid #000000" align="left"></a>
<span style="height:92px;margin:10px;"><a href="<?=video_special_url($r['specialid'])?>" target="_blank"><?=str_cut(strip_tags($r['description']), 300)?></a></span>
<div style="height:20px;color:gray;">&nbsp;创建人：<a href="<?=member_view_url($r['userid'])?>"><?=$r['username']?></a>， 创建时间：<?=date('Y-m-d H:i', $r['addtime'])?></div>
</div>
</td>
<td class="align_c">
<span style="height:25"><a href='?mod=<?=$mod?>&file=video&action=manage&specialid=<?=$r['specialid']?>'>添加视频</a></span><br />
<span style="height:25"><a href='?mod=<?=$mod?>&file=special&action=manage_content&specialid=<?=$r['specialid']?>'>管理视频</a></span><br />
<span style="height:25"><a href='?mod=<?=$mod?>&file=special&action=edit&specialid=<?=$r['specialid']?>'>修改专辑</a></span><br/>
<span style="height:25"><a href="javascript:confirmurl('?mod=<?=$mod?>&file=special&action=delete&specialid=<?=$r['specialid']?>','确认删除‘<?=$r['title']?>’专辑吗？')">删除专辑</a></span><br/>
<?php if(isset($MODULE['comment'])){ ?><span style="height:25"><a href="?mod=comment&file=comment&keyid=<?php echo $mod;?>-special-title-<?=$r['specialid']?>">专辑评论</a></span><br/><?php } ?>
</td>
</tr>
<?php
	}
}
?>
</table>
<div class="button_box"><input type="submit" name="dosubmit" value=" 排序 "></div>
</form>
<div id="pages"><?=$special->pages?></div>
</body>
</html>