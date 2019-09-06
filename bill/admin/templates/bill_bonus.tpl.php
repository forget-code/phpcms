<?php
defined('IN_PHPCMS') or exit('Access Denied');
?>
<table width="100%" cellpadding="3" cellspacing="1" align="center" class="tableborder">
	<thead>
		<tr>
			<th colspan="4">推广<?php echo $menutitle[$fid]; ?></th>
		</tr>
	</thead>
	<tbody class="trbg1">
		<tr>
			<td width="13%" align="left" valign="middle" colspan="2">推广排行(<?php if ($display == 'date') {echo '当日';} else {echo '当月';} ?>)：</td>
			<td width="87%" align="right" valign="middle" colspan="2" style="padding-right:10px">
<?php
if ($display == 'date') {
	echo "<a href='$curUri&groupby=$groupby&display=month' target='_self'>查看当月排行</a>";
} else {
	echo "<a href='$curUri&groupby=$groupby&display=date' target='_self'>查看当日排行</a>";
}
echo '&nbsp;|&nbsp;';
if ($groupby == 'userid') {
	echo "<a href='$curUri&groupby=refurl&display=$display' target='_self'>按推广地址分组</a>";
} else {
	echo "<a href='$curUri&groupby=userid&display=$display' target='_self'>按会员ID分组";
}
?>
			</td>
		</tr>
<?php
if (isset($record)) {
?>
		<tr>
			<td width="5%" align="center" valign="middle" class="tablerowhighlight">序号</td>
			<td width="8%" align="center" valign="middle" class="tablerowhighlight">会员ID</td>
			<td width="79%" align="center" valign="middle" class="tablerowhighlight">推广地址</td>
			<td width="8%" align="center" valign="middle" class="tablerowhighlight">次数</td>
		</tr>
<?php
for ($i = 0; $i < count($record); $i++) {
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="5%" align="center" valign="middle"><?php intval($i + 1); ?></td>
			<td width="8%" align="center" valign="middle"><?php $record[$i][1]; ?></td>
			<td width="79%" align="center" valign="middle"><?php $record[$i][2]; ?></td>
			<td width="8%" align="center" valign="middle"><?php $record[$i][0]; ?></td>
		</tr>
<?php
}
} else {
?>
		<tr>
			<td width="100%" align="center" valign="middle" colspan="4" class="tablerowhighlight">暂无当日推广记录</td>
		</tr>
<?php
}
?>
		<tr>
			<td width="100%" align="left" valign="middle" colspan="4">奖励统计：</td>
		</tr>
		<tr>
			<td width="100%" align="center" valign="middle" colspan="4"><table width="100%" cellpadding="3" cellspacing="1" align="center">
				<tbody class="trbg1">
					<tr>
						<td width="25%" align="center" valign="middle" class="tablerowhighlight">时&nbsp;&nbsp;&nbsp;&nbsp;段</td>
						<td width="25%" align="center" valign="middle" class="tablerowhighlight">点&nbsp;&nbsp;&nbsp;&nbsp;数</td>
						<td width="25%" align="center" valign="middle" class="tablerowhighlight">天&nbsp;&nbsp;&nbsp;&nbsp;数</td>
						<td width="25%" align="center" valign="middle" class="tablerowhighlight">现&nbsp;&nbsp;&nbsp;&nbsp;金</td>
					</tr>
					<tr>
						<td width="25%" align="center" valign="middle">当日：</td>
						<td width="25%" align="center" valign="middle"><?php echo $today[0]; ?></td>
						<td width="25%" align="center" valign="middle"><?php echo $today[1]; ?></td>
						<td width="25%" align="center" valign="middle"><?php echo $today[2]; ?></td>
					</tr>
					<tr>
						<td width="25%" align="center" valign="middle">本月：</td>
						<td width="25%" align="center" valign="middle"><?php echo $month[0]; ?></td>
						<td width="25%" align="center" valign="middle"><?php echo $month[1]; ?></td>
						<td width="25%" align="center" valign="middle"><?php echo $month[2]; ?></td>
					</tr>
					<tr>
						<td width="25%" align="center" valign="middle">全部：</td>
						<td width="25%" align="center" valign="middle"><?php echo $row[0]; ?></td>
						<td width="25%" align="center" valign="middle"><?php echo $row[1]; ?></td>
						<td width="25%" align="center" valign="middle"><?php echo $row[2]; ?></td>
					</tr>
				</tbody>
			</table></td>
		</tr>
	</tbody>
</table>