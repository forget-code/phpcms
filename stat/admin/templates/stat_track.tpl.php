<?php
defined('IN_PHPCMS') or exit('Access Denied');
?>
<script language="javascript" type="text/javascript">
<!--
function trackIp() {
	var strIp = document.getElementById("ipLocation").value;
	var regIp = new RegExp("^([0-9]{1,3}.){3,5}[0-9]{1,3}$","gi");
	if (strIp == "") {
		alert("请输入IP地址!");
		document.getElementById("ipLocation").focus();
		return false;
	} else if (regIp.exec(strIp) == null) {
		alert("无效的IP地址!");
		document.getElementById("ipLocation").value = "";
		document.getElementById("ipLocation").focus();
		return false;
	} else {
		window.location.replace("<?php echo $curUri; ?>&ip=" + strIp);
	}
}
//-->
</script>
	<tbody class="trbg1">
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="100%" align="center" valign="middle">请输入IP地址：<input id="ipLocation" type="text" name="ipLocation" size="15" value="<?php if (isset($ip)) {echo $ip;} elseif (isset($row['ip'])) {echo $row['ip'];} ?>" onfocus="this.select();" style="text-align:center">&nbsp;&nbsp;<input type="button" value="搜 索" onclick="trackIp();"></td>
		</tr>
<?php
if (isset($ip)) {
	if ($record > 0) {
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="100%" align="left" valign="middle">&there4;&nbsp;点击序号--查看访客详细信息</td>
		</tr>
<?php
		for ($i = 0; $i < count($resault); $i++) {
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="100%" align="center" valign="middle"><table width="100%" cellpadding="3" cellspacing="1" align="center" class="tableborder">
				<tbody class="trbg1">
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
						<td width="6%" align="center" valign="middle">序号</td>
						<td width="8%" align="right" valign="middle">进入时间:</td>
						<td width="18%" align="center" valign="middle"><?php echo $resault[$i][1]; ?></td>
						<td width="8%" align="right" valign="middle">离开时间:</td>
						<td width="18%" align="center" valign="middle"><?php if ($resault[$i][4]) {echo '&nbsp;';} else {echo $resault[$i][2];} ?></td>
						<td width="8%" align="center" valign="middle">停留时间:</td>
						<td width="15%" align="center" valign="middle"><?php echo $stay[$i]; ?></td>
						<td width="8%" align="center" valign="middle">地理位置:</td>
						<td width="11%" align="left" valign="middle"><?php echo $resault[$i][5]; ?></td>
					</tr>
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
						<td width="6%" align="center" valign="middle" rowspan="3"><a href="<?php echo "$curUri&id={$resault[$i][0]}"; ?>" target="_self" title="查看访客详细信息"><?php	echo intval(($curPage - 1) * $pageSize + $i + 1);if ($resault[$i][4] == 1) {echo "<div style='text-align:center;color:#ff0000'>在线</div>";	} ?></a></td>
						<td width="8%" align="right" valign="middle">来路URL:</td>
						<td width="86%" align="left" valign="middle" colspan="7"><?php if (preg_match("/^http:\/\/([^\/]+)/i", $resault[$i][6])) {echo "<a href='{$resault[$i][6]}' target='_blank'>{$resault[$i][6]}</a>";} else {echo $resault[$i][6];} ?></td>
					</tr>
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
						<td width="8%" align="right" valign="middle">关 键 词:</td>
						<td width="67%" align="left" valign="middle" colspan="5"><?php echo $resault[$i][8]; ?></td>
						<td width="8%" align="center" valign="middle">搜索引擎:</td>
						<td width="11%" align="left" valign="middle"><?php echo getEngine($resault[$i][7]); ?></td>
					</tr>
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
						<td width="8%" align="right" valign="middle">受访页面:</td>
						<td width="86%" align="left" valign="middle" colspan="7"><?php echo $resault[$i][9]; ?></td>
					</tr>
				</tbody>
			</table></td>
		</tr>
<?php
		}
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
<?php
if ($pageCount > 1) {
	$first = "$curUri&page=1";
	$last = "$curUri&page=" . intval($curPage - 1);
	$next = "$curUri&page=" . intval($curPage + 1);
	$end = "$curUri&page=$pageCount";
?>
			<td width="100%" align="center" valign="middle"><table width="100%" cellpadding="3" cellspacing="1" align="center" class="tableborder">
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
			<td width="100%" align="right" valign="middle" style="padding-right:10px">共<?php echo "{$record}条记录&nbsp;第{$curPage}/{$pageCount}页&nbsp;{$pageSize}"; ?>条记录/页</td>
<?php
}
?>
		</tr>
<?php
	} else {
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="100%" align="center" valign="middle">暂无相关记录</td>
		</tr>
<?php
	}
} elseif (isset($id) && intval($id) > 0) {
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="100%" align="center" valign="middle"><table width="100%" cellpadding="3" cellspacing="1" align="center" class="tableborder">
				<tbody class="trbg1">
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
						<td width="15%" align="right" valign="middle">进入时间：</td>
						<td width="35%" align="left" valign="middle"><?php echo $row['etime']; ?></td>
						<td width="15%" align="right" valign="middle">离开时间：</td>
						<td width="35%" align="left" valign="middle"><?php if ($row['beon']) {echo "<span style='color:#ff0000'>在线</span>";} else {echo $row['ltime'];} ?></td>
					</tr>
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
						<td width="15%" align="right" valign="middle">IP地址：</td>
						<td width="35%" align="left" valign="middle"><?php echo $row['ip']; ?></td>
						<td width="15%" align="right" valign="middle">地理位置：</td>
						<td width="35%" align="left" valign="middle"><?php echo $row['address']; ?></td>
					</tr>
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
						<td width="15%" align="right" valign="middle">操作系统：</td>
						<td width="35%" align="left" valign="middle"><?php echo $row['osys']; ?></td>
						<td width="15%" align="right" valign="middle">系统语言：</td>
						<td width="35%" align="left" valign="middle"><?php echo $row['lang']; ?></td>
					</tr>
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
						<td width="15%" align="right" valign="middle">浏 览 器：</td>
						<td width="35%" align="left" valign="middle"><?php echo $row['broswer']; ?></td>
						<td width="15%" align="right" valign="middle">Alexa工具条：</td>
						<td width="35%" align="left" valign="middle"><?php if ($row['alexa']) {echo '已安装';} else {echo '未安装';} ?></td>
					</tr>
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
						<td width="15%" align="right" valign="middle">屏幕尺寸：</td>
						<td width="35%" align="left" valign="middle"><?php echo $row['screen']; ?></td>
						<td width="15%" align="right" valign="middle">屏幕色彩：</td>
						<td width="35%" align="left" valign="middle"><?php echo $row['color']; ?>&nbsp;Bit</td>
					</tr>
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
						<td width="15%" align="right" valign="middle">浏览页数：</td>
						<td width="35%" align="left" valign="middle"><?php echo $row['pages']; ?></td>
						<td width="15%" align="right" valign="middle">访问次数：</td>
						<td width="35%" align="left" valign="middle"><?php echo $row['times']; ?></td>
					</tr>
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
						<td width="15%" align="right" valign="middle">来 路URL：</td>
						<td width="85%" align="left" valign="middle" colspan="3"><?php if (preg_match("/^http:\/\/([^\/]+)/i", $row['refurl'])) {echo "<a href='$row[refurl]' target='_blank' title='$row[refurl]'>$row[refurl]</a>";} else {echo $row['refurl'];} ?></td>
					</tr>
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
						<td width="15%" align="right" valign="middle">关 键 词：</td>
						<td width="35%" align="left" valign="middle"><?php echo $row['keyword']; ?></td>
						<td width="15%" align="right" valign="middle">搜索引擎：</td>
						<td width="35%" align="left" valign="middle"><?php echo getEngine($row['rdomain']); ?></td>
					</tr>
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
						<td width="15%" align="right" valign="middle">入口地址：</td>
						<td width="85%" align="left" valign="middle" colspan="3"><?php echo $row['pageurl']; ?></td>
					</tr>
				</tbody>
			</table></td>
		</tr>
<?php
}
?>
	</tbody>
</table>
</body>
</html>