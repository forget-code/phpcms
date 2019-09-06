<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myform" method="post" action="">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>收藏统计</caption>
<tr>
<th width="50">用户ID</th>
<th>公司名称</th>
<th width="100">被收藏次数</th>
</tr>
<?php
if(is_array($infos)){
	foreach($infos as $info){
	$r = $c->get_companyinfo('companyname,sitedomain',$info['userid']);
?>
<tr>
<td><?=$info['userid']?></td>
<td class="align_l"><a href="<?=company_url($info['userid'],$r['sitedomain'])?>" target="_blank"><?=$r['companyname']?></a></td>
<td class="align_c"><?=$info['number']?></td>
</tr>
<?php 
	}
}
?>
</table>
<div id="pages"><?=$c->pages?></div>
</form>
</body>
</html>