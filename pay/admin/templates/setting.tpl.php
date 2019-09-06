<?php defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body onload="<?=$alipay_service == 'trade_create_by_buyer' ? 'pay(\'trade_create_by_buyer\')' : ''?>">
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <th colspan=2>基本信息</th>
    <tr>
      <td width='20%' class='tablerow'><strong>支付类型</strong></td>
      <td class='tablerow'>
         <textarea name='setting[paytypes]' cols='30' rows='8' id='paytypes'><?=$paytypes?></textarea>
	 </td>
    </tr>
    <tr>
      <td class='tablerow'><strong>支付宝帐号</strong></td>
      <td class='tablerow'><input name='setting[alipay]' type='text' id='alipay' value='<?=$alipay?>' size='40' maxlength='100'> 支付宝收款帐号</td>
    </tr>
	<script type="text/javascript">
	function pay(obj)
	{
		if(obj=='trade_create_by_buyer')
		{
			$('trade').style.display = 'block';
		}
		else
		{
			$('trade').style.display = 'none';
		}
	}
	</script>
    <tr>
      <td class='tablerow'><strong>支付宝交易类型</strong></td>
      <td class='tablerow'>
	  <select name="setting[alipay_service]" onchange="pay(this.value)">
	  <option value="create_digital_goods_trade_p" <?=$alipay_service == 'create_digital_goods_trade_p' ? 'selected' : ''?>>虚拟类交易</option>
	  <option value="trade_create_by_buyer" <?=$alipay_service == 'trade_create_by_buyer' ? 'selected' : ''?>>实物类交易</option>
	  <option value="create_donate_trade_p" <?=$alipay_service == 'create_donate_trade_p' ? 'selected' : ''?>>捐赠类交易</option>
	  <option value="create_direct_pay_by_user" <?=$alipay_service == 'create_direct_pay_by_user' ? 'selected' : ''?>>即时到帐交易</option>
	  </select>
	  </td>
    </tr>
	<tbody id="trade" style="display:none;">
	<tr>
	<td class="tablerow">
	<strong>物流配送方法</strong>
	</td>
	<td class="tablerow">
	<select name="setting[logistics_type]" id="logistics_type">
	<option value="POST" <?=$logistics_type == 'POST' ? 'selected' : ''?>>平邮</option>
	<option value="EMS" <?=$logistics_type == 'EMS' ? 'selected' : ''?>>EMS</option>
	<option value="EXPRESS" <?=$logistics_type == 'EXPRESS' ? 'selected' : ''?>>其他快递</option>
	</select>
	</td>
	</tr>
	<tr>
	<td class="tablerow">
	<strong>物流配送付款方式</strong>
	</td>
	<td class="tablerow">
	<select name="setting[logistics_payment]" id="logistics_payment">
	<option value="SELLER_PAY" <?=$logistics_payment == 'SELLER_PAY' ? 'selected' : ''?>>卖家支付</option>
	<option value="BUYER_PAY" <?=$logistics_payment == 'BUYER_PAY' ? 'selected' : ''?>>买家支付</option>
	<option value="BUYER_PAY_AFTER_RECEIVE" <?=$logistics_payment == 'BUYER_PAY_AFTER_RECEIVE' ? 'selected' : ''?>>货到付款</option>
	</select>
	</td>
	</tr>
	<tr>
	<td class="tablerow">
	<strong>物流配送费用</strong>
	</td>
	<td class="tablerow">
	<input type="text" name="setting[logistics_fee]" id="logistics_fee" value="<?=$logistics_fee?>">
	</td>
	</tr>
	</tbody>
    <tr>
      <td class='tablerow'><strong>银行卡支付设置</strong></td>
      <td class='tablerow'>
         <textarea name='setting[banks]' cols='80' rows='10' id='banks'><?=$banks?></textarea><?=editor('banks','introduce',600,400)?>
	 </td>
    </tr>
    <tr>
      <td width='20%' class='tablerow'><strong>启用积分/点数/资金转入</strong></td>
      <td class='tablerow'>
         <input type="radio" name='setting[enabletransferin]' value="1" <?=($enabletransferin ? 'checked' : '')?> onclick="transferin1.style.display='block';transferin2.style.display='block';if(myform.dbfrom[1].checked)dbconfig.style.display='block'"> 是
         <input type="radio" name='setting[enabletransferin]' value="0" <?=($enabletransferin ? '' : 'checked')?> onclick="transferin1.style.display='none';transferin2.style.display='none';dbconfig.style.display='none'"> 否
	 </td>
    </tr>
<tbody id="transferin1" style="display:<?=($enabletransferin ? 'block' : 'none')?>">
    <tr>
      <td width='20%' class='tablerow'><strong>与phpcms同一数据库</strong></td>
      <td class='tablerow'>
         <input type="radio" name='setting[dbfrom]' id='dbfrom' value="0" <?=($dbfrom ? '' : 'checked')?> onclick="dbconfig.style.display='none'"> 是
         <input type="radio" name='setting[dbfrom]' id='dbfrom' value="1" <?=($dbfrom ? 'checked' : '')?> onclick="dbconfig.style.display='block'"> 否
	 </td>
    </tr>
</tbody>
<tbody id="dbconfig" style="display:<?=($enabletransferin && $dbfrom ? 'block' : 'none')?>">
    <tr>
      <td width='20%' class='tablerow'><strong>数据库服务器</strong></td>
      <td class='tablerow'><input name='setting[dbhost]' type='text' value='<?=$dbhost?>' size='30'></td>
    </tr>
    <tr>
      <td width='20%' class='tablerow'><strong>数据库帐号</strong></td>
      <td class='tablerow'><input name='setting[dbuser]' type='text' value='<?=$dbuser?>' size='30'></td>
    </tr>
    <tr>
      <td width='20%' class='tablerow'><strong>数据库密码</strong></td>
      <td class='tablerow'><input name='setting[dbpw]' type='text' value='<?=$dbpw?>' size='30'></td>
    </tr>
    <tr>
      <td width='20%' class='tablerow'><strong>数据库名</strong></td>
      <td class='tablerow'><input name='setting[dbname]' type='text' value='<?=$dbname?>' size='30'></td>
    </tr>
</tbody>
<tbody id="transferin2" style="display:<?=($enabletransferin ? 'block' : 'none')?>">
    <tr>
      <td width='20%' class='tablerow'><strong>数据表名</strong></td>
      <td class='tablerow'><input name='setting[table]' type='text' value='<?=$table?>' size='30'></td>
    </tr>
    <tr>
      <td width='20%' class='tablerow'><strong>用户名字段</strong></td>
      <td class='tablerow'><input name='setting[field_username]' type='text' value='<?=$field_username?>' size='15'></td>
    </tr>
    <tr>
      <td width='20%' class='tablerow'><strong>点数字段</strong></td>
      <td class='tablerow'><input name='setting[field_point]' type='text' value='<?=$field_point?>' size='15'> 留空表示不启用点数转入功能</td>
    </tr>
    <tr>
      <td width='20%' class='tablerow'><strong>积分字段</strong></td>
      <td class='tablerow'><input name='setting[field_credit]' type='text' value='<?=$field_credit?>' size='15'> 留空表示不启用积分转入功能</td>
    </tr>
    <tr>
      <td width='20%' class='tablerow'><strong>资金字段</strong></td>
      <td class='tablerow'><input name='setting[field_money]' type='text' value='<?=$field_money?>' size='15'> 留空表示不启用资金转入功能</td>
    </tr>
</tbody>
    <tr>
      <td class='tablerow'><strong>模块绑定域名</strong></td>
      <td class='tablerow'><input name='setting[moduledomain]' type='text' id='moduledomain' value='<?=$moduledomain?>' size='40' maxlength='50'></td>
    </tr>
  <tr>
     <td class='tablerow'></td>
     <td class='tablerow'><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>
</body>
</html>