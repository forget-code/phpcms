<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="table_form">
  <caption>批量设置会员组</caption>
<form method="post" name="search" action="?">
<tr>
<th align="center" width="10%">会员名</th>
<td>
    <?=form::checkbox($arr_member, 'userid', 'checkbox', '', 10, '', 'checked');?>
</td>
</tr>
<tr>
<th>会员组</th>
<td><?=form::select($GROUP, $name = 'groupid', $id = 'groupid', $value = '{$groupid}')?></td>
</tr>
<tr>
	<th></th>
	<td>
<input name='mod' type='hidden' value='<?=$mod?>'>
<input name='file' type='hidden' value='<?=$file?>'>
<input name='action' type='hidden' value='<?=$action?>'>
<input name='forward' type='hidden' value='<?=$forward?>'>
<input name='button2' type='button' class="button_style" id='chkall' onclick='checkall()' value='全选'>
<input name='dosubmit' type='submit' value=' 批量移动 '>
	</td>
</tr>
</form>
</table>
</body>
</html>
