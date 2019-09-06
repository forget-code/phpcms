<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=note&userid=<?=$userid?>">
	<table cellpadding="0" cellspacing="1" class="table_form">
		<caption><?=$username?> 的备注</caption>  
		<tr>
			<td style="text-align:center;"><?=form::textarea('note', 'note', $note, 16, 100)?><br />请在下面记录该会员的备注信息（只有管理员才能看到）</td>
		</tr>
		<tr>
			<td style="text-align:center;"><input type="submit" name="dosubmit" value=" 修改 "></td></td>
		</tr>
	</table>
	<input type="hidden" name="forward" value="<?=$forward?>" />
</form>
</body>
</html>