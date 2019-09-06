<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=6>本期结算信息</th>
  </tr>
<tr align="center">
<td class="tablerowhighlight">用户名</td>
<td class="tablerowhighlight">本期用户消费金额</td>
<td class="tablerowhighlight">利润率</td>
<td class="tablerowhighlight">本期结算金额</td>
<td class="tablerowhighlight">支付宝帐号</td>
<td class="tablerowhighlight">操作</td>
</tr>
<form method="post" name="myform">
<tr align="center">
<td class="tablerow" width="15%"><?=$username?></td>
<td class="tablerow" width="17%"><?=$settleexpendamount?>元</td>
<td class="tablerow" width="10%"><?=$profitmargin?>%</td>
<td class="tablerow" width="13%"><font color="red"><?=$settleamount?>元</font></td>
<td class="tablerow" width="30%"><?=$alipay?></td>
<td class="tablerow" width="15%">
<input type="hidden" name="settleexpendamount" value="<?=$settleexpendamount?>">
<input type="hidden" name="profitmargin" value="<?=$profitmargin?>">
<input type="hidden" name="alipay" value="<?=$alipay?>">
<input type="submit" name="dosubmit" value="确认结算">
</td>
</tr>
</form>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=4>用户详细信息</th>
  </tr>
<tr>
<td colspan=2 align="center" class="tablerowhighlight">统计信息</td>
<td colspan=2 align="center" class="tablerowhighlight">用户资料</td>
</tr>
<tr>
<td class="tablerow" width="20%">来访次数</td>
<td class="tablerow" width="20%"><?=$visits?> 次</td>
<td class="tablerow" width="20%">用户名</td>
<td class="tablerow" width="40%"><?=$username?></td>
</tr>
<tr>
<td class="tablerow">注册用户数</td>
<td class="tablerow"><?=$registers?> 个</td>
<td class="tablerow">姓名</td>
<td class="tablerow"><?=$truename?></td>
</tr>
<tr>
<td class="tablerow">用户消费总额</td>
<td class="tablerow"><?=$allexpendamount?> 元</td>
<td class="tablerow">支付宝帐号</td>
<td class="tablerow"><font color="red"><?=$alipay?></font></td>
</tr>
<tr>
<td class="tablerow">已结算用户消费总额</td>
<td class="tablerow"><?=$totalexpendamount?> 元</td>
<td class="tablerow">电话</td>
<td class="tablerow"><?=$telephone?></td>
</tr>
<tr>
<td class="tablerow">已结算总额</td>
<td class="tablerow"><?=$totalpayamount?> 元</td>
<td class="tablerow">手机</td>
<td class="tablerow"><?=$mobile?></td>
</tr>
<tr>
<td class="tablerow">本期用户消费总额</td>
<td class="tablerow"><?=$settleexpendamount?> 元</td>
<td class="tablerow">E-MAIL</td>
<td class="tablerow"><?=$email?></td>
</tr>
<tr>
<td class="tablerow">本期应结算金额</td>
<td class="tablerow"><?=$settleamount?> 元</td>
<td class="tablerow">QQ</td>
<td class="tablerow"><?=$qq?></td>
</tr>
<tr>
<td class="tablerow">本期利润率</td>
<td class="tablerow"><?=$profitmargin?>%</td>
<td class="tablerow">MSN</td>
<td class="tablerow"><?=$msn?></td>
</tr>
<tr>
<td class="tablerow">上期结算金额</td>
<td class="tablerow"><?=$lastpayamount?> 元</td>
<td class="tablerow">地址</td>
<td class="tablerow"><?=$address?>（<?=$postid?>）</td>
</tr>
<tr>
<td class="tablerow">上期结算时间</td>
<td class="tablerow"><?=$lastpaydate?></td>
<td class="tablerow">上次登录时间</td>
<td class="tablerow"><?=$lastlogintime?></td>
</tr>
</table>
</body>
</html>