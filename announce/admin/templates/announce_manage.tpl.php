<?php
defined('IN_PHPCMS') or exit('Access Denied');
echo "$menu<div style='text-align:left'>当前位置：$curpos</div>";
?>
<table width="100%" cellpadding="3" cellspacing="1" align="center" class="tableborder">
	<thead>
		<tr>
			<th colspan="8"><?php echo $title; ?></th>
		</tr>
	</thead>
	<tbody class="trbg1">
<?php
if (isset($resailt)) {
?>
<script language="javascript" type="text/javascript">
<!--
var selnum = 0;
function frmchk() {
	if (!selnum) {
		alert("没有公告被选中！");
		return false;
	} else {
		return true;
	}
}
function checkall(objForm) {
	if (objForm.announceid.length) {
		for (var i = 0; i < objForm.announceid.length; i++) {
			objForm.announceid[i].checked = true;
			selnum++;
		}
	} else {
		objForm.announceid.checked = true;
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
//-->
</script>
		<tr>
			<td width="5%" align="center" valign="middle" class="tablerowhighlight">选中</td>
			<td width="25%" align="center" valign="middle" class="tablerowhighlight">标题</td>
			<td width="10%" align="center" valign="middle" class="tablerowhighlight">开始时间</td>
			<td width="10%" align="center" valign="middle" class="tablerowhighlight">结束时间</td>
			<td width="10%" align="center" valign="middle" class="tablerowhighlight">作者</td>
			<td width="9%" align="center" valign="middle" class="tablerowhighlight">浏览次数</td>
			<td width="18%" align="center" valign="middle" class="tablerowhighlight">发表时间</td>
			<td width="13%" align="center" valign="middle" class="tablerowhighlight">管理操作</td>
		</tr><form action="<?php echo $curUri; ?>" method="post" onsubmit="return frmchk();">
<?php
	for ($i = 0; $i < count($resailt); $i++) {
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="5%" align="center" valign="middle"><input type="checkbox" name="announceid[]"  id="announceid" value="<?php echo $resailt[$i][0]; ?>" onclick="fnclick(this);"></td>
			<td width="25%" align="left" valign="middle"><a href="<?php echo "?mod=$mod&file=$file&action=view&keyid=$keyid&announceid={$resailt[$i][0]}&referer=".urlencode($referer); ?>" title="后台预览"><?php echo $resailt[$i][1]; ?></a></td>
			<td width="10%" align="center" valign="middle"><?php echo $resailt[$i][3]; ?></td>
			<td width="10%" align="center" valign="middle"><?php echo $resailt[$i][4]; ?></td>
			<td width="10%" align="center" valign="middle"><?php echo $resailt[$i][5]; ?></td>
			<td width="9%" align="center" valign="middle"><?php echo $resailt[$i][2]; ?></td>
			<td width="18%" align="center" valign="middle"><?php echo $resailt[$i][6]; ?></td>
			<td width="13%" align="center" valign="middle"><a href="<?php echo PHPCMS_PATH."$mod/?announceid={$resailt[$i][0]}"; ?>" title="前台预览"  target="_blank">前台</a> | <a href="<?php echo "?mod=$mod&file=$file&action=edit&passed=$passed&keyid=$keyid&announceid={$resailt[$i][0]}"; ?>" title="修改">修改</a></td>
		</tr>
<?php
	}
?>
		<tr>
			<td width="100%" align="center" height="40" valign="middle" colspan="8"><input name='chkall' id="chkall" type='checkbox' onclick='checkall(this.form);' value='checkbox'>&nbsp;全部选中&nbsp;&nbsp;<input type="hidden" name="dosubmit" value="submitted">
<?php
if (isset($passed)) {
	if (!$passed) {
?>
<input type="submit" name="approve" value="批准选定的公告">&nbsp;&nbsp;
<?php
	} else {
?>
<input type="submit" name="cancel" value="取消批准选定的公告" >&nbsp;&nbsp;
<?php
	}
}
?>
<input type="submit" name="remove" value="删除选定的公告"></td>
		</tr></form>
<?php
} else {
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="100%" align="center" valign="middle">暂无相关记录</td>
		</tr>
<?php
}
?>
	</tbody>
</table>
<?php
if ($total) {
?>
<div style="text-align:center"><?php echo phppages($total, $page, $pagesize); ?></div>
<?php
}
?>
</body>
</html>