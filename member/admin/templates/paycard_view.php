<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script type="text/javascript" src="/cms/include/js/MyCalendar.js"></script>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<?=$menu?>
<table width='300' border='0' align='center' cellpadding='2' cellspacing='1' style='border: 1px solid #183789; BACKGROUND-COLOR: #ffffff;'>
    <tr>
      <td colspan='2' class="tablerowhighlight"  align='center' >本次生成的充值卡信息</td>
    </tr>
    <tr>
      <td width='50%' class="tablerow" align='right'>充值卡数量：</td>
      <td class="tablerow" ><?=$paycardnum?></td>
    </tr>
    <tr>
      <td class="tablerow" align='right'>充值卡面值：</td>
      <td class="tablerow" ><?=$paycardprice?> 元</td>
    </tr>
    <tr>
      <td class="tablerow" align='right'>充值截止日期：</td>
      <td class="tablerow" ><?=$enddate?></td>
    </tr>
</table>
<br>
<table width='300' border='0' align='center' cellpadding='2' cellspacing='1' style='border: 1px solid #183789; BACKGROUND-COLOR: #ffffff;'>
  <tr>
    <td width='150' height='22' align='center' class="tablerowhighlight" >卡 号</td>
    <td width='150' height='22' align='center' class="tablerowhighlight" >密 码</td>
  </tr>
<?php 
if(is_array($paycards)){
	foreach($paycards as $paycard){
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
    <td class="tablerow" ><?=$paycard[0]?></td>
    <td class="tablerow" ><?=$paycard[1]?></td>
  </tr>
<?php 
	}
}
?>
</table>
</body>
</html>
