<?php
defined('IN_PHPCMS') or exit('Access Denied');
?>
	<tbody class="trbg1">
		<tr>
			<td width="25%" align="center" valign="middle" class="tablerowhighlight">统计类别</td>
			<td width="35%" align="center" valign="middle" class="tablerowhighlight">页面总访问量(同一访客的每次访问均被记录)</td>
			<td width="40%" align="center" valign="middle" class="tablerowhighlight">独立IP访问量(24小时内相同IP地址只被计算1次)</td>
		</tr>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="25%" align="center" valign="middle">今日流量</td>
			<td width="35%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $stat['tday_pv']; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;PV<?php echo "&nbsp;(新访客数:" . intval($stat['tday_pv'] - $stat['old']) . ";&nbsp;老访客数:$stat[old])"; ?></td>
				</tr>
			</table></td>
			<td width="40%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $stat['tday_ip']; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;IP</td>
				</tr>
			</table></td
		</tr>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="25%" align="center" valign="middle">昨日流量</td>
			<td width="35%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $stat['yday_pv']; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;PV</td>
				</tr>
			</table></td>
			<td width="40%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $stat['yday_ip']; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;IP</td>
				</tr>
			</table></td
		</tr>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="25%" align="center" valign="middle">本周合计</td>
			<td width="35%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $stat['tweek_pv']; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;PV</td>
				</tr>
			</table></td>
			<td width="40%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $stat['tweek_ip']; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;IP</td>
				</tr>
			</table></td
		</tr>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="25%" align="center" valign="middle">上周合计</td>
			<td width="35%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $stat['lweek_pv']; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;PV</td>
				</tr>
			</table></td>
			<td width="40%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $stat['lweek_ip']; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;IP</td>
				</tr>
			</table></td
		</tr>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="25%" align="center" valign="middle">本月合计</td>
			<td width="35%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $stat['tmonth_pv']; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;PV</td>
				</tr>
			</table></td>
			<td width="40%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $stat['tmonth_ip']; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;IP</td>
				</tr>
			</table></td
		</tr>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="25%" align="center" valign="middle">上月合计</td>
			<td width="35%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $stat['lmonth_pv']; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;PV</td>
				</tr>
			</table></td>
			<td width="40%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $stat['lmonth_ip']; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;IP</td>
				</tr>
			</table></td
		</tr>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="25%" align="center" valign="middle">日均流量</td>
			<td width="35%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $stat['davg_pv']; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;PV</td>
				</tr>
			</table></td>
			<td width="40%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $stat['davg_ip']; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;IP</td>
				</tr>
			</table></td
		</tr>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="25%" align="center" valign="middle">平均周量</td>
			<td width="35%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $stat['wavg_pv']; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;PV</td>
				</tr>
			</table></td>
			<td width="40%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $stat['wavg_ip']; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;IP</td>
				</tr>
			</table></td
		</tr>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="25%" align="center" valign="middle">平均月量</td>
			<td width="35%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $stat['mavg_pv']; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;PV</td>
				</tr>
			</table></td>
			<td width="40%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $stat['mavg_ip']; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;IP</td>
				</tr>
			</table></td
		</tr>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="25%" align="center" valign="middle">本年合计</td>
			<td width="35%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $stat['year_pv']; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;PV</td>
				</tr>
			</table></td>
			<td width="40%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $stat['year_ip']; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;IP</td>
				</tr>
			</table></td
		</tr>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="25%" align="center" valign="middle">总访问量</td>
			<td width="35%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $total_pv; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;PV</td>
				</tr>
			</table></td>
			<td width="40%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $total_ip; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;IP</td>
				</tr>
			</table></td
		</tr>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="25%" align="center" valign="middle">最大日量</td>
			<td width="35%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $stat['maxd_pv']; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;PV<?php if (!empty($stat['mdate_pv'])) {echo "&nbsp;(" . $stat['mdate_pv'] . ")";} ?></td>
				</tr>
			</table></td>
			<td width="40%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $stat['maxd_ip']; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;IP<?php if (!empty($stat['mdate_ip'])) {echo "&nbsp;(" . $stat['mdate_ip'] . ")";} ?></td>
				</tr>
			</table></td
		</tr>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="25%" align="center" valign="middle">最大周量</td>
			<td width="35%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $stat['maxw_pv']; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;PV<?php if (!empty($stat['fdate_pv']) && !empty($stat['ldate_pv'])) {echo "&nbsp;(" . $stat['fdate_pv'] . "至" . $stat['ldate_pv'] . ")";} ?></td>
				</tr>
			</table></td>
			<td width="40%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $stat['maxw_ip']; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;IP<?php if (!empty($stat['fdate_ip']) && !empty($stat['fdate_ip'])) {echo "&nbsp;(" . $stat['fdate_ip'] . "至" . $stat['ldate_ip'] . ")";} ?></td>
				</tr>
			</table></td
		</tr>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="25%" align="center" valign="middle">最大月量</td>
			<td width="35%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $stat['maxm_pv']; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;PV<?php if (!empty($stat['mmonth_pv'])) {echo "&nbsp;(" . $stat['mmonth_pv'] . ")";} ?></td>
				</tr>
			</table></td>
			<td width="40%" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="20%" align="right" valign="middle"><?php echo $stat['maxm_ip']; ?></td>
					<td width="80%" align="left" valign="middle">&nbsp;IP<?php if (!empty($stat['mmonth_ip'])) {echo "&nbsp;(" . $stat['mmonth_ip'] . ")";} ?></td>
				</tr>
			</table></td
		</tr>
	</tbody>
<?php
if (isset($fdate) && isset($ldate) && isset($days)) {
?>
	<tfoot>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="100%" align="center" valign="middle" colspan="3"><?php echo "开始日期:${fdate}&nbsp;&nbsp;截止日期:${ldate}&nbsp;&nbsp;共统计${days}天"; ?></td>
		</tr>
	</tfoot>
<?php
}
?>
</table>
<div style="margin-top:10px;width:100%;text-align:center">Alexa排名走势图<br><a href="http://www.alexa.com/data/details/traffic_details?q=&url=<?php echo $_SERVER['HTTP_HOST']; ?>" target="_blank"><img src="http://traffic.alexa.com/graph?w=379&h=216&r=6m&y=t&u=<?php echo $_SERVER['HTTP_HOST']; ?>" border="0" alt="点击查看Alexa详情"></a><br><a href="http://www.alexa.com/data/details/traffic_details?q=&url=<?php echo $_SERVER['HTTP_HOST']; ?>" target="_blank">点击查看Alexa详情</a></div>
</body>
</html>