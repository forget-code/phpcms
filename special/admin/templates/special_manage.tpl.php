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
  <caption>专题查询</caption>
<tr>
<td class="align_c">
<?=form::select_type('special', 'typeid', 'typeid', '类别', $typeid);?>

<select name='field'>
<option value='title' <?=$field == 'title' ? 'selected' : ''?>>专题名称</option>
<option value='description' <?=$field == 'description' ? 'selected' : ''?>>专题介绍</option>
<option value='username' <?=$field == 'username' ? 'selected' : ''?>>用户名</option>
<option value='userid' <?=$field == 'userid' ? 'selected' : ''?>>用户ID</option>
<option value='specialid' <?=$field == 'specialid' ? 'selected' : ''?>>专题ID</option>
</select>

<input type="text" name="q" value="<?=$q?>" size="20" />

发布时间：<?=form::date('createdate_start', $createdate_start)?> - <?=form::date('createdate_end', $createdate_end)?>
<input type="submit" name="dosubmit" value=" 查询 " /></td>
</tr>
</table>
</form>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption><?=$typeid ? $types[$typeid]['name'] : ''?> 专题列表</caption>
<tr>
<th width="30">ID</th>
<th>排序</th>
<th>专题信息</th>
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
<a href="<?=$r['url']?>" target="_blank"><img src="<?=$r['thumb']?>" width="146" height="112" style="border:1px solid #000000" align="left"></a>
<span style="height:92px"><a href="<?=$r['url']?>" target="_blank"><?=str_cut(strip_tags($r['description']), 300)?></a></span>
<div style="height:20px;color:gray;">创建人：<a href="<?=member_view_url($r['userid'])?>"><?=$r['username']?></a>， 创建时间：<?=date('Y-m-d H:i', $r['createtime'])?></div>
</div>
</td>
<td class="align_c">
<span style="height:22"><a href='?mod=<?=$mod?>&file=special&action=select_content&specialid=<?=$r['specialid']?>&forward=<?=urlencode(URL)?>'>添加信息</a></span><br />
<span style="height:22"><a href='?mod=<?=$mod?>&file=special&action=manage_content&specialid=<?=$r['specialid']?>'>管理信息</a></span><br />
<span style="height:22"><a href='?mod=<?=$mod?>&file=<?=$file?>&action=block&specialid=<?=$r['specialid']?>' style="color:red">维护碎片</a></span><br/>
<span style="height:22">
<?php if($r['elite']){ ?>
<a href='?mod=<?=$mod?>&file=<?=$file?>&action=elite&value=0&specialid=<?=$r['specialid']?>'><font color="red">取消推荐</font></a>
<?php }else{ ?>
<a href='?mod=<?=$mod?>&file=<?=$file?>&action=elite&value=1&specialid=<?=$r['specialid']?>'>推荐专题</a>
<?php } ?>
</span><br/>
<?php if(isset($MODULE['comment'])){ ?><span style="height:22"><a href="?mod=comment&file=comment&keyid=special-special-title-<?=$r['specialid']?>">专题评论</a></span><br/><?php } ?>
<span style="height:22"><a href='?mod=<?=$mod?>&file=special&action=edit&specialid=<?=$r['specialid']?>'>修改专题</a></span><br/>
<span style="height:22"><a href="javascript:confirmurl('?mod=<?=$mod?>&file=special&action=delete&specialid=<?=$r['specialid']?>','确认删除‘<?=$r['title']?>’专题吗？')">删除专题</a></span>
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