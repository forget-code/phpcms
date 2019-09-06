<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form name="myform" method="post" action="">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>
<?php
if($status==1000){
echo '审核信息管理';
}elseif($status==0) {
echo '回收站';
}else{
echo '信息管理';
}
?></caption>
<tr>
<th width="30">选中</th>
<th width="40">排序</th>
<th width="40">ID</th>
<th>标题</th>
<th width="80">状态</th>
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
<td><input type="text" name="listorders[<?=$info['contentid']?>]" value="<?=$info['listorder']?>" size="3" /></td>
<td><?=$info['contentid']?></td>
<td><a href="<?=$info['url']?>" target="_blank"><?=output::style($info['title'], $info['style'])?></a> <?=$info['thumb'] ? '<font color="red">图</font>' : ''?>&nbsp;<?=$info['posids']?'<font color="green">荐</font>': ''?>&nbsp;<?=$info['typeid']?'<font color="blue">类</font>': ''?></td>
<td class="align_c"><?=$STATUS[$info['status']]?></td>
<td class="align_c"><a href="<?=$CATEGORY[$info['catid']]['url']?>" target="_blank"><?=$CATEGORY[$info['catid']]['catname']?></a></td>
<td class="align_c"><a href="?mod=member&file=member&action=view&userid=<?=$info['userid']?>"><?=$info['username']?></td>
<td class="align_c"><?=date('Y-m-d H:i', $info['updatetime'])?></td>
<td class="align_c">
<a href="?mod=<?=$mod?>&file=content&action=view&catid=<?=$info['catid']?>&contentid=<?=$info['contentid']?>">查看</a> | 
<a href="?mod=<?=$mod?>&file=content&action=edit&catid=<?=$info['catid']?>&contentid=<?=$info['contentid']?>">修改</a> 
</td>
</tr>
<?php 
	}
}
?>
</table>
<div class="button_box">
<span style="width:60px"><a href="###" onclick="javascript:$('input[type=checkbox]').attr('checked', true)">全选</a>/<a href="###" onclick="javascript:$('input[type=checkbox]').attr('checked', false)">取消</a></span>
		<input type="button" name="delete" value=" 退稿 " onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=inspect&dosubmit=1&pass=0';myform.submit();"> 
		<input type="button" name="pass" value="通过"  onclick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=inspect&dosubmit=1&pass=1';myform.submit();"> 
</div>
<div id="pages"><?=$c->pages?></div>
</form>
</body>
</html>