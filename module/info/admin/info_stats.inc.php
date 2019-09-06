<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once PHPCMS_ROOT.'/include/tree.class.php';
require_once PHPCMS_ROOT.'/admin/include/category_channel.class.php';

$username = isset($username) ? $username : '';
$fromdate = isset($fromdate) && preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/', $fromdate) ? $fromdate : '';
$fromtime = $fromdate ? strtotime($fromdate.' 0:0:0') : 0;
$todate = isset($todate) && preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/', $todate) ? $todate : '';
$totime = $todate ? strtotime($todate.' 23:59:59') : 0;
$sql = '';
if($username) $sql .= " and username='$username' ";
if($fromtime) $sql .= " and addtime>$fromtime ";
if($totime) $sql .= " and addtime<$totime ";
$tree = new tree;
$cat = new category_channel($channelid, $catid);
$list = $cat->get_list();
if(is_array($list))
{
	$categorys = array();
	$sum__1 = $sum_0 = $sum_1 = $sum_2 = $sum_3 =0;
	foreach($list as $catid => $category)
	{
		$module = $CHA['module'];
		$status[-1] = 'num__1';
		$status[1] = 'num_1';
		$status[3] = 'num_3';
		for($i=-1; $i<4; $i++)
		{
			if($i==0 || $i==2) continue;
			$r = $db->get_one("select count(infoid) as num from ".channel_table('info', $channelid)." where status=$i and catid=$catid $sql ");
			$$status[$i] = $r['num'];
		}
		$percent__1 = $percent_1 = $percent_3 =0;
		$sum = $num__1+$num_1+$num_3;
		$sum__1 += $num__1;
		$sum_1 += $num_1;
		$sum_3 += $num_3;
		if($sum > 0)
		{
			$percent__1 = round(100*$num__1/$sum, 1);
			$percent_1 = round(100*$num_1/$sum, 1);
			$percent_3 = round(100*$num_3/$sum, 1);
		}
	
		$categorys[$category['catid']] = array('id'=>$category['catid'],'parentid'=>$category['parentid'],'name'=>$category['catname'],'listorder'=>$category['listorder'],'style'=>$category['style'],'mod'=>$mod,'channelid'=>$channelid,'file'=>$file,'num__1'=>$num__1,'num_1'=>$num_1,'num_3'=>$num_3,'percent__1'=>$percent__1,'percent_1'=>$percent_1,'percent_3'=>$percent_3);
	}
	$str = "<tr onmouseout=this.style.backgroundColor='#F1F3F5' onmouseover=this.style.backgroundColor='#BFDFFF' bgColor='#F1F3F5' height='23'>
				<td>\$id</td>
				<td>\$spacer<a href='?mod=\$mod&file=\$file&action=manage&catid=\$id&channelid=\$channelid'><span style='\$style'>\$name</span></a></td>
				<td><span style='float:right;font-size:10px;'>\$percent_3%</span><a href='?mod=\$mod&file=\$file&action=manage&catid=\$id&channelid=\$channelid'>\$num_3</a></td>
				<td><span style='float:right;font-size:10px;'>\$percent_1%</span><a href='?mod=\$mod&file=\$file&action=manage&job=check&catid=\$id&channelid=\$channelid'>\$num_1</a></td>
				<td><span style='float:right;font-size:10px;'>\$percent__1%</span><a href='?mod=\$mod&file=\$file&action=manage&job=recycle&catid=\$id&channelid=\$channelid'>\$num__1</a></td>
				</tr>";
	$tree->tree($categorys);
	$categorys = $tree->get_tree(0,$str);
}
include admintpl($mod.'_stats');
?>