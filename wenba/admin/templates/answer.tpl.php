<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage">回答管理</a> &gt;&gt;  </td>
  </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="10"> </td>
</tr>
</table>
<table width="100%" cellpadding="3" cellspacing="1" align="center" class="tableborder">
<tr>
	<th colspan="8">问题答案列表</th>
</tr>
<?php
if (isset($answer_list)) {
?>
<script language="javascript" type="text/javascript">
<!--
var selnum = 0;
function frmchk() {
	if (!selnum) {
		alert("没有问题被选中！");
		return false;
	} else {
		return true;
	}
}
function checkall(objForm) {
	if (objForm.aid.length) {
		for (var i = 0; i < objForm.aid.length; i++) {
			objForm.aid[i].checked = objForm.chkall.checked;
			selnum++;
		}
	} else {
		objForm.aid.checked = true;
		selnum++;
	}
}
function fnclick(objBox) {
	if (objBox.checked) {
		selnum++;
	} else {
		selnum--;
		document.getElementById("chkall").checked = false;
	}
}

function delete_ques()
{
	if( !confirm("你确定要删除吗？"))
		return false;
	else
		return true;	
}
//-->
</script>
		<tr>
			<td width="5%" align="center" valign="middle" class="tablerowhighlight">选中</td>
			<td width="5%" align="center" valign="middle" class="tablerowhighlight">题号</td>
			<td width="40%" align="center" valign="middle" class="tablerowhighlight">概要</td>
			<td width="8%" align="center" valign="middle" class="tablerowhighlight">回答者</td>
			<td width="15%" align="center" valign="middle" class="tablerowhighlight">回答时间</td>
			<td width="8%" align="center" valign="middle" class="tablerowhighlight">采纳状态</td>
			<td width="8%" align="center" valign="middle" class="tablerowhighlight">管理操作</td>
		</tr><form action="<?php echo "?mod=$mod&file=$file&action=delete"; ?>" method="post" onsubmit="return frmchk();">
<?php
	foreach ($answer_list as $answer) {
?>
		<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
			<td align="center" valign="middle"><input type="checkbox" name="aid[]"  id="aid" value="<?php echo $answer['aid']; ?>" onclick="fnclick(this);"></td>
			<td align="center" valign="middle"><?php echo $answer['qid']; ?></a></td>
			<td align="left" valign="middle"><a href="<?php echo PHPCMS_PATH."$mod/question.php?qid={$answer['qid']}"; ?>" title="前台预览" target="_blank"><?php echo $answer['answer'];?></a></td>
			<td align="center" valign="middle"><?php echo $answer['username'];?></td>
			<td align="center" valign="middle"><?php echo $answer['answertime'];?></td>
			<td align="center" valign="middle"><?php if($answer['accept_status']==0)echo '未采纳'; else echo '已采纳';?></td>
			<td align="center" valign="middle"><a href="<?php echo "?mod=$mod&file=$file&action=delete&remove=1&dosubmit=1&aid={$answer['aid']}"; ?>" title="删除" onclick="if(!delete_ques()) return false;">删除</a>
			</td>
		</tr>
<?php
	}
}
?>		
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="100%" align="left" height="40" valign="middle" colspan="8"><input name='chkall' id="chkall" type='checkbox' onclick='checkall(this.form);' value='checkbox'>&nbsp;全部选中&nbsp;&nbsp;<input type="hidden" name="dosubmit" value="submitted">
		<input type="submit" name="remove" value="删除选定的问题"></td>
	</tr>
</table>
</form>
<?php
if ($total) {
?>
<div style="text-align:center"><?php echo $phpcmspage; ?></div>
<?php
}
?>
</form><br />
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th>答案查询</th>
  </tr>
  <form method="post" name="myform">
  <tr>
    <td align="center" class="tablerow">
		题号：<input type="text" name="qid" size="10" value="<?=$qid?>">
		回答者：<input type="text" name="username" size="10" value="<?=$username?>">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		 
		<input type="submit" name="search" value="搜索答案">
		</td>
  </tr>
  </form>
</table>
</body>
</html>