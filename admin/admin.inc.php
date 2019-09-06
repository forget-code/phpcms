<?php
defined('IN_PHPCMS') or exit('Access Denied');

require 'admin/admin.class.php';
$userid = isset($userid) ? intval($userid) : 0;
$a = new admin($userid);

$action = $action ? $action : 'manage';

$submenu = array
(
	array($LANG['add_admin'], '?mod='.$mod.'&file='.$file.'&action=add'),
	array($LANG['administrator_list'], '?mod='.$mod.'&file='.$file.'&action=manage')
);
foreach($ROLE as $id=>$name)
{
    $submenu[] = array($name, '?mod='.$mod.'&file='.$file.'&action=manage&roleid='.$id);
}

$menu = admin_menu($LANG['admin_option'], $submenu);
$admin_founders = explode(',',ADMIN_FOUNDERS);
if(in_array($action,array('edit','disable','delete')) && in_array($userid,$admin_founders)) showmessage('不允许修改创始人信息');

switch($action)
{
	case 'add':

		if($dosubmit)
	    {
			if(!$a->add($admin, $roleids)) showmessage($a->errormsg());
			showmessage($LANG['add_admin_success'],'?mod='.$mod.'&file='.$file.'&action=manage');
		}
		else
	    {
			$roles = $a->listrole();
			include admin_tpl('admin_add');
		}
		break;

	case 'edit':
		if($dosubmit)
	    {
			if(!$a->edit($admin, $roleids)) showmessage($a->errormsg());
			showmessage($LANG['edit_authority_success'], '?mod='.$mod.'&file='.$file.'&action=manage');
		}
		else
	    {
			$admin = $a->get();
			if(!$admin) showmessage($a->errormsg());
			extract($admin);
			$roles = $a->listrole();
			include admin_tpl('admin_edit');
		}
		break;

	case 'view':
		$data = $a->view($userid);
	    extract($data);
		$roles = $a->get_role_name($roleids);

		$year = $year ? $year : date("Y", TIME);	//当前年
		$month = $month ? $month : date("n", TIME);	//当前月
		$week = date("W", TIME);	//当前周
		$daynums = date("t", mktime(0, 0, 0, $month, 1, $year));	//本月天数
		$s = mktime(0, 0, 0, $month, 1, $year);	//本月开始时间
		$e = mktime(0, 0, 0, $month, $daynums, $year);	//本月结束时间
		$weeknum = $weekhits = $weekcomments = 0;
		$monthnum = $monthhits = $monthcomments = 0;
		//选出单用户本月所有文章
		$sql = "SELECT c.contentid, c.inputtime, cc.hits, cc.comments
				FROM ".DB_PRE."content c 
				LEFT JOIN ".DB_PRE."content_count cc 
				ON c.contentid=cc.contentid 
				WHERE c.userid='$userid' AND c.inputtime BETWEEN $s AND $e";

		$query = $db->query($sql);
		$numarr = array();
		while($res = $db->fetch_array($query)) {
			$numarr[date('d', $res['inputtime'])]++;	//用天做key 算文章数
			if(date('W', $res['inputtime']) == $week) {
				$weeknum++;
				$weekhits += $res['hits'];
				$weekcomments += $res['comments'];
			}
			if(date('n', $res['inputtime']) == $month) {
				$monthnum++;
				$monthhits += $res['hits'];
				$monthcomments += $res['comments'];
			}
			$contenthit[date('d', $res['inputtime'])] += $res['hits'];
			$contentcomment[date('d', $res['inputtime'])] += $res['comments'];
		}

		include admin_tpl('admin_view');
		break;

	case 'manage':
        $where = $roleid ? array(DB_PRE.'admin_role','userid',"roleid=$roleid") : '';
		$order = $roleid ? 'a.userid' : '';
        $admins = $a->listinfo($where, $order, $page, 20);
		include admin_tpl('admin_manage');
		break;

	case 'delete':
        $a->delete();
	    showmessage($LANG['operation_success'], '?mod='.$mod.'&file='.$file.'&action=manage');
		break;

	case 'disable':
        $a->disable($disabled);
	    showmessage($LANG['operation_success'], '?mod='.$mod.'&file='.$file.'&action=manage');
		break;

	case 'check':
		if($a->check($value))
	    {
		    exit('success');
		}
		else
	    {
			exit($a->errormsg());
		}
		break;
}
?>