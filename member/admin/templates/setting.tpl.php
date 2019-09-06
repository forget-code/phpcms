<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>基本信息</caption>
    <tr>
      <th width="200"><strong>允许新会员注册：</strong></th>
      <td>
	  <input type='radio' name='setting[allowregister]' value='1'  <?php if($allowregister){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[allowregister]' value='0'  <?php if(!$allowregister){ ?>checked <?php } ?>> 否
	 </td>
    </tr>
	 <tr>
      <th><strong>注册选择模型：</strong></th>
      <td>
	  <input type='radio' name='setting[choosemodel]' value='1'  <?php if($choosemodel){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[choosemodel]' value='0'  <?php if(!$choosemodel){ ?>checked <?php } ?>> 否
	 </td>
    </tr>
	<tr>
      <th><strong>新会员注册需要邮件验证：</strong></th>
      <td>
	  <input type='radio' name='setting[enablemailcheck]' value='1'  <?=($enablemailcheck ? 'checked' : '')?> /> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enablemailcheck]' value='0'   <?=($enablemailcheck ? '' : 'checked')?> /> 否
	 </td>
    </tr>	
    <tr>
    	<th><strong>允许前台浏览会员列表：</strong></th>
        <td>
        <input type="radio" name="setting[enableshowlist]" value="1" <?=($enableshowlist ? 'checked' : '')?> /> 是&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="setting[enableshowlist]" value="0" <?=($enableshowlist ? '' : 'checked')?> /> 否
        </td>
    </tr>
	<tr>
      <th><strong>新会员注册需要管理员审核：</strong></th>
      <td>
	  <input type='radio' name='setting[enableadmincheck]' value='1'  <?php if($enableadmincheck){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enableadmincheck]' value='0'  <?php if(!$enableadmincheck){ ?>checked <?php } ?>> 否
	 </td>
    </tr>
	<tr>
      <th><strong>会员注册启用验证码功能：</strong></th>
      <td>
	  <input type='radio' name='setting[enablecheckcodeofreg]' value='1'  <?php if($enablecheckcodeofreg){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enablecheckcodeofreg]' value='0'  <?php if(!$enablecheckcodeofreg){ ?>checked <?php } ?>> 否
	 </td>
    </tr>
    <tr>
    	<th><strong>会员注册时进行问题答案验证：</strong></th>
        <td>
	  <input type='radio' name='setting[enableQchk]' value='1'  <?php if($enableQchk){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enableQchk]' value='0'  <?php if(!$enableQchk){ ?>checked <?php } ?>> 否
	 </td>
    </tr>
	<tr>
	  <th><strong>会员升级付费方式：</strong></th>
	  <td>
	  <input type='radio' name='setting[paytype]' value='amount'  <?php if($paytype=='amount'){ ?>checked <?php } ?>> 金钱&nbsp;&nbsp;
	  <input type='radio' name='setting[paytype]' value='point'  <?php if($paytype=='point'){ ?>checked <?php } ?>> 积分
	  </td>
	</tr>
	<tr>
      <th><strong>新会员注册默认赠送点数：</strong></th>
      <td><input name='setting[defualtpoint]' type='text' id='defualtpoint' value='<?=$defualtpoint?>' size='5' maxlength='5'> 点</td>
    </tr>
	<tr>
      <th><strong>新会员注册默认赠送资金：</strong></th>
      <td><input name='setting[defualtamount]' type='text' id='defualtamount' value='<?=$defualtamount?$defualtamount:'0.00'?>' size='5' maxlength='5' require="true" datatype="currency" msg="请输入正确的金额" msgid="err_currency"> 元<span id="err_currency"></span></td>
    </tr>
    <tr>
      <th><strong>会员注册协议：</strong></th>
      <td><textarea name='setting[reglicense]' cols='60' rows='20' id='reglicense' style="width:100%"><?=$reglicense?></textarea></td>
    </tr>
	<tr>
      <th><strong>保留会员名设置：</strong></th>
      <td><textarea name='setting[preserve]' cols='30' rows='3' id='reglicense' style="width:50%"><?=$preserve?></textarea>&nbsp;&nbsp;<font style="color:#f00">用户名之间用英文“,”隔开。</font></td>
    </tr>
    <tr>
      <th><strong>模块访问网址（URL）：</strong></th>
      <td>
      <input name='setting[url]' type='text' id='url' value='<?=$url?>' size='40' maxlength='50'><br />
      如果其它与会员相关的栏目、模块绑定了其它域名(包括二级域名)，则会员模块的访问网址请填写 http://主站域名/member <br />
      当然，也可以为会员模块绑定其它域名(需要WEB服务器的配置)
      </td>
    </tr>
  	<tr>
	 <th>
	 </th>
     <td>
     <input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 ">
     </td>
  </tr>
</table>
</form>
</body>
</html>
<script language="javascript">
$().ready(function() {
	  $('form').checkForm(1);
});
</script>