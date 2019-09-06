<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>信息列表</caption>
  <tr>
	<th width="40">ID</th>
	<th>标题</th>
	<th width="80">状态</th>
	<th width="70">录入者</th>
	<th width="120">更新时间</th>
	<th width="100">查看</th>
  </tr>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr>
<td><?=$info['contentid']?></td>
<td><a href="<?=$info['url']?>" target="_blank"><?=output::style($info['title'], $info['style'])?></a> <?=$info['thumb'] ? '<font color="red">图</font>' : ''?>&nbsp;<?=$info['posids']?'<font color="green">荐</font>': ''?></td>
<td class="align_c"><?=$STATUS[$info['status']]?></td>
<td class="align_c"><a href="<?=member_view_url($info['userid'])?>"><?=$info['username']?></a></td>
<td class="align_c"><?=date('Y-m-d H:i', $info['updatetime'])?></td>
<td class="align_c">
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=view&contentid=<?=$info['contentid']?>">查看</a>
</tr>
<?php 
	}
}
?>
</table>
<div id="pages"><?=$c->pages?></div>
</body>
</html>