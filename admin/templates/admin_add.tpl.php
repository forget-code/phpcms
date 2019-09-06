<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" method="post" name="myform">
<table cellpadding="0" cellspacing="1" class="table_form">
    <caption>添加管理员</caption>
	<tr> 
      <th width="20%"><strong>用户名</strong></th>
      <td>
      <input type="text" name="admin[username]" id="username" value="<?=$username?>" size="20" require="true" datatype="limit|ajax" url="?mod=<?=$mod?>&file=<?=$file?>&action=check" min="3" max="20" msg="用户名不得少于3个字符超过20个字符|"> <a href="?mod=member&file=member&action=add&forward=<?=urlencode(URL)?>">点这里添加新会员</a>
      </td>
    </tr>
	<tr> 
      <th><strong>安全策略</strong></th>
      <td>
      <input type="checkbox" name="admin[editpasswordnextlogin]" id="editpasswordnextlogin" value="1" onclick="if(myform.editpasswordnextlogin.checked == false){myform.alloweditpassword.checked=false;myform.alloweditpassword.disabled=true}else{myform.alloweditpassword.disabled=false}">下次登录时必须更改密码<br />
      <input type="checkbox" name="admin[alloweditpassword]" id="alloweditpassword" value="1" checked onclick="if(myform.alloweditpassword.checked == false){myform.editpasswordnextlogin.checked=false;myform.editpasswordnextlogin.disabled=true}else{myform.editpasswordnextlogin.disabled=false}">允许用户自己更改密码<br />
	  <input type="checkbox" name="admin[allowmultilogin]" id="allowmultilogin" value="1" />允许多人同时使用此帐号登录
     </td>
    </tr>
	<tr> 
      <th><strong>所属角色</strong></th>
      <td>
<?php 
foreach($roles as $role)
{
?>
	  <input type="checkbox" name="roleids[]" value="<?=$role['roleid']?>" /><?=$role['name']?>（<?=$role['description']?>）<br />
<?php 
}	
?>
     </td>
    </tr>
	<tr> 
      <th><strong>锁定帐号</strong></th>
      <td>
<input type="radio" name="admin[disabled]" value="1" /> 是 <input type="radio" name="admin[disabled]" value="0" checked /> 否
     </td>
    </tr>
    <tr> 
      <th></th>
      <td>
	  <input type="submit" name="dosubmit" value=" 确定 "> 
     &nbsp; <input type="reset" name="reset" value=" 清除 "> </td>
    </tr>
</table>



</form>
</body>
</html>
<script language="javascript" type="text/javascript">
$().ready(function() {
	  $('form').checkForm(1);
	});
</script>