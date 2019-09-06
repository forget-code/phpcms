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
  <th colspan=2>基本信息</th>
      <tr>
      <td width='30%' class='tablerow'><strong>群发邮件时每轮默认发送邮件数</strong></br>每轮不宜太多，容易失败
	  </td>
      <td class='tablerow'><input name='setting[maxnum]' type='text' id='maxnum' value='<?=$maxnum?>' size='40' maxlength='50'>
     </td>
    </tr>
    <tr>
      <td class='tablerow'><strong>前台用户发送邮件时是否开启验证码</strong></td>
      <td class='tablerow'><input type='radio' name='setting[ischeckcode]' value='1'  <?php if($ischeckcode){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[ischeckcode]' value='0'  <?php if(!$ischeckcode){ ?>checked <?php } ?>> 否
	 </td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>邮件模块绑定域名</strong><br>最后不带反斜线'/'</td></td>
      <td class='tablerow'><input name='setting[moduledomain]' type='text' id='moduledomain' value='<?=$moduledomain?>' size='40' maxlength='50'></td>
    </tr>
     <tr>
      <td width='40%' class='tablerow'><strong>用户激活email邮件模板</strong></td></td>
      <td class='tablerow'><input type="button" value="点击修改" onclick="location='?mod=phpcms&file=template&action=edit&template=mailtpl&module=<?=$mod?>&project=default'"></td>
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