<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=8>推广联盟用户查询</th>
  </tr>
  <form method="get" name="search">
  <tr>
    <td align="center" class="tablerow">
	<input type="hidden" name="mod" value="<?=$mod?>">
	<input type="hidden" name="file" value="<?=$file?>">
	<input type="hidden" name="page" value="<?=$page?>">
         用户名：<input type="text" name="username" size="15" value="<?=$username?>">&nbsp;&nbsp;
	     锁定：<input type='radio' name='passed' value='0' <?=($passed == 0 ? 'checked' : '')?>> 是&nbsp;&nbsp; 
		<input type='radio' name='passed' value='1' <?=($passed == 1 ? 'checked' : '')?>> 否 &nbsp;&nbsp; 
		 <select name="ordertype">
		 <option value="settleexpendamount">选择排序方式</option>
		 <option value="settleexpendamount" <?php if($ordertype == 'settleexpendamount'){?>selected<?php } ?>>本期用户消费金额</option>
		 <option value="totalpayamount" <?php if($ordertype == 'totalpayamount'){?>selected<?php } ?>>已结算总金额</option>
		 <option value="visits" <?php if($ordertype == 'visits'){?>selected<?php } ?>>访问IP数</option>
		 <option value="registers" <?php if($ordertype == 'register'){?>selected<?php } ?>>注册用户数</option>
		 <option value="regtime" <?php if($ordertype == 'regtime'){?>selected<?php } ?>>加入时间</option>
		 </select>
		 <input type="submit" name="search" value=" 查询 "></td>
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
    <th colspan=10>推广联盟用户管理</th>
  </tr>
<form method="post" name="myform">
<tr align="center">
<td width="5%" class="tablerowhighlight">选中</td>
<td width="12%" class="tablerowhighlight">用户名</td>
<td width="9%" class="tablerowhighlight">本期消费</td>
<td width="6%" class="tablerowhighlight">利润率</td>
<td width="9%"  class="tablerowhighlight">本期结算</td>
<td width="6%"  class="tablerowhighlight">IP数</td>
<td width="6%"  class="tablerowhighlight">注册数</td>
<td width="25%"  class="tablerowhighlight">主页</td>
<td width="12%"  class="tablerowhighlight">加入日期</td>
<td width="*"  class="tablerowhighlight">操作</td>
</tr>
<?php
if(is_array($users)) 
{
foreach($users AS $user) {
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input type="checkbox" name="userid[]"  id="userid[]" value="<?=$user['userid']?>"></td>
<td><a href="?mod=member&file=member&action=view&userid=<?=$user['userid']?>"><?=$user['username']?></a></td>
<td><?=$user['settleexpendamount']?>元</td>
<td><?=$user['profitmargin']?>%</td>
<td <?=($user['settleamount'] ? 'style="color:red"' : '')?>><?=$user['settleamount']?>元</td>
<td><a href="?mod=union&file=visit&userid=<?=$user['userid']?>"><?=$user['visits']?>次</a></td>
<td><a href="?mod=union&file=reguser&userid=<?=$user['userid']?>"><?=$user['registers']?>个</a></td>
<td><a href="<?=$user['homepage']?>" target="_blank" title="<?=$user['homepage']?>"><?=str_cut(str_replace('http://', '', $user['homepage']), 30)?></a></td>
<td><?=$user['regdate']?></td>
<td><a href="?mod=<?=$mod?>&file=settle&userid=<?=$user['userid']?>">结算</a> | <?php if($user['passed']){ ?><a href="?mod=<?=$mod?>&file=edit&userid=<?=$user['userid']?>" title="修改利润率">修改</a><?php }else{ ?><a href="?mod=<?=$mod?>&file=pass&userid=<?=$user['userid']?>&passed=1">解锁</a><?php } ?></td>
</tr>
<?php
	}
}
?>

</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全部选中</td>
    <td>
		<input name="submit1" type="submit"  value="删除帐号" onClick="document.myform.action='?mod=<?=$mod?>&file=delete&action=user'">&nbsp;&nbsp;
    </td>
  </tr>
</table>
</form>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td height="20" align="center"><?=$pages?></td>
  </tr>
</table>

</body>
</html>