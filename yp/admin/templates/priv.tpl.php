<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption><?=$M['name']?> 模块权限设置</caption>
    <tr>
      <td width="100"><strong>角色</strong></td>
<?php 
foreach($privs as $priv)
{
?>
      <td width="30"><strong><?=$priv['name']?></strong></td>
<?php
} 
?>
	</tr>
<?php 
foreach($ROLE as $roleid=>$name)
{
?>
    <tr>
      <td><?=$name?></td>
<?php 
foreach($privs as $priv=>$p)
{
?>
      <td><input type="checkbox" name="priv_roleid[]" value="<?=$priv?>,<?=$roleid?>" <?=$priv_role->check('module', $mod, $priv, $roleid) ? 'checked' : ''?>/></td>
<?php
} 
?>
    </tr>
<?php
} 
?>
</table>
<div class="button_box" style="text-align:center">
<input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 ">
</div>
</form>
<table cellpadding="0" cellspacing="1" class="table_info">
  <caption>提示信息</caption>
  <tr>
    <td>
1、如果指定了模块管理权限，那么该角色就拥有此模块的所有操作权限。<br />
	</td>
  </tr>
</table>
</body>
</html>