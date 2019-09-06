<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>推荐位管理</caption>
    <tr>
        <th>推荐位</th>
        <th>数据量</th>
        <th width="25%">管理操作</th>
    </tr>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
    <tr>
        <td class="align_l"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=content_manage&posid=<?=$info['posid']?>"><?=$info['name']?></a></td>
        <td class="align_c"><?=$pos->count($info['posid'])?></td>
        <td class="align_c"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=content_add&posid=<?=$info['posid']?>">信息推荐</a>  | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=content_manage&posid=<?=$info['posid']?>">信息管理</a>  | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&posid=<?=$info['posid']?>">修改</a>  | <a href="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&posid=<?=$info['posid']?>', '确认删除此推荐位吗？')">删除</a> </td>
    </tr>
<?php 
	}
}
?>
</table>
<div id="pages"><?=$pos->pages?></div>
<?php if(in_array(1, $_roleid) || in_array(2, $_roleid)){ ?>
<div class="button_box">
<span class="button_style" style="width:100px;margin-left:10px;"><a href='?mod=<?=$mod?>&file=<?=$file?>&action=add&forward=<?=urlencode(URL)?>'>添加推荐位</a></span>
<span class="button_style" style="width:100px;margin-left:10px;"><a href='?mod=<?=$mod?>&file=<?=$file?>&action=manage&forward=<?=urlencode(URL)?>'>管理推荐位</a></span>
</div>
<?php } ?>
<table cellpadding="0" cellspacing="1" class="table_info">
  <caption>提示信息</caption>
  <tr>
    <td>推荐位是指管理员可以把信息推送至网页上指定的位置，也可以随时把信息从指定的位置撤下来，从而达到信息精准投放的目的：<br />
	1、进入“<font color="red">信息推荐</font>”，您可以把需要推荐的信息推送到指定的推荐位；<br />
	2、进入“<font color="red">信息管理</font>”，您可以了解推荐位当前的信息列表，可以把指定的信息从该推荐位撤下来。
	</td>
  </tr>
</table>
</form>
</body>
</html>