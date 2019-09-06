<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script type="text/javascript" language="JavaScript">
function checkform()
{
	var myid = document.getElementsByName("vid[]");
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
	return window.confirm("你确定要把这些信息移出专题吗？");
}
</script>
<script type="text/javascript" src="images/js/thickbox.js"></script>
<link type="text/css" rel="stylesheet" href="<?=$mod;?>/images/ThickBox.css" media="screen"/>
<body>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=manage_content&specialid=<?=$specialid?>" onsubmit="return checkform();">
<input type="hidden" name="specialid" value="<?=$specialid?>">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption><?=$title?> 专题信息管理</caption>
<tr>
<th width="30">选中</th>
<th width="40">ID</th>
<th width="50">排序</th>
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
<td><input type="checkbox" name="vid[]" value="<?=$info['vid']?>" id="check_vid" boxid="check_vid"/></td>
<td><?=$info['vid']?></td>
<td class="align_c"><input type="text" name="listorders[<?=$info['vid']?>]" value="<?=$info['listorder']?>" size="4" /></td>
<td><a href="<?=video_show_url($info['vid'],$info['url'])?>" target="_blank"><?=output::style($info['title'], $info['style'])?></a> <?=$info['thumb'] ? '<font color="red">图</font>' : ''?>&nbsp;<?=$info['posids']?'<font color="green">荐</font>': ''?></td>
<td class="align_c"><a href="<?=$CATEGORY[$info['catid']]['url']?>" target="_blank"><?=$CATEGORY[$info['catid']]['catname']?></a></td>
<td class="align_c"><a href="?mod=member&file=member&action=view&userid=<?=$info['userid']?>"><?=$info['username']?></td>
<td class="align_c"><?=date('Y-m-d H:i', $info['updatetime'])?></td>
<td class="align_c">
<a href="?mod=<?=$mod?>&file=video&action=priview&vid=<?=$info['vid']?>&keepThis=true&TB_iframe=true&height=293&width=385" class="thickbox">预览</a> |
<a href="?mod=<?=$mod?>&file=video&action=edit&vid=<?=$info['vid']?>">修改</a>
<?php if(isset($MODULE['comment'])){ ?> | <a href="?mod=comment&file=comment&keyid=<?=$mod?>-v-<?=$info['vid']?>">评论</a> <?php } ?>
</td>
</tr>
<?php
	}
}
?>
</table>
<div class="button_box">
<span style="width:60px">全选<input boxid='check_vid' type='checkbox' onclick="checkall('check_vid')" ></span>
<input type="submit" name="dosubmit" value="移出专题"  />
<input type="button" name="listorder" value=" 排&nbsp;序 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=content_listorder&forward=<?=urlencode(URL)?>';myform.submit();"> 

</div>
<div id="pages"><?=$special->contentpages?></div>
</form>
</body>
</html>