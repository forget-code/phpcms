<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="0" cellspacing="1" class="table_form">
    <caption>修改管理员</caption>
   <form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&userid=<?=$userid?>" method="post" name="myform">
    <tr> 
      <th width="20%"><strong>用户名</strong></th>
      <td>
      <?=$username?>
      </td>
    </tr>
	<tr> 
      <th><strong>安全策略</strong></th>
      <td>
      <input type="checkbox" name="admin[editpasswordnextlogin]" id="editpasswordnextlogin" value="1"  <?=($editpasswordnextlogin ? 'checked' : '')?> onclick="if(myform.editpasswordnextlogin.checked == false){myform.alloweditpassword.checked=false;myform.alloweditpassword.disabled=true}else{myform.alloweditpassword.disabled=false}">下次登录时必须更改密码<br />
      <input type="checkbox" name="admin[alloweditpassword]" id="alloweditpassword" value="1"  <?=($alloweditpassword ? 'checked' : '')?> onclick="if(myform.alloweditpassword.checked == false){myform.editpasswordnextlogin.checked=false;myform.editpasswordnextlogin.disabled=true}else{myform.editpasswordnextlogin.disabled=false}">允许用户自己更改密码<br />
	  <input type="checkbox" name="admin[allowmultilogin]" id="allowmultilogin" value="1"  <?=($allowmultilogin ? 'checked' : '')?>/>允许多人同时使用此帐号登录
     </td>
    </tr>
	<tr> 
      <th><strong>所属角色</strong></th>
      <td>
<?php 
foreach($roles as $role)
{
?>
	  <input type="checkbox" name="roleids[]" value="<?=$role['roleid']?>" <?=(in_array($role['roleid'], $roleids) ? 'checked' : '')?>/><?=$role['name']?>（<?=$role['description']?>）<br />
<?php 
}	
?>
     </td>
    </tr>
	<tr> 
      <th><strong>锁定帐号</strong></th>
      <td>
<input type="radio" name="admin[disabled]" value="1" <?=($disabled ? 'checked' : '')?>/> 是 <input type="radio" name="admin[disabled]" value="0" <?=($disabled ? '' : 'checked')?>/> 否
     </td>
    </tr>
    <tr> 
      <td></td>
      <td>
	  <input type="submit" name="dosubmit" value=" 确定 "> 
     &nbsp; <input type="reset" name="reset" value=" 清除 "> </td>
    </tr>
  </form>
</table>
</body>
</html>