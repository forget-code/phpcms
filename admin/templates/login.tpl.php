<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body onload="javascript:document.myform.username.focus();">
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="50">
  <tr>
    <td ></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="500" align='center'>
  <tr>
    <td >
<table border='0' cellpadding='1' cellspacing='1' align='center' class="tableborder">
  <tr>
    <th colspan=2>PHPCMS <?=PHPCMS_VERSION?> 网站管理登录</th>
  </tr>
  <form name="myform" method="post" action="?mod=phpcms&file=login" onsubmit="document.myform.phpcms_user.value = escape(document.myform.username.value);return true;">
    <tr> 
      <td align="right"  class="tablerow" width="40%">帐号</td>
      <td class="tablerow">
	  <input name="username" type="text" size="15" value="<?=$username?>">
	  <input type="hidden" name="phpcms_user" id="phpcms_user" />
	  </td>
    </tr>
    <tr> 
      <td align="right"  class="tablerow">密码</td>
      <td  class="tablerow"><input name="password" type="password" size="15" value="<?=$password?>"></td>
    </tr>
<?php if($PHPCMS['enableadmincheckcode']){?>
    <tr> 
      <td align="right" class="tablerow">验证码</td>
      <td class="tablerow" height="29"><input name="checkcodestr" type="text" size="15">
	  <img src="<?=PHPCMS_PATH?>checkcode.php" id="checkcode" onclick="this.src='<?=PHPCMS_PATH?>checkcode.php?id='+Math.random()*5;" style="cursor:pointer;" alt="验证码,看不清楚?请点击刷新验证码" align="absmiddle"/>
	  </td>
    </tr>
<?php } ?>
    <tr> 
      <td align="center"  class="tablerow"></td>
      <td  class="tablerow">
	  <input type="hidden" name="forward" value="<?=$forward?>">
	  <input type="submit" name="dosubmit" value=" 登录 "> 
	  <input type="reset" name="Reset" value=" 清除 "></td>
    </tr>
</table>
</td>
  </tr>
</table>
</body>
</html>