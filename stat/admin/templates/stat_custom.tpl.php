<?php
defined('IN_PHPCMS') or exit('Access Denied');
?>
<script language="javascript" type="text/javascript">
<!--
function searchChk() {
	if (document.getElementById("search").value == "" || document.getElementById("search").value == "请输入查询内容") {
		alert("请输入查询内容");
		document.getElementById("search").focus();
		return false;
	} else if (document.getElementById("stype").selectedIndex == 0) {
		alert("请选择查询类型");
		return false;
	} else {
		return true;
	}
}
function delOnce() {
	if (document.getElementById("history").selectedIndex == 0) {
		return false;
	} else {
		return true;
	}
}
function delAll() {
	if (document.getElementById("history").options.length > 1) {
		if (window.confirm("您确定要清除所有历史查询记录?")) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}
//-->
</script>
	<tbody class="trbg1">
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';"><form action="<?php echo $PHP_SELF; ?>" method="get" onsubmit="return searchChk();" style="text-align:center">
			<td width="95%" align="center" valign="middle"><input type="hidden" name="mod" value="<?php echo $mod; ?>"><input type="hidden" name="file" value="<?php echo $file; ?>"><input type="hidden" name="action" value="<?php echo $action; ?>"><input id="search" type="text" name="search" value="<?php if (isset($search)) {echo $search;} else {echo '请输入查询内容';} ?>" size="15" onclick="this.value='';">&nbsp;<select id="stype" name="stype">
			<option>查询类型</option>
			<option value="rdomain">网站域名</option>
			<option value="keyword">搜索关键词</option>
			<option value="filen">文件名</option>
		</select>&nbsp;开始日期：<?php echo date_select('fdate', $fdate); ?>
&nbsp;&nbsp;&nbsp;&nbsp;截止日期：<?php echo date_select('ldate', $ldate); ?>&nbsp;&nbsp;<input type="submit" name="dosubmit" value="确 定"></td>
			<td width="5%" align="right" valign="middle"><input id="saveBtn" type="button" value="保存结果" onclick="window.location.replace('<?php echo $_SERVER['REQUEST_URI'] . "&save=1"; ?>');" style="display:none"></td></form>
		</tr>
<?php
if (isset($resault)) {
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';"><form action="<?php echo $curUri; ?>" method="post">
			<td width="100%" align="center" valign="middle" colspan="2"><select id="history" name="history" onchange="window.location.replace(this.value);"><option>历史查询</option>
<?php
for ($i = 0; $i < count($resault); $i++) {
	echo "<option value='{$resault[$i][1]}'";
	if ($uri == $resault[$i][1]) {
		echo " selected";
	}
	echo ">{$resault[$i][0]}</option>";
}
?>
			</select>&nbsp;<input type="submit" name="delone" value="删 除" onclick="return delOnce();">&nbsp;<input type="submit" name="delall" value="清除全部" onclick="return delAll();"></span></td></form>
		</tr>
<?php
}
if (isset($search) && isset($stype)) {
?>
<script language="javascript" type="text/javascript">
<!--
var objSelect = document.getElementById("stype");
for (var i = 1; i < objSelect.options.length; i++) {
	if (objSelect.options[i].value == "<?php echo $stype; ?>") {
		objSelect.options[i].selected = true;
	}
}
if (document.getElementById("history")) {
	objSelect = document.getElementById("history");
	for (var i = 1; i < objSelect.options.length; i++) {
		if (objSelect.options[i].text == "<?php echo $search; ?>") {
			objSelect.options[i].selected = true;
			var saved = 1;
			break;
		}
	}
	if (!saved) {
		document.getElementById("saveBtn").style.display = "block";
	} else {
		document.getElementById("saveBtn").style.display = "none";
	}
} else {
<?php
if ($record > 0) {
	echo 'document.getElementById("saveBtn").style.display="block";';
} else {
	echo 'document.getElementById("saveBtn").style.display="none";';
}
?>
}
//-->
</script>
<?php
if ($record > 0) {
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="100%" align="center" valign="middle" colspan="2"><ul style="margin:0px">
				<li style="float:left;margin-left:10px">&there4;&nbsp;点击序号--查看访客详细信息</li>
				<li style="float:right;margin-right:10px">&there4;&nbsp;点击IP地址--查看使用此IP的用户的所有访问记录</li>
			</ul></td>
		</tr>
<?php
	for ($i = 0; $i < count($query); $i++) {
?>
		<tr>
			<td width="100%" align="center" valign="middle" colspan="2"><table width="100%" cellpadding="3" cellspacing="1" align="center" class="tableborder">
				<tbody class="trbg1">
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
						<td width="6%" align="center" valign="middle">序号</td>
						<td width="8%" align="right" valign="middle">进入时间:</td>
						<td width="18%" align="center" valign="middle"><?php echo $query[$i][2]; ?></td>
						<td width="8%" align="center" valign="middle">停留时间:</td>
						<td width="15%" align="center" valign="middle"><?php echo $stay[$i]; ?></td>
						<td width="8%" align="center" valign="middle">IP地址:</td>
						<td width="17%" align="center" valign="middle"><a href="javascript:<?php echo "?mod=$mod&file=$file&action=track&ip={$query[$i][1]}"; ?>" target="_self"  title="查看该IP地址的所有访问记录"><?php echo $query[$i][1]; ?></a></td>
						<td width="8%" align="center" valign="middle">地理位置:</td>
						<td width="12%" align="left" valign="middle"><?php echo $query[$i][5]; ?></td>
					</tr>
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
						<td width="6%" align="center" valign="middle" rowspan="3"><a href="<?php echo "?mod=$mod&file=$file&action=track&id={$query[$i][0]}"; ?>" target="_self" title="查看访客详细信息"><?php echo intval(($curPage - 1) * $pageSize + $i + 1);if ($query[$i][4] == 1) {echo "<div style='text-align:center;color:#ff0000'>在线</div>";	} ?></a></td>
						<td width="8%" align="right" valign="middle">来路URL:</td>
						<td width="86%" align="left" valign="middle" colspan="7"><?php if (preg_match("/^http:\/\/([^\/]+)/i", $query[$i][6])) {echo "<a href='{$query[$i][6]}' target='_blank'>{$query[$i][6]}</a>";} else {echo $query[$i][6];} ?></td>
					</tr>
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
						<td width="8%" align="right" valign="middle">关 键 词:</td>
						<td width="66%" align="left" valign="middle" colspan="5"><?php echo $query[$i][8]; ?></td>
						<td width="8%" align="center" valign="middle">搜索引擎:</td>
						<td width="12%" align="left" valign="middle"><?php echo getEngine($query[$i][7]); ?></td>
					</tr>
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
						<td width="8%" align="right" valign="middle">受访页面:</td>
						<td width="86%" align="left" valign="middle" colspan="7"><?php echo $query[$i][9]; ?></td>
					</tr>
				</tbody>
			</table></td>
		</tr>
<?php
	}
	$curUri = $_SERVER['REQUEST_URI'];
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
<?php
	if ($pageCount > 1) {
		$first = "$curUri&page=1";
		$last = "$curUri&page=" . intval($curPage - 1);
		$next = "$curUri&page=" . intval($curPage + 1);
		$end = "$curUri&page=$pageCount";
?>
			<td width="100%" align="center" valign="middle" colspan="2"><table width="100%" cellpadding="3" cellspacing="1" align="center" class="tableborder">
				<tbody class="trbg1">
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
						<td width="35%" align="left" valign="middle" style="padding-left:5px">共<?php echo "{$record}条记录&nbsp;第{$curPage}/{$pageCount}页&nbsp;{$pageSize}"; ?>条记录/页</td>
						<td width="30%" align="center" valign="middle">
<?php
	if ($curPage != 1) {
		echo "<a href='$first' target='_self'>首&nbsp;页&nbsp;</a>";
	}
	if ($curPage > 2) {
		echo "<a href='$last' target='_self'>上一页&nbsp;</a>";
	}
	if ($curPage < $pageCount - 1) {
		echo "&nbsp;<a href='$next' target='_self'>下一页</a>";
	}
	if ($curPage != $pageCount) {
		echo "&nbsp;<a href='$end' target='_self'>尾&nbsp;页</a>";
	}
?>
						</td>
						<td width="35%" align="right" valign="middle" style="padding-right:10px"><select onchange="window.location=this.value;">
<?php
	for ($i = 1; $i <= $pageCount; $i++) {
		echo "<option value='${curUri}&page=${i}'";
		if ($i == $curPage) {
			echo " selected";
		}
		echo ">第${i}页</option>";
	}
?>
						</select></td>
					</tr>
				</tbody>
			</table></td>
<?php
	} else {
?>
			<td width="100%" align="right" valign="middle" colspan="2" style="padding-right:10px">共<?php echo "{$record}条记录&nbsp;第{$curPage}/{$pageCount}页&nbsp;{$pageSize}"; ?>条记录/页</td>
<?php
	}
?>
		</tr>
<?php
} else {
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="100%" align="center" valign="middle" colspan="2">暂无相关记录</td>
		</tr>
<?php
}
}
?>
	</tbody>
</table>
</body>
</html>