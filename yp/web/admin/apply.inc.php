<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$submenu = array(
	array($LANG['person_database'],"?file=$file&action=manage"),
);
require PHPCMS_ROOT.'/admin/include/global.func.php';
$menu = adminmenu($LANG['job_manage'],$submenu);
if($action == 'edit')
{
	@extract($db->get_one("SELECT applyid FROM ".TABLE_YP_APPLY." WHERE username = '$_username'"));
	$action = isset($applyid) ? 'edit' : 'add';
}
switch($action)
{
	case 'manage':
		$pagesize = $PHPCMS['pagesize'];
		$page = isset($page) ? intval($page) : 1;
		$offset = ($page-1)*$pagesize;
		$bs = $db->query("SELECT jobid FROM ".TABLE_YP_JOB." WHERE username='$_username'");
		while($bk = $db->fetch_array($bs))
		{
			$jobids .= $bk['jobid'].',';
		}
		$jobids = substr($jobids,0,-1);
		$stocks = array();
		if($jobids !='')
		{
			$condition = " AND jobid in($jobids)";
			$r = $db->get_one("SELECT COUNT(stockid) AS num FROM ".TABLE_YP_STOCK." WHERE label=1 $condition");
			$number = $r['num'];
			$pages = phppages($number,$page,$pagesize);
			$result = $db->query("SELECT * FROM ".TABLE_YP_STOCK." WHERE label=1 $condition ORDER BY stockid DESC LIMIT $offset,$pagesize");		
			while($r = $db->fetch_array($result))
			{
				if(!$r['jobid']) continue;
				extract($db->get_one("SELECT j.title,j.station,j.companyid,j.period,j.edittime,j.linkurl, c.companyname FROM ".TABLE_MEMBER_COMPANY." c, ".TABLE_YP_JOB." j WHERE j.jobid='$r[jobid]'"));
				$r['title'] = $title;
				$r['station'] = $station;
				$r['linkurl'] = $linkurl;
				$r['companyname'] = $companyname;
				$r['addtime'] = date('Y-m-d',$r['addtime']);
				if($period==0) $period = 8640000;
				$periodtime = intval($period*86400+$edittime);
				if($periodtime>$PHP_TIME)
				{
					$r['period'] = 1;
				}
				else
				{
					$r['period'] = 0;
				}
				$stocks[] = $r;
			}
		}
		include managetpl('apply_manage');
		break;

	case 'show':
			$stockid = intval($stockid);
			$db->query("UPDATE ".TABLE_YP_STOCK." SET status=1 WHERE stockid='$stockid' AND status=0");
			extract($db->get_one("SELECT jobid,username FROM ".TABLE_YP_STOCK." WHERE stockid='$stockid'"));
			extract($db->get_one("SELECT userid FROM ".TABLE_MEMBER." WHERE username='$username'"));
			extract($db->get_one("SELECT address,telephone,userface,truename,gender,birthday,idtype,idcard,province,city,area,edulevel FROM ".TABLE_MEMBER_INFO." WHERE userid='$userid'"));
			extract($db->get_one("SELECT * FROM ".TABLE_YP_APPLY." WHERE username='$username'"));
			$idcard = substr($idcard,0,10);
			include managetpl('apply_'.$action);
	break;

	case 'delete':
		if(empty($stockid))
		{
			showmessage($LANG['illegal_parameters']);
		}
		$stockids = is_array($stockid) ? implode(',',$stockid) : $stockid;
		$db->query("DELETE FROM ".TABLE_YP_STOCK." WHERE stockid IN ($stockids) AND label=1");
		if($db->affected_rows()>0)
		{
			showmessage($LANG['operation_success'],$forward);
		}
		else
		{
			showmessage($LANG['operation_failure']);
		}
		break;
	
	case 'interview':
		$stockid = intval($stockid);
		$db->query("UPDATE ".TABLE_YP_STOCK." SET status=2 WHERE stockid='$stockid' AND username='$username'");
		if($db->affected_rows()>0)
		{
			showmessage($LANG['invited_send_success'],$forward);
		}
		else
		{
			showmessage($LANG['already_invited']);
		}
	break;
}

?>