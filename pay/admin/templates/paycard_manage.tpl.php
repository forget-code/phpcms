<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<form method="post" name="myform">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=11>支付卡列表</th>
  </tr>
<tr align="center">
<td width="5%" class="tablerowhighlight">选中</td>
<td width="14%" class="tablerowhighlight">卡号</td>
<td width="9%" class="tablerowhighlight">密码</td>
<td width="6%" class="tablerowhighlight">面值</td>
<td width="10%" class="tablerowhighlight">开始日期</td>
<td width="10%" class="tablerowhighlight">截止日期</td>
<td width="6%" class="tablerowhighlight">状态</td>
<td width="10%" class="tablerowhighlight">使用者</td>
<td width="18%" class="tablerowhighlight">充值时间</td>
<td width="12%" class="tablerowhighlight">充值IP</td>
</tr>
<?php 
if(is_array($paycards))
{
foreach($paycards as $paycard){ ?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input type="checkbox" name="id[]"  id="id[]" value="<?=$paycard['id']?>"></td>
<td><?=$paycard['cardid']?></td>
<td><?=$paycard['password']?></td>
<td><?=$paycard['price']?></td>
<td><?=$paycard['adddate']?></td>
<td><?=$paycard['enddate']?></td>
<td><?=$paycard['status']?></td>
<td><a href="?mod=member&file=member&action=view&username=<?=urlencode($paycard['username'])?>"><?=$paycard['username']?></a></td>
<td><?=$paycard['regtime']?></td>
<td><?=$paycard['regip']?></td>
</tr>
<?php } 
}
?>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全选/反选</td>
    <td>
<input type="submit" name="submit" value=" 删除选定的卡号 " onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete'">&nbsp;&nbsp;
<input type="submit" name="submit" value=" 删除所有过期卡号 " onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=deletetimeout'">&nbsp;&nbsp;
<input type="submit" name="submit" value=" 删除所有已使用的卡号 " onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=deleteused'">&nbsp;&nbsp;

    </td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td align="center"><?=$pages?></td>
  </tr>
</table>
</form>
</body>
</html>
