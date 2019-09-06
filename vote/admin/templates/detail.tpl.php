<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<style type="text/css">
.vote_bar{
background-image:url(admin/skin/images/bg_table.jpg);
height:24px;
}
</style>
<body>

<table cellpadding="0" cellspacing="1" class="table_list">
	<caption>统计<a href="?mod=vote&file=vote&action=edit_subject&subjectid=<?=$subjectid?>" title="返回主题编辑页面">[<?=$title?>]</a></caption>
	<tr>
		<td>
	<?=$subs[$subjectid]['title']?>
       ( 投票总数：<?=$vote_data[$subjectid]['votes']?>   )
       | <a href="?mod=vote&file=vote&action=user_list&subjectid=<?=$subjectid?>">投票用户列表</a>
        </td>
	</tr>
</table>
<?php
unset($vote_data[0]);
$si=1;
$subcount = count($subs);
foreach($subs as $sid=>$data)
{
?>
<table cellpadding="0" cellspacing="1" class="table_list">
     <caption style="text-align:left;padding-left:10px"><?=($subcount>1)?$si++:''?>、<?=$data['subject']?> &nbsp;总票数 <?=intval($vote_data[$sid]['total'])?></caption>
        <?php
		$i=0;
		foreach($data['options'] as $optionid=>$option)
		{
			$votes=intval($vote_data[$sid][$optionid]);
			$per=intval($votes/$vote_data[$sid]['total']*100);
		?>
        <tr height="10">
        <td width="34%">
		<?=++$i?>.<a href="?mod=vote&file=vote&action=useroption&optionid=<?=$optionid?>&option=<?=urlencode($option['option'])?>" title="点击查看参与此项投票的用户"><?=$option['option']?></a>        </td>
        <td style="text-align:left" width="12%"><?=$votes?></td>
        <td style="text-align:left" width="11%" align="center"><?=$per?> %</td>
        <td valign="middle" width="43%" style="text-align:left">
        <div class="vote_bar" style="width:<?=$per?>%"></div>
        </td>
        </tr>
        <?php
		}?>
</table>
<?php
}
?>

<?=$pages?>
<script>
$('tr[sn] td').css({'border':'#eee qpx solid'});
</script>
</body>
<!--13126633816  -->
</html>