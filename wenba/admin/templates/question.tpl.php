<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage">问题管理首页</a> &gt;&gt; <?=$cat_pos?> </td>
    <td class="tablerow" align="right"><?php echo $category_jump; ?>
	</td>
  </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="10"> </td>
</tr>
</table>
<table width="100%" cellpadding="3" cellspacing="1" align="center" class="tableborder">
	<thead>
		<tr>
			<th colspan="9">问题管理</th>
		</tr>
	</thead>
	<tbody class="trbg1">
<?php
if (isset($all_queslist)) {
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
	if (objForm.qid.length) {
		for (var i = 0; i < objForm.qid.length; i++) {
			objForm.qid[i].checked = objForm.chkall.checked;
			selnum++;
		}
	} else {
		objForm.qid.checked = true;
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
			<td width="6%" align="center" valign="middle" class="tablerowhighlight">题号</td>
			<td width="37%" align="center" valign="middle" class="tablerowhighlight">标题</td>
			<td width="17%" align="center" valign="middle" class="tablerowhighlight">提问时间</td>
			<td width="8%" align="center" valign="middle" class="tablerowhighlight">悬赏</td>
			<td width="5%" align="center" valign="middle" class="tablerowhighlight">回答</td>
			<td width="6%" align="center" valign="middle" class="tablerowhighlight">点击</td>
			<td width="8%" align="center" valign="middle" class="tablerowhighlight">状态</td>
			<td width="8%" align="center" valign="middle" class="tablerowhighlight">管理</td>
		</tr><form action="<?php echo "?mod=$mod&file=$file&action=delete"; ?>" method="post" onsubmit="return frmchk();">
<?php
	foreach ($all_queslist as $all_ques) {
?>
		<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
			<td align="center" valign="middle"><input type="checkbox" name="qid[]" id="qid" value="<?=$all_ques['qid']; ?>" onclick="fnclick(this);"></td>
			<td align="center" valign="middle"><?=$all_ques['qid'];?></td>
			<td width="37%" align="left" valign="middle"><? if(!$catid) { ?>[<a href="<?=$CATEGORY[$all_ques['catid']]['linkurl']?>" target="_blank"><?=$CATEGORY[$all_ques['catid']]['catname']?></a>]<? } ?><a href="<?=PHPCMS_PATH.$MOD['moduledir']?>/question.php?qid=<?=$all_ques['qid']?>" target="_blank"><?=$all_ques['title']?></a><?php if($all_ques['elite']) {?>&nbsp;&nbsp;<font color="blue">荐</font><?}?></td>
			<td align="center" valign="middle"><?=$all_ques['asktime'];?></td>
			<td align="center" valign="middle"><?=$all_ques['score'];?></td>
			<td align="center" valign="middle"><?=$all_ques['answercount'];?></td>
			<td align="center" valign="middle"><?=$all_ques['hits'];?></td>
			<td align="center" valign="middle">
				<?php if($all_ques['status']==1)echo '<font color="#009900">待解决</font>';elseif($all_ques['status']==2) echo '<font color="#FF9900">已解决</font>';elseif($all_ques['status']==3) echo '<font color="#009900">投票中</font>';else echo '<font color="#6600FF">已关闭</font>';?>
			</td>
			<td width="8%" align="center" valign="middle"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?php if($all_ques['elite']) { ?>cancel<?php } else { ?>commend<?php }?>&dosubmit=1&qid=<?=$all_ques['qid']?>"><?php if($all_ques['elite']) { ?>取消<?php } else { ?>推荐<?php } ?></a>|<a href="?mod=<?=$mod?>&file=<?=$file?>&action=delete&dosubmit=1&qid=<?=$all_ques['qid']?>" title="删除" onclick="if(!delete_ques()) return false;">删除</a>
			</td>
		</tr>
<?php
	}
}
?>		
</tbody>
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
<div style="text-align:center"><?=$phpcmspage?></div>
<?php
}
?>
</form><br />
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th>问题查询</th>
  </tr>
  <form method="post" name="myform" action="?">
  <tr>
    <td align="center" class="tablerow">
		提问起始日期<?php echo date_select('search_fromdate', $search_fromdate); ?>
		至<?php echo date_select('search_todate', $search_todate); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		 
		<input type="submit" name="search" value="搜索全部的问题">
		</td>
  </tr>
  </form>
</table>
</body>
</html>