<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script type="text/javascript" src="images/js/validator.js"></script>
<form method="post" name="myform" >
<table cellpadding="0" cellspacing="1" class="table_form">
	<caption>群发短消息</caption>
    <tr>
		<th><strong>角色：</strong></th>
    	<td>
        	<?=form::select($role_group, $name = 'roleid', $id = 'roleid', $roleid)?>
        </td>
    </tr>
	<tr>
		<th><strong>标题：</strong></th>
		<td><input type="text" name="subject" id="subject" size="60" require="true" datatype="require|limit" min="1" max="80" msg="标题不能空|标题长度必须在1到80个字符之间" /></td>
	</tr>
	<tr>
		<th><strong>内容：</strong></th>
		<td>
            <?=form::textarea($name = 'content', $id = 'content', '', '', '', '', 'style="height=200"')?>
			<?=form::editor()?>
		</td>
	</tr>
    <tr>
    	<th><strong>同时发送邮件：</strong></th>
        <td><input type="checkbox" name="send" value="1" /> 是</td>
    </tr>
    <tr>
    	<th><strong>每轮最大发送数：</strong></th>
        <td><input type="text" name="sendnumber" value="100" size="4" /></td>
    </tr>
	<tr>
     	<th>&nbsp;</th>
        <div class="button_box">
    	<td>
        <input type="submit" class="button_style" name="dosubmit" value=" 确定 " />&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="button_style"  type="reset" name="reset" value=" 重置 " />
        </td>
        </div>
  </tr>
</table>
</form>
<table cellpadding="0" cellspacing="1" class="table_info">
	<caption>注意事项</caption>
    <tr>
    	<td>
        	1,选择群发邮件会增加服务器的压力，请慎重使用。<br />
            2,发送邮件的发信地址会使用当前发送短消息人的邮件地址。
        </td>
    </tr>
</table>
</body>
</html>
<script language="javascript">
	$().ready(function() {
	  $('form').checkForm(1);
	});
</script>