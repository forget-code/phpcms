<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="post" name="myform" action="?mod=<?=$mod?>&file=<?=$file?>&action=add">
<table cellpadding="0" cellspacing="1" class="table_form">
 	<caption>添加会员组</caption>
  	<tr>
		<th width="20%"><strong>名称：</strong></th>
		<td>
        	<?=form::text('groupinfo[name]', 'groupname', '', 'text', 30, '', 'maxlength="20" require="true" datatype="limit|ajax" url="?mod=member&file=group&action=checkname" min="3" max="20" msg="用户组名不得少于3个字符超过20个字符|"')?>
        </td>
	</tr>
	<tr>
		<th><strong>服务介绍：</strong></th>
		<td>
			<?=form::textarea('groupinfo[description]', 'description', '', 10, 50, '', '')?>
			<?=form::editor('description')?>
        </td>
	</tr>
    <tr>
    	<th><strong>允许访问：</strong></th>
        <td>
            <?=form::radio($choices, 'groupinfo[allowvisit]', 'allowvisit', 1)?>
       </td>
    </tr>
	<tr>
		<th><strong>允许搜索：</strong></th>
		<td>
			<?=form::radio($choices, 'groupinfo[allowsearch]', 'allowsearch', 1)?>
		</td>
	</tr>
	<tr>
		<th><strong>允许发布：</strong></th>
		<td>
            <?=form::radio($allowposts, 'groupinfo[allowpost]', 'allowpost', 1)?>
		</td>
	</tr>
	<tr>
		<th><strong>是否禁用：</strong></th>
		<td><?=form::radio($disableds, 'groupinfo[disabled]', 'disabled', 0)?></td>
	</tr>
	<tr>
    	<th><strong>最大短消息数：</strong></th>
        <td>
        	<?=form::text('groupinfo[allowmessage]', 'allowmessage', $value = '1000', $type = 'text', $size = 6, $class = '', $ext = 'manxlength="50"')?>
        条</td>
    </tr>
	<tr>
		<th><strong>包年价格：</strong></th>
		<td>
        	<?=form::text('groupinfo[price_y]', 'price_y', '0.00', 'text', 8, '', 'manxlength="50"')?>
        </td>
	</tr>
	<tr>
		<th><strong>包月价格：</strong></th>
		<td>
        	<?=form::text('groupinfo[price_m]', 'price_m', '0.00', 'text', 8, '', 'manxlength="50"')?>
        </td>
	</tr>
	<tr>
		<th><strong>包日价格：</strong></th>
		<td>
        	<?=form::text('groupinfo[price_d]', 'price_d', '0.00', 'text', 8, '', 'manxlength="50"')?>
        </td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 清除 "></td>
	</tr>
	</form>
</table>
</body>
</html>
<script LANGUAGE="javascript">
<!--
$().ready(function() {
	  $('form').checkForm(1);
	});
//-->
</script>