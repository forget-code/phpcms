<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<style type="text/css">
.voteed{
background-image:url(admin/skin/images/righton.gif);
background-position:center;
background-repeat:no-repeat;
}
</style>

<body>
<div align="center" class="tableborder" style="padding:4px;">
<?=$votedata['username']?$votedata['username']:'游客'?>的投票记录
</div>
<?php
unset($vote_data[0]);
$si=1;
foreach($subs as $sid=>$data)
{
?>
<table width="100%" cellpadding="0" cellspacing="1" class="table_form">
   <caption><?=$si++?> .<?=$data['subject']?></caption>
        <?php
		$i=1;
		foreach($data['options'] as $optionid=>$option)
		{
			$votes=intval($vote_data[$sid][$optionid]);
			$per=intval($votes/$vote_data[$sid]['total']*100);
			$voteed=$votedata['data'][$sid][$optionid];
		?>
        <tr height="24">
        <td width="43%">&nbsp;
		<?=$i++?> .<?=$option['option']?>
        </td>
        <td <?=$voteed?'class="voteed"':''?>>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <?php
		}
		?>
</table>
<?php
}
?>
<script>
$('td.voteed').addClass('td.voteed');
</script>
</body>
</html>