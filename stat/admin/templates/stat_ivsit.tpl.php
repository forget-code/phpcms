<?php
defined('IN_PHPCMS') or exit('Access Denied');
?>
	<tbody class="trbg1">
<?php
if (isset($type) && ($type == "today" || $type == "all") && isset($visits) && intval($visits) > 0) {
	switch ($type) {
		case 'today':
			if (isset($resault)) {
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="100%" align="center" valign="middle" colspan="5"><ul style="margin:0px">
				<li style="float:left;margin-left:10px">&there4;&nbsp;点击序号--查看访客详细信息</li>
				<li style="float:right;margin-right:10px">&there4;&nbsp;点击IP地址--查看使用此IP的用户的所有访问记录</li>
			</ul></td>
		</tr>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="100%" align="left" valign="middle" colspan="5">第<?php echo $visits; ?>次访问者的当日明细</td>
		</tr>

<?php
for ($i = 0; $i < count($resault); $i++) {
?>
		<tr>
			<td width="100%" align="center" valign="middle" colspan="5"><table width="100%" cellpadding="3" cellspacing="1" align="center" class="tableborder">
				<tbody class="trbg1">
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
						<td width="6%" align="center" valign="middle">序号</td>
						<td width="8%" align="right" valign="middle">进入时间:</td>
						<td width="18%" align="center" valign="middle"><?php echo $resault[$i][2]; ?></td>
						<td width="8%" align="center" valign="middle">停留时间:</td>
						<td width="15%" align="center" valign="middle"><?php echo $stay[$i]; ?></td>
						<td width="8%" align="center" valign="middle">IP地址:</td>
						<td width="17%" align="center" valign="middle"><a href="<?php echo "?mod=$mod&file=$file&action=track&ip={$resault[$i][1]}"; ?>" target="_self" title="查看该IP地址的所有访问记录"><?php echo $resault[$i][1]; ?></a></td>
						<td width="8%" align="center" valign="middle">地理位置:</td>
						<td width="12%" align="left" valign="middle"><?php echo $resault[$i][5]; ?></td>
					</tr>
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
						<td width="6%" align="center" valign="middle" rowspan="3"><a href="<?php echo "?mod=$mod&file=$file&action=track&id={$resault[$i][0]}"; ?>" target="_self" title="查看访客详细信息"><?php echo intval(($curPage - 1) * $pageSize + $i + 1); if ($resault[$i][4] == 1) {echo '<div style="text-align:center;color:#ff0000">在线</div>';} ?></a></td>
						<td width="8%" align="right" valign="middle">来 源URL:</td>
						<td width="86%" align="left" valign="middle" colspan="7"><?php if (preg_match("/^http:\/\/([^\/]+)/i", $resault[$i][6])) {echo "<a href='{$resault[$i][6]}' target='_blank'>{$resault[$i][6]}</a>";} else {echo $resault[$i][6];} ?></td>
					</tr>
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
						<td width="8%" align="right" valign="middle">关 键 词:</td>
						<td width="65%" align="left" valign="middle" colspan="5"><?php echo $resault[$i][8]; ?></td>
						<td width="8%" align="center" valign="middle">搜索引擎:</td>
						<td width="12%" align="left" valign="middle"><?php echo getEngine($resault[$i][7]); ?></td>
					</tr>
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
						<td width="8%" align="right" valign="middle">入口地址:</td>
						<td width="86%" align="left" valign="middle" colspan="7"><?php echo $resault[$i][9]; ?></td>
					</tr>
				</tbody>
			</table></td>
		</tr>
<?php
			}
		} else {
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="100%" align="center" valign="middle" colspan="5">暂无相关记录</td>
		</tr>
<?php
		}
		$curUri .= "&type=today&visits=$visits";
		break;
	case 'all':
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="100%" align="left" valign="middle" colspan="5">第<?php echo $visits; ?>次访问者的历史记录</td>
		</tr>
		<tr>
			<td width="10%" align="center" valign="middle" class="tablerowhighlight">日期</td>
			<td width="10%" align="center" valign="middle" class="tablerowhighlight">访问量</td>
			<td width="10%" align="center" valign="middle" class="tablerowhighlight">访问比率</td>
			<td width="60%" align="center" valign="middle" class="tablerowhighlight">图表</td>
			<td width="10%" align="center" valign="middle" class="tablerowhighlight">当日记录</td>
		</tr>
<?php
		for ($i = 0; $i < count($resault); $i++) {
			$rate_pv = round(100 * $resault[$i][0] / $total_pv, 2);
			$imgw_pv = floor(100 * $resault[$i][0] / $maxpv);
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="10%" align="center" valign="middle"><?php echo $resault[$i][1]; ?></td>
			<td width="10%" align="right" valign="middle"><?php echo $resault[$i][0]; ?></td>
			<td width="10%" align="right" valign="middle"><?php echo $rate_pv; ?>%</td>
			<td width="60%" align="left" valign="middle" style="padding-left:0px;padding-right:3px"><?php if ($imgw_pv == 0) {echo '&nbsp;';} else {echo "<img src='$PHP_SITEURL/$mod/pv.gif' width='$imgw_pv%' border='0' height='16'>";} ?></td>
			<td width="10%" align="center" valign="middle"><a href="<?php echo "$curUri&fdate={$resault[$i][1]}&ldate={$resault[$i][1]}"; ?>" target="_self">GO</a></td>
		</tr>
<?php
		}
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="10%" align="center" valign="middle">总访问数:</td>
			<td width="90%" align="left" valign="middle" colspan="4"><?php echo $total_pv; ?></td>
		</tr>
<?php
			$curUri .= "&type=all&visits=$visits";
	}
	if (isset($pageCount)) {
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
<?php
if ($pageCount > 1) {
	$first = "$curUri&page=1";
	$last = "$curUri&page=" . intval($curPage - 1);
	$next = "$curUri&page=" . intval($curPage + 1);
	$end = "$curUri&page=$pageCount";
?>
			<td width="100%" align="center" valign="middle" colspan="5"><table width="100%" cellpadding="3" cellspacing="1" align="center" class="tableborder">
				<tbody class="trbg1">
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
						<td width="35%" align="left" valign="middle" style="padding-left:5px">共<?php echo "{$record}条记录&nbsp;第{$curPage}/{$pageCount}页&nbsp;{$pageSize}条记录/页"; ?></td>
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
	echo "<option value='$curUri&page=$i'";
	if ($i == $curPage) {
		echo " selected";
	}
	echo ">第{$i}页</option>";
}
?>
						</select></td>
					</tr>
				</tbody>
			</table></td>
<?php
} else {
?>
			<td width="100%" align="right" valign="middle" colspan="5" style="padding-right:10px"><?php echo "共{$record}条记录&nbsp;第{$curPage}/{$pageCount}页&nbsp;{$pageSize}条记录/页";?></td>
<?php
}
?>
		</tr>
<?php
	}
} else {
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="100%" align="center" valign="middle" colspan="6"><form action="<?php echo $curUri; ?>" method="post">开始日期：<?php echo date_select('fdate', $fdate); ?>&nbsp;&nbsp;&nbsp;&nbsp;截止日期：<?php echo date_select('ldate', $ldate); ?>&nbsp;&nbsp;<input type="submit" name="dosubmit" value="确 定"></form></td>
		</tr>
<?php
if (isset($resault)) {
?>
		<tr>
			<td width="10%" align="center" valign="middle" class="tablerowhighlight">访问次数</td>
			<td width="10%" align="center" valign="middle" class="tablerowhighlight">访问量</td>
			<td width="10%" align="center" valign="middle" class="tablerowhighlight">访问比率</td>
			<td width="50%" align="center" valign="middle" class="tablerowhighlight">图表</td>
			<td width="10%" align="center" valign="middle" class="tablerowhighlight">当日明细</td>
			<td width="10%" align="center" valign="middle" class="tablerowhighlight">历史记录</td>
		</tr>
<?php
for ($i = 0; $i < count($resault); $i++) {
	$rate_pv = round(100 * $resault[$i][0] / $total_pv, 2);
	$imgw_pv = floor(100 * $resault[$i][0] / $maxpv);
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="10%" align="center" valign="middle">第<?php echo $resault[$i][1]; ?>次访问</td>
			<td width="10%" align="right" valign="middle"><?php echo $resault[$i][0]; ?></td>
			<td width="10%" align="right" valign="middle"><?php echo $rate_pv; ?>%</td>
			<td width="50%" align="left" valign="middle" style="padding-left:0px;padding-right:3px"><?php if ($imgw_pv == 0) {echo '&nbsp;';} else {echo "<img src='$PHP_SITEURL/$mod/pv.gif' width='$imgw_pv%' border='0' height='16'>";} ?></td>
			<td width="10%" align="center" valign="middle"><a href="<?php echo "$curUri&type=today&visits={$resault[$i][1]}"; ?>" target="_self">GO</a></td>
			<td width="10%" align="center" valign="middle"><a href="<?php echo "$curUri&type=all&visits={$resault[$i][1]}"; ?>" target="_self">GO</a></td>
		</tr>
<?php
}
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="10%" align="center" valign="middle">新访客数:</td>
			<td width="10%" align="right" valign="middle"><?php echo $newpv; ?></td>
			<td width="10%" align="center" valign="middle">老访客数:</td>
			<td width="50%" align="center" valign="middle"><?php echo intval($total_pv - $newpv); ?></td>
			<td width="10%" align="center" valign="middle">总访问数:</td>
			<td width="10%" align="center" valign="middle"><?php echo $total_pv; ?></td>
		</tr>
<?php
} else {
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="100%" align="center" valign="middle">暂无相关记录</td>
		</tr>
<?php
}
}
?>
	</tbody>
</table>
</body>
</html>