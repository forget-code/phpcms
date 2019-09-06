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
	<a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" class='pagelink'>所有记录</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&type=资金换点数" class='pagelink'>资金换点数</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&type=积分换点数" class='pagelink'>积分换点数</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&type=赠送点数" class='pagelink'>赠送点数</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&type=消费扣点" class='pagelink'>消费扣点</a>
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
    <th colspan=11>点数兑换管理</th>
  </tr>
<tr align=center>
<td width="5%" class="tablerowhighlight">选中</td>
<td width="8%" class="tablerowhighlight">ID</td>
<td width="12%" class="tablerowhighlight">操作类型</td>
<td width="11%" class="tablerowhighlight">用户名</td>
<td width="13%" class="tablerowhighlight">金额/积分</td>
<td width="10%" class="tablerowhighlight">点数/天</td>
<td width="20%" class="tablerowhighlight">备注</td>
<td width="11%" class="tablerowhighlight">操作人</td>
<td width="10%" class="tablerowhighlight">时间</td>
</tr>
<?php 
if(is_array($exchanges))
{
foreach($exchanges as $exchange){ ?>
<tr align=center onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td class=forumrow><input type="checkbox" name="exchangeid[]"  id="pointid[]" value="<?=$exchange[exchangeid]?>"></td>
<td class=forumrow><?=$exchange[exchangeid]?></td>
<td class=forumrow><?=$exchange[type]?></td>
<td class=forumrow><a href="<?=PHPCMS_PATH?>member/member.php?username=<?=urlencode($exchange[username])?>" target="_blank"><?=$exchange[username]?></a></td>
<td class=forumrow><?=$exchange[payment]?></td>
<td class=forumrow><?=$exchange[exchange]?></td>
<td class=forumrow><?=$exchange[note]?></td>
<td class=forumrow><a href="<?=PHPCMS_PATH?>member/member.php?username=<?=urlencode($exchange[inputer])?>" target="_blank"><?=$exchange[inputer]?></a></td>
<td class=forumrow><?=$exchange[addtime]?></td>
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
    <th colspan=7>点数兑换搜索</th>
  </tr>
<tr align="center">
<td width="12%" class="tablerowhighlight">类型</td>
<td width="18%" class="tablerowhighlight">点数范围</td>
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
<option value='资金换点数' <?php if($type=="资金换点数"){ ?>selected <?php } ?>>资金换点数</option>
<option value='积分换点数' <?php if($type=="积分换点数"){ ?>selected <?php } ?>>积分换点数</option>
<option value='赠送点数' <?php if($type=="赠送点数"){ ?>selected <?php } ?>>赠送点数</option>
<option value='消费扣点' <?php if($type=="消费扣点"){ ?>selected <?php } ?>>消费扣点</option>
</select>
	</td>
    <td class="tablerow">
	<input name="frompoint" size="5" value="<?=$frompoint?>">点 - <input name="topoint" size="5" value="<?=$topoint?>">点
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
    <th colspan=8>点数兑换统计</th>
  </tr>
  <tr>
    <td class="tablerowhighlight" align="center" width="12%">资金换点数</td>
    <td class="tablerow"><?=${md5("资金换点数")}?>点</td>
	<td class="tablerowhighlight" align="center" width="12%">积分换点数</td>
	<td class="tablerow"><?=${md5("积分换点数")}?>点</td>
    <td class="tablerowhighlight" align="center" width="12%">赠送点数</td>
    <td class="tablerow"><?=${md5("赠送点数")}?>点</td>
	<td class="tablerowhighlight" align="center" width="12%">消费扣点</td>
	<td class="tablerow"><?=${md5("消费扣点")}?>点</td>
  </tr>
</table>
</body>
</html>
