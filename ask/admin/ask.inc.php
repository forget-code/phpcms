<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$departments = cache_read('ask_department.php');
$departmentids = array();
$sql = '';

if($_grade > 0)
{
	foreach($departments as $k=>$v)
	{
		if($v['admin']==$_username) $departmentids[] = $k;
	}
    $ids = implode(',', $departmentids);
	if($ids) $sql = " and departmentid in($ids) ";
}
else
{
    $departmentids = array_keys($departments);
}

$submenu = array();
$submenu[] = array($LANG['all'], '?mod='.$mod.'&file='.$file);
foreach($departmentids as $id)
{
    $submenu[] = array($departments[$id]['department'], '?mod='.$mod.'&file='.$file.'&departmentid='.$id);
}
$menu = adminmenu($LANG['consultation_manage'], $submenu);

$STATUS = array($LANG['unsettled'], $LANG['under_dealing'], $LANG['dealed'], $LANG['reject_deal']);

$pagesize = $PHPCMS['pagesize'];

$action=$action ? $action : 'manage';

switch($action)
{
    case 'reply':
		$askid = intval($askid);
		if(!$askid) showmessage($LANG['illegal_parameters']);

		$subject = $db->get_one("select * from ".TABLE_ASK." where askid=$askid $sql");
		if(!$subject) showmessage($LANG['sorry_not_exist_record']);

		if($dosubmit)
		{
			$reply = str_safe($reply);
			$db->query("insert into ".TABLE_ASK_REPLY."(askid,reply,username,ip,addtime) values('$askid','$reply','$_username','$PHP_IP','$PHP_TIME')");
	        $db->query("UPDATE ".TABLE_ASK." SET lastreply='$PHP_TIME' WHERE askid=$askid");

			showmessage($LANG['operation_success'],$PHP_REFERER);
		}
		else
		{
			$GROUPS = cache_read('member_group.php');

			require_once PHPCMS_ROOT.'/member/include/global.func.php';
			require_once MOD_ROOT.'/include/global.func.php';
			require_once PHPCMS_ROOT.'/include/ip.class.php';
			$getip = new ip;

			$subject['addtime'] = date('Y-m-d h:i', $subject['addtime']);

			$departmentid = $subject['departmentid'];
			extract($departments[$departmentid]);

			$memberinfo = get_member_info($subject['username']);
			$subject = array_merge($subject, $memberinfo);
			$subject['groupname'] = $GROUPS[$subject['groupid']]['groupname'];
			$subject['arrgroupname'] = get_arrgroupname($subject['arrgroupid']);
			$subject['iparea'] = $getip->getlocation($subject['ip']);

			$replys = array();
			$result = $db->query("select * from ".TABLE_ASK_REPLY." where askid=$askid");
			while($r = $db->fetch_array($result))
			{
				$r['addtime'] = date('Y-m-d h:i', $r['addtime']);
				$memberinfo = get_member_info($r['username']);
				$r = array_merge($r, $memberinfo);
				$r['groupname'] = $GROUPS[$r['groupid']]['groupname'];
				$r['arrgroupname'] = get_arrgroupname($r['arrgroupid']);
			    $r['iparea'] = $getip->getlocation($r['ip']);
				$replys[] = $r;
			}

			if($reply == '') $status = 1;

			include admintpl('reply');
		}
	    break;

	case 'delete':
		if(empty($askid)) showmessage($LANG['illegal_parameters'], $referer);

		$askids=is_array($askid) ? implode(',',$askid) : $askid;
		$db->query("DELETE FROM ".TABLE_ASK." WHERE askid IN ($askids) $sql");
		$db->query("DELETE FROM ".TABLE_ASK_REPLY." WHERE askid IN ($askids) $sql");
		showmessage($LANG['operation_success'], $PHP_REFERER);
		break;

	case 'status':
		if(empty($askid)) showmessage($LANG['illegal_parameters'], $referer);

		$askids=is_array($askid) ? implode(',',$askid) : $askid;
		$db->query("UPDATE ".TABLE_ASK." SET status=$status WHERE askid=$askid $sql");
		$db->affected_rows() ? showmessage($LANG['operation_success'], $PHP_REFERER) : showmessage($LANG['operation_failure']);
		break;

	default:
		require_once PHPCMS_ROOT.'/include/ip.class.php';
		$getip = new ip;

		if(!isset($page)) $page = 1;
		$offset = ($page-1)*$pagesize;

		$dkeywords = isset($keywords) ? str_replace(" ","%",$keywords) : "";
		$sql .= isset($keywords) ? " and (subject like '%$dkeywords%' or content like '%$dkeywords%')" : "";
		$sql .= (isset($departmentid) && $departmentid) ? " and departmentid='$departmentid' " : "";
		$sql .= isset($status) ? " and status='$status' " : '';
		$sql = $sql ? " where 1 ".$sql : "";

		$r = $db->get_one("select count(*) as number from ".TABLE_ASK." $sql order by askid desc");
		$pages = phppages($r['number'], $page, $pagesize);

        $asks = array();
		$result = $db->query("select * from ".TABLE_ASK." $sql order by askid desc limit $offset,$pagesize");
		while($r = $db->fetch_array($result))
		{
			$r['lastreply'] = $r['lastreply'] ? date('Y-m-d h:i', $r['lastreply']) : '';
			$r['addtime'] = date('Y-m-d h:i', $r['addtime']);
			$r['iparea'] = $getip->getlocation($r['ip']);
			$asks[] = $r;
		}

		if(!isset($date)) $date = date('Y-m-d');
		if(!isset($keywords)) $keywords = '';
		if(!isset($truename)) $truename = '';

		include admintpl('ask');
}
?>