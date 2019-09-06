<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="0" cellspacing="1" class="table_form">
<caption><?=$M['name']?>模块配置</caption>
<tr>
  <th width="25%"><strong>未付款订单自动关闭时间</strong></th>
  <td width="75%"><input type="text" name='setting[maxcloseday]' value="<?=$maxcloseday?$maxcloseday:'7'?>" size="5" maxlength="3"> 天</td>
</tr>
<tr>
  <th width="25%"><strong>每人最多能保存的收货地址数</strong></th>
  <td width="75%"><input type="text" name='setting[maxdelivers]' value="<?=$maxdelivers?$maxdelivers:'5'?>" size="3" maxlength="1"> 个</td>
</tr>
<tr>
    <th>&nbsp;</th>
    <td><input type="submit" name="dosubmit" value="确定">&nbsp;&nbsp;<input type="reset" name="reset" value="重置"></td>
</tr>
</table>
</form>
</body>
</html>