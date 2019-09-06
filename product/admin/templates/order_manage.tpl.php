<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>

<body>
<?=$menu?>
<table width="455" cellpadding="2" cellspacing="2" class="tableborder">
<form method="get" name="search" action="?">
  <tr>
    <td height="30" class="tablerow"> 按订单号搜索:
	<input name='action' type='hidden' value='<?=$action?>'>
	<input name='mod' type='hidden' value='<?=$mod?>'>
	<input name='file' type='hidden' value='<?=$file?>'>
&nbsp;<input name='keywords' type='text' size='40' value='<?if(isset($keywords)){echo $keywords;}?>' onclick="this.value='';" title="关键词...">&nbsp;
	<input type='submit' value=' 搜索 '>&nbsp;&nbsp;&nbsp;&nbsp;<a href="?mod=<?=$mod?>&file=<?=$file?>#advancedsearch"><font color="Blue"><strong>高级搜索</strong></font></a></td>
  </tr>
</form>
</table>
<table width="100%" height="10" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=10>订单列表</th>
  </tr>
<form method="post" name="myform">
<tr align="center">
<td width="10%" class="tablerowhighlight">选中</td>
<td width="10%"" class="tablerowhighlight">ID</td>
<td width="25%" class="tablerowhighlight">订单号</td>
<td width="15%" class="tablerowhighlight">下单时间</td>
<td width="10%" class="tablerowhighlight">收货人</td>
<td width="20%" class="tablerowhighlight">状态</td>
<td width="10%" class="tablerowhighlight">管理操作</td>
</tr>
<?php
foreach($odrs as $odr)
{
?>
<tr align="center" <?php if($odr['isverify']=='未审核') echo 'bgcolor="#BFDFFF" '; else echo 'bgColor="#F1F3F5"';?>  title="收货人：<?=$odr['truename']?>&#10;电话：<?=$odr['telephone']?>&#10;手机：<?=$odr['mobile']?>&#10;地址：<?=$odr['address']?>">
<td><input name='odr_ids[]' type='checkbox' value='<?=$odr['odr_id']?>'></td>
<td><?=$odr['odr_id']?></td>
<td><a href="?mod=<?=$mod?>&file=<?=$file?>&odr_id=<?=$odr['odr_id']?>&action=view"><?=$odr['odr_No']?></a></td>
<td><?=$odr['addtime']?></td>
<td><?=$odr['truename']?></td>
<td>
<a href="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=changestatus&job=isverify&odr_id=<?=$odr['odr_id']?>','确认改变审核状态吗？')"><?php if($odr['isverify']=='未审核') echo "<strong>".$odr['isverify']."</strong>"; else echo $odr['isverify'];?></a> | 
 <a href="javascript:if(confirm('确认改变付款状态吗？'))  this.location='?mod=<?=$mod?>&file=<?=$file?>&action=changestatus&job=ispay&odr_id=<?=$odr['odr_id']?>'"><?=$odr['ispay']?></a> | 
 <a href="javascript:if(confirm('确认改变发货状态吗？'))  location='?mod=<?=$mod?>&file=<?=$file?>&action=changestatus&job=isship&odr_id=<?=$odr['odr_id']?>'"><?=$odr['isship']?></a></td>
<td>
<a href="?mod=<?=$mod?>&file=<?=$file?>&odr_id=<?=$odr['odr_id']?>&action=view">查看</a> 
<a href="javascript:if(confirm('确认删除该条数据吗？')) location='?mod=<?=$mod?>&file=<?=$file?>&odr_id=<?=$odr['odr_id']?>&action=delete'">删除</a></td>
</tr>
<?php
}
?>
</table>
<table width="100%" height="10" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
  </tr>
</table>
<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='check'>全选/反选</td>
    <td align="left">
		<input name='submit0' type='submit' value='批量删除' onClick="if(confirm('确认批量删除这些订单吗？')) document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete&dosubmit=1'">&nbsp;
        <input name='submit1' type='submit' value='批量改变审核状态' onClick="if(confirm('确认批量改变审核状态吗？')) document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=changestatus&job=isverify&dosubmit=1&referer=<?=urlencode($PHP_URL)?>'"></td>
  </tr>
</table>
<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align=center><?=$pages?></td>
  </tr>
</table>
</form>
<a name="advancedsearch"></a>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=8>订单高级搜索</th>
  </tr>
<form method="POST" name="advancedsearch" action="?mod=<?=$mod?>&file=<?=$file?>&action=manage">
<tr>
<td align="center" width="12%" class="tablerowhighlight"> 订单编号： </td>
<td width="15%" class="tablerow"><input name='odr_No' type='text' size='20' value='<?=$odr_id?>'></td>
<td align="center" width="10%" class="tablerowhighlight">收货人姓名</td>
<td width="15%" class="tablerow"><input name='truename' type='text' size='15' value='<?=$truename?>'></td>
<td align="center" width="10%" class="tablerowhighlight"> 订单状态： </td>
<td width="10%" class="tablerow"><select name="isverify" id="select">
  <option value="">不限</option>
  <option value="1">已审核</option>
  <option value="0">未审核</option>
</select></td>
<td align="center" width="10%" class="tablerow">
  <select name="ispay" id="ispay">
    <option value="">不限</option>
  <option value="1">已付款</option>
  <option value="0">未付款</option>
  </select>
</td>
<td width="15%" class="tablerow"><select name="isship" id="isship">
  <option value="">不限</option>
  <option value="1">已发货</option>
  <option value="0">未发货</option>
</select>
</td>
</tr>
<tr>
  <td align="center" class="tablerowhighlight">商品名称</td>
  <td class="tablerow"><input name='pdt_name' type='text' size='15' value='<?=$pdt_name?>'></td>
  <td align="center" class="tablerowhighlight">商品编号：</td>
  <td class="tablerow"><input name='pdt_No' type='text' size='15' value='<?=$pdt_No?>'></td>
  <td align="center" class="tablerowhighlight">用户名：</td>
<td class="tablerow"><input name='username' type='text' size='15' value='<?=$username?>'>
</td>
<td align="center" class="tablerowhighlight"> 支付方式： </td>
<td class="tablerow"><select name="paytype" id="select4" style="width:110">
  <option value="">不限</option>
</select></td>
</tr>
<tr>
<td align="center" width="12%" class="tablerowhighlight">省份：</td>
<td width="15%" class="tablerow">
<select name="province" id="province" onchange="javascript:loadcity(this.value);">
<option value="0" selected="selected">请选择</option>
</select>
</td>
<td align="center" width="10%" class="tablerowhighlight">城市：</td>
<td width="15%" class="tablerow"><select name="city" id="city" onchange="javascript:loadarea($('province').value, this.value);">
<option value="0" selected="selected">请选择</option>
</select>
</td>
<td align="center" width="10%" class="tablerowhighlight">区域：</td>
<td class="tablerow"><select name="area" id="area">
<option value="0" selected="selected">请选择</option>
</select>
</td>
<script language="javascript">
<!--
var phpcms_path = '<?=PHPCMS_PATH?>';
var selectedprovince = '';
var selectedcity = '';
var selectedarea = '';
//-->
</script>
<script type="text/javascript" src="<?=PHPCMS_PATH?>include/js/area.js"></script>	 
<td  align="center" class="tablerowhighlight">邮件：</td>
<td class="tablerow"><input name='email' type='text' size='15' value='<?=$email?>'></td>
</tr>
<tr>
  <td align="center" class="tablerowhighlight">地址</td>
  <td colspan="3" class="tablerow"><input name='address' type='text' size='50' value='<?=$address?>'></td>
<td align="center" class="tablerowhighlight"> 电话： </td>
<td class="tablerow"><input name='telephone' type='text' size='15' value='<?=$telephone?>'></td>
<td align="center" class="tablerowhighlight">手机：</td>
<td class="tablerow"><input name='mobile' type='text' size='15' value='<?=$mobile?>'></td>
</tr>
<tr>
  <td align="center" class="tablerowhighlight">下单时间</td>
  <td class="tablerow">从：<?=date_select('begindate',$begindate)?>
  <br>到：<?=date_select('enddate',$enddate)?></td>
  <td align="center" class="tablerowhighlight">总消费金额</td>
  <td class="tablerow"><input name='frompayment' type='text' size='5' value=''>
  -
    <input name='topayment' type='text' size='5' value=''></td>
  <td align="center" class="tablerowhighlight">&nbsp;</td>
  <td class="tablerow">&nbsp;</td>
  <td class="tablerow">&nbsp;</td>
  <td class="tablerow">&nbsp;</td>
</tr>
<tr>
<td colspan=8 height="30" class="tablerow" align="center">
<input name='mod' type='hidden' value='<?=$mod?>'>
<input name='file' type='hidden' value='<?=$file?>'>
<input name='action' type='hidden' value='<?=$action?>'>
<input name='dosubmit' type='submit' value=' 搜索 '>
</td>
  </tr>
</form>
</table>
</body>
</html>