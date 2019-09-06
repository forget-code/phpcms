<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include managetpl('header');
?>
<script language="javascript">
<!--
function CheckForm()
{
	if ($F('companyname') == "")
	{
		alert("企业名称不能为空！")
		Field.clear('companyname')
		Field.focus('companyname');
		return false
	}
	if ($F('product') == "")
	{
		alert("主营产品不能为空！")
		Field.clear('product')
		Field.focus('product');
		return false
	}
	if ($('trade').value=='0')
	{
		alert('请选择所属行业！');
		$('trade').focus();
		return false;
	}
<?php
if($MOD['enableSecondDomain'])
{
?>
	if ($F('sitedomain') == "")
	{
		alert("域名不能为空！")
		Field.clear('sitedomain')
		Field.focus('sitedomain');
		return false
	}
<?php
}
?>
	if ($F('email') != "")
	{
		var mail = $F('email');
		if(!RegExp(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/).test(mail))
		{
			alert("Email 地址错误，请检查")
			Field.focus('email');
			return false
		}
	}
}

<?php
if($MOD['enableSecondDomain'])
{
?>
function checkdomain(inputname)
{
    if(inputname==''){
        alert("域名不能为空！");
        $('domain_notice').innerHTML="<font color='red'>域名不能为空！</font>";
        Field.focus('sitedomain');
    }else{
        var checkurl = '<?=$SITEURL?>/yp/register.php';
		var pars = "action=checkdomain&domain="+inputname;
		var myAjax = new Ajax.Request(checkurl, {method: 'post', parameters: pars, onComplete: checkmessage});
    }
}

function checkmessage(Request)
{
	if(Request.responseText == '1'){
		alert("域名只能为 英文 数字 - 等组成，如：php-518.<?=$MOD['secondDomain']?>");
		$('domain_notice').innerHTML="域名只能为 英文 数字 - 等组成，如：<font color='#ff0000'>php-518</font>.<?=$MOD['secondDomain']?>";
		Field.clear('sitedomain')
		Field.focus('sitedomain');
	}
	else if(Request.responseText == '2'){
		alert("该域名已经被注册，请换其它域名");
		$('domain_notice').innerHTML="<font color='#ff0000'>该域名已经被注册，请换其它域名</font>";
		Field.clear('sitedomain')
		Field.focus('sitedomain');
	}
	else{
		$('domain_notice').innerHTML="<font color='#009148'>该域名可以注册</font>";
	}
}
<?php
}
?>

//-->
</script>

<BR>
  <form name="myform" method="post" action="" onSubmit='return CheckForm();'>
   <table cellpadding="2" cellspacing="1" class="tableborder">
   <th  colspan=2>修改企业信息</th>
    <tr>
      <td width="15%" class="tablerow">企业名称：</td>
      <td class="tablerow"><input name="companyname" type="text" id="companyname" size="25" value="<?=$companyname?>"> <font color="red">*</font>
     </td>
    </tr>
	<tr>
      <td class="tablerow">所属行业：</td>
      <td class="tablerow"><?=trade_select('tradeid', '请选择所属行业',$tradeid)?> <font color="red">*</font></td>
    </tr>
    <tr>
      <td class="tablerow">经营模式：</td>
      <td class="tablerow"><?=$editpattern?><font color="red">*</font></td>
    </tr>
    <tr>
      <td class="tablerow">企业性质：</td>
      <td class="tablerow"><?=$type_selected?></td>
    </tr>
    <tr>
      <td class="tablerow">主营产品/服务：</td>
      <td class="tablerow"><textarea name="product" cols="50" rows="5" id="product"><?=$product?></textarea>
              <Font color="#FF0000">* 请简洁说明企业主营产品和服务内容。字数在250字以内。</Font></td>
    </tr>
	<tr>
	 <td class="tablerow">企业所在地区：</td>
      <td class="tablerow"><span onclick="this.style.display='none';$('select_area').style.display='';" style="cursor:pointer;"><?=$AREA[$areaid]['areaname']?> <font color="red">点击重选</font></span><span id="select_area" style="display:none;">
      <?=ajax_area_select('areaid', $mod, $areaid)?></td>
    </tr>
    <tr>
      <td class="tablerow">企业成立时间：</td>
      <td class="tablerow"><?=date_select('regtime',$fromdate)?>
 <font color="red">*</font></td>
    </tr>
    <tr>
      <td class="tablerow">员工人数：</td>
      <td class="tablerow">
        <select name="employnum" id="employnum">
                <option value=""  selected >请选择 </option>
                <option value="1-5" <?php if($employnum=='1-5') echo 'selected="selected"'; ?>>5 人以下 </option>
                <option value="5-10" <?php if($employnum=='5-10') echo 'selected="selected"'; ?>>5-10 人 </option>
                <option value="11-50" <?php if($employnum=='11-50') echo 'selected="selected"'; ?>>11-50 人 </option>
                <option value="51-100" <?php if($employnum=='51-100') echo 'selected="selected"'; ?>>51-100 人 </option>
                <option value="101-500" <?php if($employnum=='101-500') echo 'selected="selected"'; ?>>101-500 人 </option>
                <option value="501-1000" <?php if($employnum=='501-1000') echo 'selected="selected"'; ?>>501-1000 人 </option>
                <option value="1000人以上" <?php if($employnum=='1000人以上') echo 'selected="selected"'; ?>>1000人以上 </option>
            </select></td>
    </tr>
<tr>
      <td class="tablerow">年营业额：</td>
      <td class="tablerow">
        <SELECT name="turnover" id="turnover"  >
		<OPTION value="" >选择年营业额</OPTION>
		<OPTION value="100万以下"  <?php if($turnover=='100万以下') echo 'selected="selected"'; ?>>100万以下</OPTION>
		<OPTION value="100万-250万" <?php if($turnover=='100万-250万') echo 'selected="selected"'; ?>>100万-250万</OPTION>
		<OPTION value="250万-500万" <?php if($turnover=='250万-500万') echo 'selected="selected"'; ?>>250万-500万</OPTION>
		<OPTION value="500万-1000万" <?php if($turnover=='500万-1000万') echo 'selected="selected"'; ?>>500万-1000万</OPTION>
		<OPTION value="1000万-5000万" <?php if($turnover=='1000万-5000万') echo 'selected="selected"'; ?>>1000万-5000万</OPTION>
		<OPTION value="5000万-1亿" <?php if($turnover=='5000万-1亿') echo 'selected="selected"'; ?>>5000万-1亿</OPTION>
		<OPTION value="1亿-10亿" <?php if($turnover=='1亿-10亿') echo 'selected="selected"'; ?>>1亿-10亿</OPTION>
		<OPTION value="10亿以上" <?php if($turnover=='10亿以上') echo 'selected="selected"'; ?>>10亿以上</OPTION>
        </SELECT>
	</td>
    </tr>
<?php
if($MOD['enableSecondDomain'])
{
?>
	<tr>
		<td class="tablerow">二级域名：</td>
		<td class="tablerow"><input name="sitedomain" type="text" id="sitedomain" value="<?=$domainName?>" size="25" onBlur="checkdomain(this.value);">
		.<?=$MOD['secondDomain']?> <font color="red">*</font> <span id="domain_notice"> 域名只能为 英文 数字 - 等组成，如：<font color="#ff0000">php-518</font>.<?=$MOD['secondDomain']?></span>
		<input name="olddomain" value="<?=$domainName?>" type="hidden"></td>
	</tr>
<?php
}
?>
<tr>
<td width="15%" class="tablerow">联系人：</td>
<td class="tablerow"><input name="linkman" type="text" id="linkman" size="25" value="<?=$linkman?>">
</td>
<tr>
<td width="15%" class="tablerow">联系电话：</td>
<td class="tablerow"><input name="telephone" type="text" id="telephone" size="25" value="<?=$telephone?>">
</td>
<tr>
<td width="15%" class="tablerow">传真：</td>
<td class="tablerow"><input name="fax" type="text" id="fax" size="25" value="<?=$fax?>">
</td>
<tr>
<td width="15%" class="tablerow">邮政编码：</td>
<td class="tablerow"><input name="postid" type="text" id="postid" size="25" value="<?=$postid?>">
</td>
<tr>
<td width="15%" class="tablerow">Email：</td>
<td class="tablerow"><input name="email" type="text" id="email" size="25" value="<?=$email?>">
</td>
<tr>
<td width="15%" class="tablerow">联系地址：</td>
<td class="tablerow"><input name="address" type="text" id="address" size="25" value="<?=$address?>">
</td>
<tr>
<td width="15%" class="tablerow">网址：</td>
<td class="tablerow"><input name="homepage" type="text" id="homepage" size="25" value="<?=$homepage?>">
</td>
<?=$fields?>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0" >
    <tr>
      <td width="40%">&nbsp;</td>
      <td height="25">
	      <input name="companyid" type="hidden" value="<?=$companyid?>">
	      <input name="forward" type="hidden" value="<?=$PHP_URL?>">
		  <input type="submit" name="dosubmit" value=" 确认修改 " class="btn">
	  </td>
     </tr>
</table>
</form>
</body>
</html>