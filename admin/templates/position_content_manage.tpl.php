<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script type="text/javascript" language="JavaScript">
function checkform()
{
	var myid = document.getElementsByName("contentid[]");
	var flag = false;
	for(var i = 0; i< myid.length ;i++)
    {
		if(myid[i].checked)
        {
			flag = true;
			break;
		}
	}
	if(!flag)
    {
		alert("请选择要删除的文章");
		return false;
	}
	return window.confirm("你确定要把这些信息移出推荐位吗？");
}
</script>
<body>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=content_manage&posid=<?=$posid?>" onsubmit="return checkform();">
<input type="hidden" name="posid" value="<?=$posid?>">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption><?=$name?> 推荐位信息管理</caption>
<tr>
<th width="30">选中</th>
<th width="40">ID</th>
<th>标题</th>
<th width="100">栏目</th>
<th width="70">录入者</th>
<th width="100">更新时间</th>
<th width="170">管理操作</th>
</tr>
<?php
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr>
<td><input type="checkbox" name="contentid[]" value="<?=$info['contentid']?>" id="content_<?=$info['contentid']?>" /></td>
<td><?=$info['contentid']?></td>
<td><a href="<?=$info['url']?>" target="_blank"><?=output::style($info['title'], $info['style'])?></a> <?=$info['thumb'] ? '<font color="red">图</font>' : ''?>&nbsp;<?=$info['posids']?'<font color="green">荐</font>': ''?></td>
<td class="align_c"><a href="<?=$CATEGORY[$info['catid']]['url']?>" target="_blank"><?=$CATEGORY[$info['catid']]['catname']?></a></td>
<td class="align_c"><a href="?mod=member&file=member&action=view&userid=<?=$info['userid']?>"><?=$info['username']?></td>
<td class="align_c"><?=date('Y-m-d H:i', $info['updatetime'])?></td>
<td class="align_c">
<a href="?mod=phpcms&file=content&action=view&catid=<?=$catid?>&contentid=<?=$info['contentid']?>">查看</a> |
<a href="?mod=phpcms&file=content&action=edit&catid=<?=$catid?>&contentid=<?=$info['contentid']?>">修改</a> |
<a href="?mod=phpcms&file=content&action=log_list&catid=<?=$catid?>&contentid=<?=$info['contentid']?>">日志</a>
<?php if(isset($MODULE['comment'])){ ?> | <a href="?mod=comment&file=comment&keyid=phpcms-content-title-<?=$info['contentid']?>">评论</a> <?php } ?>
</td>
</tr>
<?php
	}
}
?>
</table>
<div class="button_box">
<span style="width:60px"><a href="###" onclick="javascript:$('input[type=checkbox]').attr('checked', true)">全选</a>/<a href="###" onclick="javascript:$('input[type=checkbox]').attr('checked', false)">取消</a></span>
		<input type="submit" name="dosubmit" value="移出推荐位"  />
</div>
<div id="pages"><?=$pos->pages?></div>
</form>
</body>
</html>