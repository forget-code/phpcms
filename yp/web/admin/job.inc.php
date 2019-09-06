<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$submenu = array(
	array($LANG['job_manage'],"?file=$file&action=manage&status=3"),
	array($LANG['add_job'],"?file=job&action=add"),
	array($LANG['recycle'],"?file=$file&action=manage&status=-1"),
);
require PHPCMS_ROOT.'/admin/include/global.func.php';
$menu = adminmenu($LANG['job_manage'],$submenu);
$action = $action ? $action : 'manage';
$username = $_username;
switch($action)
{
	case 'add':
		if($dosubmit)
		{
			if(trim($job['introduce'])=='') showmessage($LANG['station_intro'],'goback');
			$job['introduce'] = str_safe($job['introduce']);
			$job['username'] = $job['editor'] = $_username;
			$job['addtime'] = $job['edittime'] = $job['listorder'] = $PHP_TIME;
			$sql1 = $sql2 = $s = "";
			foreach($job as $key=>$value)
			{
				$sql1 .= $s.$key;
				$sql2 .= $s."'".$value."'";
				$s = ",";
			}
			$sql = "INSERT INTO ".TABLE_YP_JOB." ($sql1) VALUES($sql2)";
			$result = $db->query($sql);
			if($db->affected_rows($result))
			$jobid = $db->insert_id();
			$enterprise = '';
			if(!$MOD['enableSecondDomain'])
			{
				$linkurl = $MODULE['yp']['linkurl'].'web/job.php?enterprise-'.$domainName.'/item-'.$jobid.'.html';
			}
			else
			{
				$linkurl = $mydomain.'/job.php?item-'.$jobid.'.html';
			}
			$db->query("UPDATE ".TABLE_YP_JOB." SET linkurl='$linkurl' WHERE jobid=$jobid ");
			
			extract($db->get_one("SELECT banner,background,introduce FROM ".TABLE_MEMBER_COMPANY." WHERE username='$_username'"));
			if($background)
			{
				$backgrounds = explode('|',$background);
				$backgroundtype = $backgrounds[0];
				$background = $backgrounds[1];
			}
			createhtml('header',PHPCMS_ROOT.'/yp/web');
			createhtml('job',PHPCMS_ROOT.'/yp/web');
			createhtml('index',PHPCMS_ROOT.'/yp/web');
			showmessage($LANG['add_success'],"?file=job");
		}
		else
		{
			if($MOD['ischeck'] && $companystatus!=3) showmessage($LANG['watting_checked']);
			if($vip && $PHP_TIME>$vip) showmessage($LANG['please_buy_vip']);
			$arrgroupidview_post = explode(',',$MOD['arrgroupidview_post']);
			$arrgroupidpost = FALSE;
			if(in_array($_groupid,$arrgroupidview_post)) $arrgroupidpost = TRUE;
			require_once PHPCMS_ROOT.'/include/tree.class.php';
			$tree = new tree;
			$AREA = cache_read('areas_'.$mod.'.php');
			require_once PHPCMS_ROOT.'/include/area.func.php';
			$station = '<select id="station" name="job[station]">';
			$stations = explode("\n",$MOD['station']);
			foreach($stations AS $v)
			{
				$station .= '<option value="'.$v.'">'.$v.'</option>';
			}
			$station .= '</select>';
			@extract($db->get_one("SELECT companyid,address,telephone,email FROM ".TABLE_MEMBER_COMPANY." WHERE username='$_username'"));

			$style_edit = style_edit('job[style]','');
			break;
		}

	case 'manage':
		$status = isset($status) ? intval($status) : 3;
		$pagesize = $PHPCMS['pagesize'];
		$page = isset($page) ? intval($page) : 1;
		$offset = ($page-1)*$pagesize;
		$condition = " AND username='$_username'";
		$r = $db->get_one("SELECT COUNT(jobid) AS num FROM ".TABLE_YP_JOB." WHERE status=$status $condition");
		$number = $r['num'];
		$pages = phppages($number,$page,$pagesize);
		$jobs = array();
		$result = $db->query("SELECT * FROM ".TABLE_YP_JOB." WHERE status=$status $condition ORDER BY edittime DESC LIMIT $offset,$pagesize");		
		while($r = $db->fetch_array($result))
		{
			$r['addtime'] = date('Y-m-d',$r['addtime']);
			$r['edittime'] = date('Y-m-d H:i:s',$r['edittime']);
			$jobs[] = $r;
		}
		break;
	case 'delete':
		if(empty($jobid))
		{
			showmessage($LANG['illegal_parameters']);
		}
		$filepath = PHPCMS_ROOT.'/yp/web/userdata/'.$_userdir.'/'.$domainName.'/job/';
		if(is_array($jobid))
		{
			foreach($jobid AS $id)
			{
				$htmlfilename = $filepath.$id.'.php';
				@unlink($htmlfilename);
			}
		}
		else
		{
				$htmlfilename = $filepath.$jobid.'.php';
				@unlink($htmlfilename);
		}
		$jobids=is_array($jobid) ? implode(',',$jobid) : $jobid;
		$db->query("DELETE FROM ".TABLE_YP_JOB." WHERE jobid IN ($jobids) AND username='$_username'");
		if($db->affected_rows()>0)
		{
			createhtml('index',PHPCMS_ROOT.'/yp/web');
			showmessage($LANG['operation_success'],$forward);
		}
		else
		{
			showmessage($LANG['operation_failure']);
		}
	break;

	case 'status':
		if(empty($jobid))
		{
			showmessage($LANG['illegal_parameters']);
		}

		$jobids=is_array($jobid) ? implode(',',$jobid) : $jobid;
		$db->query("UPDATE ".TABLE_YP_JOB." SET status=$status WHERE jobid IN ($jobids) AND username='$_username'");
		if($db->affected_rows()>0)
		{
			showmessage($LANG['operation_success'],$forward);
		}
		else
		{
			showmessage($LANG['operation_failure']);
		}
		break;
	case 'edit':
		$jobid = isset($jobid) ? intval($jobid) : '';
		if($dosubmit)
		{
			if(trim($job['introduce'])=='') showmessage($LANG['station_intro'],'goback');
			$job['edittime'] = $PHP_TIME;
			$job['introduce'] = str_safe($job['introduce']);
			$sql = $s = "";
			foreach($job as $key=>$value)
			{
				$sql .= $s.$key."='".$value."'";
				$s = ",";
			}
			$db->query("UPDATE ".TABLE_YP_JOB." SET $sql WHERE jobid='$jobid' AND username='$_username'");
			if($db->affected_rows()>0)
			{
				extract($db->get_one("SELECT banner,background FROM ".TABLE_MEMBER_COMPANY." WHERE username='$_username'"));
				if($background)
				{
					$backgrounds = explode('|',$background);
					$backgroundtype = $backgrounds[0];
					$background = $backgrounds[1];
				}
				createhtml('job',PHPCMS_ROOT.'/yp/web');
				createhtml('index',PHPCMS_ROOT.'/yp/web');
				showmessage($LANG['operation_success'],$forward);
			}
			else
			{
				showmessage($LANG['operation_failure']);
			}
		}
		else
		{
			require_once PHPCMS_ROOT.'/include/tree.class.php';
			$tree = new tree;
			$AREA = cache_read('areas_'.$mod.'.php');
			require_once PHPCMS_ROOT.'/include/area.func.php';
			extract($db->get_one("SELECT * FROM ".TABLE_YP_JOB." WHERE jobid='$jobid' AND username='$_username'"));
			$style_edit = style_edit('job[style]',$style);
		}
	break;

	case 'update':
		$db->query("UPDATE ".TABLE_YP_JOB." SET edittime='$PHP_TIME' WHERE jobid='$jobid' AND username='$_username'");
		exit;
	break;
}
include managetpl('job_'.$action);
?>