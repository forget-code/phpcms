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
  <th colspan=2>推广联盟模块配置</th>
    <tr>
      <td width='40%' class='tablerow'><strong>Cookie保存时间</strong></td>
      <td class='tablerow'>
	  <select name="setting[keeptime]">
	  <option value="86400" <?php if($keeptime == 86400){ ?>selected<?php } ?>>一天</option>
	  <option value="604800" <?php if($keeptime == 604800){ ?>selected<?php } ?>>一周</option>
	  <option value="2592000" <?php if($keeptime == 2592000){ ?>selected<?php } ?>>一月</option>
	  <option value="7776000" <?php if($keeptime == 7776000){ ?>selected<?php } ?>>一季度</option>
	  <option value="15552000" <?php if($keeptime == 15552000){ ?>selected<?php } ?>>半年</option>
	  <option value="31536000" <?php if($keeptime == 31536000){ ?>selected<?php } ?>>一年</option>
	  </select>
	  </td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>初始利润率</strong></td>
      <td class='tablerow'><input name='setting[profitmargin]' type='text' id='profitmargin' value='<?=$profitmargin?>' size='3' maxlength='3'>%</td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>访客默认跳转地址</strong></td>
      <td class='tablerow'><input name='setting[forward]' type='text' id='forward' value='<?=$forward?>' size='50' maxlength='100'></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>带来一个有效IP访问赠送</strong></td>
      <td class='tablerow'>
	  <input name='setting[visitgetnumber]' type='text' id='visitgetnumber' value='<?=$visitgetnumber?>' size='4' maxlength='5'>
	  <select name="setting[visitgettype]">
	  <option value="credit" <?php if($visitgettype == 'credit'){ ?>selected<?php } ?>>分</option>
	  <option value="point" <?php if($visitgettype == 'point'){ ?>selected<?php } ?>>点</option>
	  <option value="money" <?php if($visitgettype == 'money'){ ?>selected<?php } ?>>元</option>
	  </select>
	  </td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>带来一个注册用户赠送</strong></td>
      <td class='tablerow'>
	  <input name='setting[reggetnumber]' type='text' value='<?=$reggetnumber?>' size='4' maxlength='5'>
	  <select name="setting[reggettype]">
	  <option value="credit" <?php if($reggettype == 'credit'){ ?>selected<?php } ?>>分</option>
	  <option value="point" <?php if($reggettype == 'point'){ ?>selected<?php } ?>>点</option>
	  <option value="money" <?php if($reggettype == 'money'){ ?>selected<?php } ?>>元</option>
	  </select>
	  </td>
    </tr>
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