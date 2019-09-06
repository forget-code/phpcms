<?php
defined('IN_PHPCMS') or exit('Access Denied');
?>
	<tbody class="trbg1">
<?php
if (isset($screen)) {
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="100%" align="left" valign="middle" colspan="5">访问者屏幕分辨率为<?php echo $screen; ?>的所有历史数据</td>
		</tr>
		<tr>
			<td width="10%" align="center" valign="middle" class="tablerowhighlight">日期</td>
			<td width="13%" align="center" valign="middle" class="tablerowhighlight">访问量</td>
			<td width="8%" align="center" valign="middle" class="tablerowhighlight">访问比率</td>
			<td width="61%" align="center" valign="middle" class="tablerowhighlight">图表</td>
			<td width="8%" align="center" valign="middle" class="tablerowhighlight">当日记录</td>
		</tr>
<?php
	for ($i = 0; $i < count($resault); $i++) {
		$rate_pv = round(100 * $resault[$i][0] / $total_pv, 2);
		$imgw_pv = floor(100 * $resault[$i][0] / $maxpv);
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="10%" align="center" valign="middle"><?php echo $resault[$i][1]; ?></td>
			<td width="13%" align="right" valign="middle"><?php echo $resault[$i][0]; ?></td>
			<td width="8%" align="right" valign="middle"><?php echo $rate_pv; ?>%</td>
			<td width="61%" align="left" valign="middle" style="padding-left:0px;padding-right:3px"><?php if ($imgw_pv == 0) {echo '&nbsp;';} else {echo "<img src='$PHP_SITEURL/$mod/pv.gif' width='$imgw_pv%' border='0' height='16'>";} ?></td>
			<td width="7%" align="center" valign="middle"><a href="<?php echo "$curUri&fdate={$resault[$i][1]}&ldate={$resault[$i][1]}"; ?>" target="_self">GO</a></td>
		</tr>
<?php
	}
	$curUri .= "&screen=" . urlencode($screen);
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="10%" align="center" valign="middle">总访问数:</td>
			<td width="90%" align="left" valign="middle" colspan="4"><?php echo $total_pv; ?></td>
		</tr>
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
} else {
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="100%" align="center" valign="middle" colspan="5"><form action="<?php echo $curUri; ?>" method="post">开始日期：<?php echo date_select('fdate', $fdate); ?>&nbsp;&nbsp;&nbsp;&nbsp;截止日期：<?php echo date_select('ldate', $ldate); ?>&nbsp;&nbsp;<input type="submit" name="dosubmit" value="确 定"></form></td>
		</tr>
<?php
	if ($total_pv > 0) {
?>
		<tr>
			<td width="30%" align="center" valign="middle" class="tablerowhighlight">屏幕分辨率</td>
			<td width="7%" align="center" valign="middle" class="tablerowhighlight">访问量</td>
			<td width="8%" align="center" valign="middle" class="tablerowhighlight">访问比率</td>
			<td width="47%" align="center" valign="middle" class="tablerowhighlight">图表</td>
			<td width="8%" align="center" valign="middle" class="tablerowhighlight">历史记录</td>
		</tr>
<?php
		for ($i = 0; $i < count($resault); $i++) {
			$rate_pv = round(100 * $resault[$i][0] / $total_pv, 2);
			$imgw_pv = floor(100 * $resault[$i][0] / $maxpv);
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="30%" align="center" valign="middle"><?php echo $resault[$i][1]; ?></td>
			<td width="7%" align="right" valign="middle"><?php echo $resault[$i][0]; ?></td>
			<td width="8%" align="right" valign="middle"><?php echo $rate_pv; ?>%</td>
			<td width="47%" align="left" valign="middle" style="padding-left:0px;padding-right:3px"><?php if ($imgw_pv == 0) {echo '&nbsp;';} else {echo "<img src='$PHP_SITEURL/$mod/pv.gif' width='$imgw_pv%' border='0' height='16'>";} ?></td>
			<td width="8%" align="center" valign="middle"><a href="<?php echo "$curUri&screen=" . urlencode($resault[$i][1]); ?>" target="_self">GO</a></td>
		</tr>
<?php
		}
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="10%" align="center" valign="middle">总访问数:</td>
			<td width="90%" align="left" valign="middle" colspan="4"><?php echo $total_pv; ?></td>
		</tr>
<?php
	} else {
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="100%" align="center" valign="middle" colspan="5">暂无相关记录</td>
		</tr>
<?php
	}
}
?>
	</tbody>
</table>
</body>
</html>