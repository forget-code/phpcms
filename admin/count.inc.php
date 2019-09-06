<?php
require('count.class.php');
$count = new count();
require_once 'tree.class.php';
switch ($action)
{
	default:
		foreach ($CATEGORY as $key=>$val)
		{
			if ($val['type'] != 0) {
				continue;
			}
			$categories[$key] = array('id'=>$val['catid'],'parentid'=>$val['parentid'],'name'=>$val['catname'],'day'=>$count->get_count($val['catid'], 'day') ? $count->get_count($val['catid'], 'day') : 0,'yestoday'=>$count->get_count($val['catid'], 'yestoday') ? $count->get_count($val['catid'], 'yestoday') : 0, 'week'=>$count->get_count($val['catid'], 'week') ? $count->get_count($val['catid'], 'week') : 0, 'month'=>$count->get_count($val['catid'], 'month') ? $count->get_count($val['catid'], 'month') : 0,'year'=>'<a onmouseover="javascript:$(\'#year_'.$val['catid'].'\').load(\'?mod=phpcms&file=count&action=get_year&catid='.$val['catid'].'\')" style="cursor:pointer ">查看</a>', 'all'=>$count->count_all($val['catid']) ? $count->count_all($val['catid']) : 0);
			$cates[$val['catid']] =  array('id'=>$val['catid'],'parentid'=>$val['parentid'],'name'=>$val['catname']);
		}
		$str = "<tr>
		<td>\$spacer \$name</td>
		<td style='text-align:center'>\$day</td>
		<td style='text-align:center'>\$yestoday</td>
		<td style='text-align:center'>\$week</td>
		<td style='text-align:center'>\$month</td>
		<td style='text-align:center' id='year_\$id'>\$year</td>
		<td style='text-align:center'>\$all</td>
		</tr>";
		$select = "<option value='\$id'>\$spacer \$name</option>";
		$tree = new  tree($categories);
		$html = $tree->get_tree(0, $str);
		$tree = new tree($cates);
		$selected = $tree->get_tree(0, $select);
		include admin_tpl('count');
		break;
		
	case 'get_year':
		if (!isset($catid) || empty($catid)) {
			exit('参数有错');
		}
		echo $count->get_count($catid, 'year') ? $count->get_count($catid, 'year') : 0;
		break;
		
	case 'search':
		$catid = isset($catid) && !empty($catid) ? intval($catid) : showmessage('请选择栏目', $forward);
		foreach ($CATEGORY as $key=>$val)
		{
			if ($val['type'] != 0) {
				continue;
			}
			$cates[$val['catid']] =  array('id'=>$val['catid'],'parentid'=>$val['parentid'],'name'=>$val['catname']);
		}
		$select = "<option value='\$id' \$selected>\$spacer \$name</option>";
		$tree = new tree($cates);
		$selected = $tree->get_tree(0, $select, $catid);
		$val = $CATEGORY[$catid];
		$list = $count->get_data($starttime, $stoptime, $catid);
		include admin_tpl('count_search');
		break;
}
?>