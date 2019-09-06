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
      <td class='tablerow'><strong>是否允许新会员注册</strong></td>
      <td class='tablerow'>
	  <input type='radio' name='setting[enableregister]' value='1'  <?php if($enableregister){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enableregister]' value='0'  <?php if(!$enableregister){ ?>checked <?php } ?>> 否
	 </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>新会员注册是否需要邮件验证</strong></td>
      <td class='tablerow'>
	  <input type='radio' name='setting[enablemailcheck]' value='1'  <?php if($enablemailcheck){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enablemailcheck]' value='0'  <?php if(!$enablemailcheck){ ?>checked <?php } ?>> 否
	 </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>新会员注册是否需要管理员审核</strong></td>
      <td class='tablerow'>
	  <input type='radio' name='setting[enableadmincheck]' value='1'  <?php if($enableadmincheck){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enableadmincheck]' value='0'  <?php if(!$enableadmincheck){ ?>checked <?php } ?>> 否
	 </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>每个Email是否允许注册多次</strong></td>
      <td class='tablerow'>
	  <input type='radio' name='setting[enablemultiregperemail]' value='1'  <?php if($enablemultiregperemail){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enablemultiregperemail]' value='0'  <?php if(!$enablemultiregperemail){ ?>checked <?php } ?>> 否
	 </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>会员注册是否启用验证码功能</strong></td>
      <td class='tablerow'>
	  <input type='radio' name='setting[enablecheckcodeofreg]' value='1'  <?php if($enablecheckcodeofreg){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enablecheckcodeofreg]' value='0'  <?php if(!$enablecheckcodeofreg){ ?>checked <?php } ?>> 否
	 </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>会员登录是否启用验证码功能</strong></td>
      <td class='tablerow'>
	  <input type='radio' name='setting[enablecheckcodeoflogin]' value='1'  <?php if($enablecheckcodeoflogin){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enablecheckcodeoflogin]' value='0'  <?php if(!$enablecheckcodeoflogin){ ?>checked <?php } ?>> 否
	 </td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>用户资金数发生变化时是否发送Email</strong></td>
            <td class='tablerow'>
	  <input type='radio' name='setting[ismoneydiffemail]' value='1'  <?php if($ismoneydiffemail){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[ismoneydiffemail]' value='0'  <?php if(!$ismoneydiffemail){ ?>checked <?php } ?>> 否&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="button" value="点击修改资金变化邮件模板" onclick="location='?mod=phpcms&file=template&action=edit&template=moneymailtpl&module=<?=$mod?>&project=default'">
	 </td>
    </tr>
   <tr>
      <td width='40%' class='tablerow'><strong>用户购买点卡时是否发送Email</strong></td>
            <td class='tablerow'>
	  <input type='radio' name='setting[ispointdiffemail]' value='1'  <?php if($ispointdiffemail){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[ispointdiffemail]' value='0'  <?php if(!$ispointdiffemail){ ?>checked <?php } ?>> 否&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="button" value="点击修改点卡变化邮件模板" onclick="location='?mod=phpcms&file=template&action=edit&template=pointmailtpl&module=<?=$mod?>&project=default'">
	 </td>
    </tr>
	<tr>
      <td width='40%' class='tablerow'><strong>禁止在注册用户名中使用的词语</strong><br/>多个词之间用","分隔,例如如果你禁用了"admin"，那么所有含有"admin"(如:administrator)的用户名将被禁止使用</td>
      <td class='tablerow'><textarea name='setting[banname]' cols='60' rows='4' id='banname'><?=$banname?></textarea></td>
    </tr>

    <tr>
      <td width='40%' class='tablerow'><strong>用户注册协议</strong><br/>留空则注册时直接跳过阅读注册协议</td>
      <td class='tablerow'><textarea name='setting[reglicense]' cols='60' rows='8' id='reglicense'><?=$reglicense?></textarea></td>
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