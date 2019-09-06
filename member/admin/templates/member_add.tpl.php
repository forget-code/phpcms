<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=add">
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>添加会员</caption>
      <tr>
        <th width="20%"><strong>用户名：</strong></th>
        <td width="80%">
			<?=form::text('info[username]', 'username', '', 'text', 16, '', 'maxlength="20" require="true" datatype="limit|ajax" url="?mod=member&file=member&action=checkuser" min="2" max="20" msg="用户名不得少于3个字符超过20个字符|"')?>
        </td>
      </tr>
      <tr>
        <th><strong>密码：</strong><br />6到16个字符</th>
        <td>
        <?=form::text('info[password]', 'password', '', 'password', 16, '', 'maxlength="16" require="true" datatype="limit" min="6" max="16" msg="密码不得少于6个字符或超过16个字符！" size="20" maxlength="16"')?>
        </td>
      </tr>
  	  <tr>
        <th><strong>确认密码：</strong></th>
        <td>
			<?=form::text('info[pwdconfirm]', 'pwdconfirm', '', 'password', 16, '', 'require="true" datatype="repeat" to="info[password]" msg="两次输入的密码不一致"')?>	
		</td>
      </tr>
      <tr>
        <th><strong>会员组：</strong></th>
        <td><?=form::select($GROUP, 'info[groupid]', 'groupid', 6, 1, '', 'require="true" msg="请选择用户组"')?></td>
      </tr>
	  <tr>
		<th><strong>会员模型：</strong></th>
		<td><?=form::select_member_model('info[modelid]', 'modelid', '请选择', 10, '')?></td>
	  </tr>
	  <tr>
        <th><strong>E-mail：</strong></th>
        <td>
        <?=form::text('info[email]', 'email', '', 'text', 30, '', 'maxlength="50" require="true" datatype="email|ajax" url="?mod=member&file=member&action=checkemail" msg="邮件格式不正确|"')?>
        </td>
      </tr>
      <tr>
      	<th><strong>地区：</strong><br /><a href="?mod=phpcms&file=area&action=add&forward=<?=urlencode(URL)?>">添加地区</a></th>
        <td>
             <?php 
				if($areaid)
				{
			?>
            	<input type="hidden" name="info[areaid]" id="areaid" value="<?=$areaid?>">
				<span onClick="this.style.display='none';$('#reselect_areaid').show();" style="cursor:pointer;"><?=$AREA[$areaid]['name']?> <font color="red">点击重选</font></span>
			    <span id="reselect_areaid" style="display:none;">
			    <span id="load_areaid"></span> 
			    <a href="javascript:areaid_reload();">重选</a>
                </span>
            <?php
				}
				else
				{
			?>
					<input type="hidden" name="info[areaid]" id="areaid" value="<?=$areaid?>">
					<span id="load_areaid"></span>
					<a href="javascript:areaid_reload();">&nbsp;重选&nbsp;</a>
			<?php
                }
			?>
         </td>
      </tr>
	 
	  <tr>
		<td></td>
      	<td>
			<input type="hidden" name="forward" value="<?=$forward?>" />
			<input type="submit" name="dosubmit" value=" 添加 ">
	        <input type="reset" name="reset" value=" 清除 ">			
        </td>
     </tr>
</table>
</form>
</body>
</html>
<script LANGUAGE="javascript">
<!--
$().ready(function() {
	  $('form').checkForm(1);
	});
function areaid_load(id)
{
	$.get("<?=PHPCMS_PATH?>load.php", { field: 'areaid', id: id },
		function(data){
			$('#load_areaid').append(data);
			  });
	}
function areaid_reload()
{
	$('#load_areaid').html('');
		areaid_load(0);
}
areaid_load(0);
//-->
</script>