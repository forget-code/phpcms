<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<?=$menu?>
<table cellpadding='2' cellspacing='1' border='0' align='center' class='tableBorder'>
  <tr>
    <td class='pagemenu' align="center">
	<a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" class='pagelink'>所有记录</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&type=汇款入帐" class='pagelink'>汇款入帐</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&type=退款出帐" class='pagelink'>退款出帐</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&type=退款入帐" class='pagelink'>退款入帐</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&type=业务扣款" class='pagelink'>业务扣款</a> | 
	</td>
  </tr>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<form method="post" name="myform">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=11>财务流水</th>
  </tr>
<tr align=center>
<td width="5%" class="tablerowhighlight">选中</td>
<td width="4%" class="tablerowhighlight">ID</td>
<td width="10%" class="tablerowhighlight">操作类型</td>
<td width="10%" class="tablerowhighlight">用户名</td>
<td width="5%" class="tablerowhighlight">金额</td>
<td width="11%" class="tablerowhighlight">银行</td>
<td width="11%" class="tablerowhighlight">凭证</td>
<td width="15%" class="tablerowhighlight">备注</td>
<td width="9%" class="tablerowhighlight">操作人</td>
<td width="10%" class="tablerowhighlight">时间</td>
</tr>
<?php 
if(is_array($finances))
{
foreach($finances as $finance){ ?>
<tr align=center onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td class=forumrow><input type="checkbox" name="financeid[]"  id="financeid[]" value="<?=$finance[financeid]?>"></td>
<td class=forumrow><?=$finance[financeid]?></td>
<td class=forumrow><?=$finance[type]?></td>
<td class=forumrow><a href="" target="_blank"><?=$finance[username]?></a></td>
<td class=forumrow><?=$finance[money]?>元</td>
<td class=forumrow><?=$finance[bank]?></td>
<td class=forumrow><?=$finance[idcard]?></td>
<td class=forumrow><?=$finance[note]?></td>
<td class=forumrow><?=$finance[inputer]?></td>
<td class=forumrow><?=$finance[addtime]?></td>
</tr>
<?php } 
}
?>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全选/反选</td>
    <td>
<input type="submit" name="submit" value="批量删除" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete'">&nbsp;&nbsp;
</td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td align="center"><?=$pages?></td>
  </tr>
</table>
</form>

<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=7>财务搜索</th>
  </tr>
<tr align="center">
<td width="12%" class="tablerowhighlight">类型</td>
<td width="18%" class="tablerowhighlight">金额范围</td>
<td width="15%" class="tablerowhighlight">起始日期</td>
<td width="15%" class="tablerowhighlight">截止日期</td>
<td width="15%" class="tablerowhighlight">查询类型</td>
<td width="15%" class="tablerowhighlight">关键词</td>
<td width="10%" class="tablerowhighlight">查询</td>
</tr>
	<form method="get" action="?">
  <tr align="center">
    <td class="tablerow">
	<input name="mod" type="hidden" size="15" value="<?=$mod?>">
	<input name="file" type="hidden" size="15" value="<?=$file?>">
	<input name="action" type="hidden" size="15" value="<?=$action?>">
<select name="type">
<option value='汇款入帐'>汇款入帐</option>
<option value='退款出帐'>退款出帐</option>
<option value='退款入帐'>退款入帐</option>
<option value='业务扣款'>业务扣款</option>
</select>
	</td>
    <td class="tablerow">
	<input name="frommoney" size="5" value="<?=$frommoney?>">元 - <input name="tomoney" size="5" value="<?=$tomoney?>">元
	</td>
    <td class="tablerow">
	<input name="fromdate" size="10" value="<?=$fromdate?>">
	</td>
    <td class="tablerow">
	<input name="todate" size="10" value="<?=$todate?>">
	</td>
    <td class="tablerow">
<select name="searchtype">
<option value='username' <?php if($searchtype=='username'){ ?>selected <?php } ?>>按用户名</option>
<option value='inputer' <?php if($searchtype=='inputer'){ ?>selected <?php } ?>>按操作人</option>
<option value='bank' <?php if($searchtype=='bank'){ ?>selected <?php } ?>>按银行</option>
<option value='idcard' <?php if($searchtype=='idcard'){ ?>selected <?php } ?>>按凭证</option>
<option value='note' <?php if($searchtype=='note'){ ?>selected <?php } ?>>按备注</option>
</select>
	</td>
    <td class="tablerow">
	<input name="keywords" size="15" value="<?=$keywords?>">
	</td>
    <td class="tablerow">
	<input type="submit" value=" 查询 ">
	</td>
  </tr>
	</form>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=8>财务统计</th>
  </tr>
  <tr>
    <td class="tablerowhighlight" align="center" width="12%">汇款入帐</td>
    <td class="tablerow"><?=${md5("汇款入帐")}?>元</td>
	<td class="tablerowhighlight" align="center" width="12%">退款出帐</td>
	<td class="tablerow"><?=${md5("退款出帐")}?>元</td>
    <td class="tablerowhighlight" align="center" width="12%">退款入帐</td>
    <td class="tablerow"><?=${md5("退款入帐")}?>元</td>
	<td class="tablerowhighlight" align="center" width="12%">业务扣款</td>
	<td class="tablerow"><?=${md5("业务扣款")}?>元</td>
  </tr>
</table>
</body>
</html>
