<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>稿件统计</caption>
  <tr>
    <td><a href='?mod=phpcms&file=statistics&action=show_users&userid=<?=$userid?>' >按栏目查看</a> | <a href='?mod=phpcms&file=admin&action=view&userid=<?=$userid?>'><font color="#ff0000">按月份查看</font></a></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="table_form">
    <caption><?=$username?> 详细信息</caption>
    <tr> 
      <th width="12%"><strong>用户名</strong></th>
      <td><?=$username?></td>
    </tr>
	<tr> 
      <th><strong>角色</strong></th>
      <td><?=$roles?></td>
    </tr>
</table>

<table cellpadding="3" cellspacing="1" class="table_form">
    <caption>
	工作统计 年份 
	<?php for($i=(date("Y", TIME)-5);($i<=date("Y", TIME));$i++) { ?>
<a href="admin.php?mod=phpcms&file=admin&action=view&userid=<?=$userid?>&month=<?=$month?>&year=<?=$i?>">
	<?php
		echo ($year == $i) ? "<font color=red>$i</font> " : $i.' ';?></a>
	<?php }?>
	月份 
	<?php for($i=1;$i<13;$i++) { ?>
	<a href="admin.php?mod=phpcms&file=admin&action=view&userid=<?=$userid?>&month=<?=$i?>&year=<?=$year?>"><?php echo ($month == $i) ? "<font color=red>$i</font>" : $i;?></a>
	<?php }?>
	</caption>
	<tr> 
      <th width="25%"><strong>日期（总计）</strong></th>
      <th width="25%"><strong>文章数（本周：<?=$weeknum?>，本月:<?=$monthnum?>）</strong></th>
	  <th width="25%"><strong>点击数（本周：<?=$weekhits?>，本月:<?=$monthhits?>）</strong></th>
	  <th width="25%"><strong>评论数（本周：<?=$weekcomments?>，本月:<?=$monthcomments?>）</strong></th>
    </tr>
	<?php
		for($i=1;$i<=$daynums;$i++) {
	?>
    <tr <?php if(date("Y-m", TIME).'-'.$i==date("Y-m-j", TIME)){echo "style='background:'";}?>> 
      <th><?php echo date("Y-m", TIME).'-'.$i.' ('.date("l", mktime(0, 0, 0, $month, $i, $year)).')'?></th>
      <th><?php echo isset($numarr[$i]) ? $numarr[$i] : 0?></th>
	  <th><?php echo isset($contenthit[$i]) ? $contenthit[$i] : 0?></th>
	  <th><?php echo isset($contentcomment[$i]) ? $contentcomment[$i] : 0?></th>
    </tr>
	<?php }?>
</table>
</body>
</html>