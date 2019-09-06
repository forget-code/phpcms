<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<?=$menu?>
<table width="100%" cellpadding="0" cellspacing="1"  class="table_list">
<caption>积分排行</caption>
<tr>
<th>排名</th>
<th>用户名</th>
<th>总积分</th>
<th>上月积分</th>
<th>上周积分</th>
<th>等级</th>
<th>最后登录</th>
<th>登录次数</th>
<th>回答数</th>
<th>被采纳数</th>
</tr>
<?php
	foreach ($infos as $info) {
?>
<tr>
<td class="align_c"><?php echo $info['orderid'];?></td>
<td class="align_c"><a href="?mod=member&file=member&action=view&userid=<?=$info['userid']?>"><?php echo $info['username'];?></a></td>
<td class="align_c"><?php echo $info['point'];?></td>
<td class="align_c"><?php echo $info['premonth'];?></td>
<td class="align_c"><?php echo $info['preweek'];?></td>
<td class="align_c"><?php echo $info['grade'];?></td>
<td class="align_c"><?php echo $info['lastlogintime'];?></td>
<td class="align_c"><?php echo $info['logintimes'];?></td>
<td class="align_c"><?php echo $info['answercount'];?></td>
<td class="align_c"><?php echo $info['acceptcount'];?></td>
</tr>
<?php
}
?>		
</table>
<br />
<div id="pages"><?=$credit->pages?></div>

</body>
</html>