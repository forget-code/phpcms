<?php defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <th colspan=2>咨询模块配置</th>
	<tr>
      <td class='tablerow'><strong>是否启用验证码</strong></td>
      <td class='tablerow'>
	  <input type='radio' name='setting[enablecheckcode]' value='1'  <?php if($enablecheckcode){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enablecheckcode]' value='0'  <?php if(!$enablecheckcode){ ?>checked <?php } ?>> 否
	 </td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>模块绑定域名</strong></td>
      <td class='tablerow'><input name='setting[moduledomain]' type='text' id='moduledomain' value='<?=$moduledomain?>' size='40' maxlength='50'></td>
    </tr>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width='40%'></td>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>
</body>
</html>