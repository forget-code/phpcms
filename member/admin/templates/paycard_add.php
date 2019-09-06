<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script type="text/javascript" src="<?=PHPCMS_PATH?>include/js/MyCalendar.js"></script>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<?=$menu?>
<table cellpadding="2" cellspacing="1" border="0" align="center" class="tableBorder" >
  <form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=add&save=1">  
  <tr>
      <th colspan="2">批量产生充值卡</th>
  </tr>
  <tr>
    <td width="30%" align="right" class="tablerow">充值卡数量：</td>
    <td class="tablerow">&nbsp;<INPUT NAME="paycardnum" TYPE="text" value="100" size="15"></td>
  </tr>
  <tr>
    <td align="right" class="tablerow">充值卡面值：</td>
    <td class="tablerow">&nbsp;<INPUT NAME="paycardprice" TYPE="text" value="100" size="15">元</td>
  </tr>
  <tr>
    <td align="right" class="tablerow">卡号前缀：</td>
    <td class="tablerow">&nbsp;<INPUT NAME="paycardprefix" TYPE="text" value="<?=date("Y")?>" size="15"></td>
  </tr>
  <tr>
    <td  align="right" class="tablerow">充值卡号码位数：</td>
    <td class="tablerow">&nbsp;<INPUT NAME="paycardlen" TYPE="text" value="10" size="15">
    &nbsp;(根据情况修改 最大15位)</td>
  </tr>
  <tr>
    <td  align="right" class="tablerow">充值卡密码位数：</td>
    <td class="tablerow">&nbsp;<INPUT NAME="passwordlen" TYPE="text" value="6" size="15">
    &nbsp;(根据情况修改 最大15位)</td>
  </tr>
  <tr>
    <td align="right" class="tablerow">充值截止日期：</td>
    <td class="tablerow">&nbsp;<script language=javascript>var dateFrom=new MyCalendar("enddate","<?=$enddate?>","选择,年,月,日,上一年,下一年,上个月,下个月,一,二,三,四,五,六"); dateFrom.display();</script>
	</td>
  </tr>
  <tr height="30">
    <td align="right" class="tablerow"></td>
    <td class="tablerow">&nbsp;<INPUT TYPE="submit" name="submit" value=" 产生充值卡 "> <INPUT TYPE="reset" name="reset" value=" 重置 "></td>
  </tr>
  </form>
</table>
</body>
</html>
