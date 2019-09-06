<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="0" cellspacing="1" class="table_form">
<input type='hidden' name='setting[validation]' value='0'>
  <caption><?=$M['name']?>模块配置</caption>
  <tr>
    <th width="25%"><strong>群发邮件时每轮默认发送邮件数</strong>
	<br/>每轮不宜太多，容易失败</th>
    <td width="75%"><input name='setting[maxnum]' type='text' id='maxnum' value='<?=$maxnum?>' size='10' maxlength='50'></td>
  </tr>
  <tr>
    <th><strong>前台用户发送邮件时开启验证码</strong></th>
    <td><input type='radio' name='setting[ischeckcode]' value='1'  <?php if($ischeckcode){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[ischeckcode]' value='0'  <?php if(!$ischeckcode){ ?>checked <?php } ?>> 否</td>
  </tr>

  <tr>
    <th>&nbsp;</th>
    <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;
	</td>
  </tr>
</table></form></body>
</html>
