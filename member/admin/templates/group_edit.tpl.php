<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="0" cellspacing="1" class="table_form">
<form method="post" name="myform" action="?mod=<?=$mod?>&file=<?=$file?>&action=edit">
 	<caption>修改会员组</caption>
  	<tr>
		<th width="20%"><strong>名称：</strong></th>
		<td>
			<input type="text" name="groupinfo[name]" value="<?=$name?>" size="30" id="groupname" maxlength="20" require="true" datatype="limit|ajax" url="?mod=member&file=group&action=checkname&groupid=<?=$groupid?>" min="3" max="20" msg="用户组名不得少于3个字符超过20个字符|"><font color="red">*</font>
        </td>
	</tr>
	<tr>
		<th><strong>服务介绍：</strong></th>
		<td>
			<?=form::textarea('groupinfo[description]','description', $description, 10, 50, '', '')?>
			<?=form::editor('description')?>
        </td>
	</tr>
    <tr>
    	<th><strong>允许访问：</strong></th>
        <td>
            <?=form::radio($choices, 'groupinfo[allowvisit]', 'allowvisit', $allowvisit)?>
       </td>
    </tr>
	<tr>
		<th><strong>允许搜索：</strong></th>
		<td>
			<?=form::radio($choices, 'groupinfo[allowsearch]', 'allowsearch', $allowsearch)?>
		</td>
	</tr>	
	<tr>
		<th><strong>允许发布：</strong></th>
		<td>
            <?=form::radio($allowposts, 'groupinfo[allowpost]', 'allowpost', $allowpost)?>
		</td>
	</tr>
	<tr>
		<th><strong>是否禁用：</strong></th>
		<td><?=form::radio($disableds, 'groupinfo[disabled]', 'disabled', $disabled)?></td>
	</tr>
	<tr>
    	<th><strong>最大短消息数：</strong></th>
        <td>
        	<?=form::text('groupinfo[allowmessage]', 'allowmessage', $allowmessage, 'text', 6, '', 'manxlength="50"')?>
        条</td>
    </tr>
	<tr>
		<th><strong>包年价格：</strong></th>
		<td>
        	<?=form::text('groupinfo[price_y]', 'price_y', $price_y, 'text', 8, '', 'manxlength="50"')?>
        </td>
	</tr>
	<tr>
		<th><strong>包月价格：</strong></th>
		<td>
        	<?=form::text('groupinfo[price_m]', 'price_m', $price_m, 'text', 8, '', 'manxlength="50"')?>
        </td>
	</tr>
	<tr>
		<th><strong>包日价格：</strong></th>
		<td>
        	<?=form::text('groupinfo[price_d]', 'price_d', $price_d, 'text', 8, '', 'manxlength="50"')?>
        </td>
	</tr>
	<tr>
		<td></td>
		<td>
        <input type="hidden" name="groupid" value="<?=$groupid?>">
        <input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="reset" name="reset" value=" 清除 ">
		</td>		
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