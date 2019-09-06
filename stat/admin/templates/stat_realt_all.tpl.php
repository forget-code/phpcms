<?php
defined('IN_PHPCMS') or exit('Access Denied');
if ($record > 0) {
?>
	<tbody class="trbg1">
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="100%" align="center" valign="middle"><ul style="margin:0px">
				<li style="float:left;margin-left:10px">&there4;&nbsp;点击序号--查看访客详细信息</li>
				<li style="float:right;margin-right:10px">&there4;&nbsp;点击IP地址--查看使用此IP的用户的所有访问记录</li>
			</ul></td>
		</tr>
<?php
	for ($i = 0; $i < count($resault); $i++) {
?>
		<tr>
			<td width="100%" align="center" valign="middle"><table width="100%" cellpadding="3" cellspacing="1" align="center" class="tableborder">
				<tbody class="trbg1">
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
						<td width="6%" align="center" valign="middle">序号</td>
						<td width="8%" align="right" valign="middle">进入时间:</td>
						<td width="18%" align="center" valign="middle"><?php echo $resault[$i][2]; ?></td>
						<td width="8%" align="center" valign="middle">停留时间:</td>
						<td width="15%" align="center" valign="middle"><?php echo $stay[$i]; ?></td>
						<td width="8%" align="center" valign="middle">IP地址:</td>
						<td width="17%" align="center" valign="middle"><a href="javascript:<?php echo "?mod=$mod&file=$file&action=track&ip={$resault[$i][1]}"; ?>" target="_self"  title="查看该IP地址的所有访问记录"><?php echo $resault[$i][1]; ?></a></td>
						<td width="8%" align="center" valign="middle">地理位置:</td>
						<td width="12%" align="left" valign="middle"><?php echo $resault[$i][5]; ?></td>
					</tr>
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
						<td width="6%" align="center" valign="middle" rowspan="3"><a href="<?php echo "?mod=$mod&file=$file&action=track&id={$resault[$i][0]}"; ?>" target="_self" title="查看访客详细信息"><?php	echo intval(($curPage - 1) * $pageSize + $i + 1);if ($resault[$i][4] == 1) {echo "<div style='text-align:center;color:#ff0000'>在线</div>";	} ?></a></td>
						<td width="8%" align="right" valign="middle">来路URL:</td>
						<td width="86%" align="left" valign="middle" colspan="7"><?php if (preg_match("/^http:\/\/([^\/]+)/i", $resault[$i][6])) {echo "<a href='{$resault[$i][6]}' target='_blank'>{$resault[$i][6]}</a>";} else {echo $resault[$i][6];} ?></td>
					</tr>
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
						<td width="8%" align="right" valign="middle">关 键 词:</td>
						<td width="66%" align="left" valign="middle" colspan="5"><?php echo $resault[$i][8]; ?></td>
						<td width="8%" align="center" valign="middle">搜索引擎:</td>
						<td width="12%" align="left" valign="middle"><?php echo getEngine($resault[$i][7]); ?></td>
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
			<td width="100%" align="center" valign="middle"><table width="100%" cellpadding="3" cellspacing="1" align="center" class="tableborder">
				<tbody class="trbg1">
					<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
<?php
if ($pageCount > 1) {
	$first = "$curUri&page=1";
	$last = "$curUri&page=" . intval($curPage - 1);
	$next = "$curUri&page=" . intval($curPage + 1);
	$end = "$curUri&page=$pageCount";
?>
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
<?php
} else {
?>
						<td width="100%" align="right" valign="middle" style="padding-right:10px">共<?php echo "{$record}条记录&nbsp;第{$curPage}/{$pageCount}页&nbsp;{$pageSize}"; ?>条记录/页</td>
<?php
}
?>
					</tr>
				</tbody>
			</table></td>
		</tr>
	</tbody>
<?php
} else {
?>
	<tfoot class="trbg1">
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="100%" align="center" valign="middle">暂无相关记录</td>
		</tr>
	</tfoot>
<?php
}
?>
</table>
</body>
</html>