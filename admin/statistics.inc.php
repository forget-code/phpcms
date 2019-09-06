<?php
$statistics = load('statistics.class.php', 'phpcms', 'include/admin');
$admin = load('admin.class.php', 'phpcms', 'include/admin');
require_once 'tree.class.php';
switch ($action)
{
	case 'show_users':
		$userid = isset($userid) && !empty($userid) ? intval($userid) : showmessage('参数有误。', $forward);
		$user = $admin->get_member_info($userid);
		foreach($CATEGORY as $key=>$val)
		{
			if($val['type']) continue;
			$categorys[$val['catid']] = array('id'=>$val['catid'],'parentid'=>$val['parentid'],'name'=>$val['catname'],'day'=>$statistics->day($userid,$val['catid']),'yesterday'=>$statistics->yesterday($userid,$val['catid']),'week'=>$statistics->week($userid,$val['catid']),'month'=>$statistics->month($userid,$val['catid']),'all'=>$statistics->count($userid, '', '', $val['catid']));
			$cates[$val['catid']] =  array('id'=>$val['catid'],'parentid'=>$val['parentid'],'name'=>$val['catname']);
		}
		$str = "<tr>
		<td>\$spacer \$name</td>
		<td style='text-align:center'>\$day</td>
		<td style='text-align:center'>\$yesterday</td>
		<td style='text-align:center'>\$week</td>
		<td style='text-align:center'>\$month</td>
		<td style='text-align:center'>\$all</td>
		</tr>";
		$select = "<option value='\$id'>\$spacer \$name</option>";
		$tree = new tree();
		$tree->tree($categorys);
		$catid = isset($catid) ?  intval($catid) : 0;
		$html = $tree->get_tree($catid,$str);
		$tree->tree($cates);
		$selected = $tree->get_tree(0, $select);
		include admin_tpl('statistics_show_users');
		break;
		
	case 'search':
		$userid = isset($userid) && !empty($userid) ? intval($userid) : showmessage('参数有误。', $forward);
		if(isset($starttime) && !empty($starttime))
		{
			$starttime = strtotime($starttime." 00:00:00");
		}
		else 
		{
			$starttime = '';
		}
		if(isset($stoptime) && !empty($stoptime))
		{
			$stoptime = strtotime($stoptime." 23:59:59");
		}
		else 
		{
			$stoptime = '';
		}
		$user = $admin->get_member_info($userid);
		foreach($CATEGORY as $key=>$val)
		{
			if($val['type']) continue;
			$categorys[$val['catid']] = array('id'=>$val['catid'],'parentid'=>$val['parentid'],'name'=>$val['catname'],'search'=>$statistics->count($userid, $starttime, $stoptime, $val['catid']));
			$cates[$val['catid']] =  array('id'=>$val['catid'],'parentid'=>$val['parentid'],'name'=>$val['catname']);
		}
		$str = "<tr>
		<td>\$spacer \$name</td>
		<td style='text-align:center'>\$search</td>
		</tr>";
		$select = "<option value='\$id' \$selected>\$spacer \$name</option>";
		$tree = new tree();
		$tree->tree($categorys);
		$catid = isset($catid) && !empty($catid) ?  intval($catid) : 0;
		if($catid != 0 && $CATEGORY[$catid]['child']==0)
		{
			$catid = $CATEGORY[$catid]['parentid'];
		}
		$html = $tree->get_tree($catid,$str);
		$tree->tree($cates);
		$selected = $tree->get_tree(0, $select, $catid);
		include admin_tpl('statistics_search');
		break;
	
	default:
		if (isset($roles) && !empty($roles)) {
			$admin_list = $admin->listinfo("userid IN (SELECT userid FROM ".DB_PRE."admin_role WHERE roleid = '$roles')");
		}
		else {
			$admin_list = $admin->listinfo();
		}
		$roel = $admin->listrole();
		$pagetitle = '编辑统计信息';
		include admin_tpl('statistics');
		break;
}
?>