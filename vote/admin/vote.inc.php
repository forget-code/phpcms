<?php
defined('IN_PHPCMS') or exit('Access Denied');

$keyid = isset($keyid) ? $keyid : 'phpcms';
$submenu=array(
	array('<font color="#0000FF">'.$LANG['add_vote'].'</font>','?mod='.$mod.'&file='.$file.'&action=add&keyid='.$keyid),
	array('<font color="#FF0000">'.$LANG['vote_manage'].'</font>','?mod='.$mod.'&file='.$file.'&action=manage&passed=1&keyid='.$keyid),
	array($LANG['vote_checked'],'?mod='.$mod.'&file='.$file.'&action=manage&passed=0&keyid='.$keyid),
	array($LANG['vote_expired'],'?mod='.$mod.'&file='.$file.'&action=manage&keyid='.$keyid.'&timeout=1'),
	array('<font color="#0000FF">'.$LANG['label_manage'].'</font>','?mod='.$mod.'&file=tag&keyid='.$keyid),
	array('<font color="#FF0000">'.$LANG['update_vote'].'</font>','?mod='.$mod.'&file='.$file.'&action=getcode&updatejs=1&keyid='.$keyid)
);
$menu = adminmenu($LANG['vote_manage'],$submenu);
$pagesize = isset($pagesize) && $pagesize<500 ? intval($pagesize) : $PHPCMS['pagesize'];
$action = $action ? $action : 'manage';
switch($action)
{	
	case 'add':
	if(isset($submit))
	{
		if(empty($subject)) showmessage($LANG['inout_vote_subject']);
		if(empty($voteoption[0])) showmessage($LANG['illegal_parameters']); 
		if(!ereg('^[01]+$',$passed)) showmessage($LANG['illegal_parameters']); 
		$db->query("INSERT INTO ".TABLE_VOTE_SUBJECT."(`keyid` , `subject` , `type` , `username` , `fromdate` , `todate` , `addtime` , `passed` , `templateid` , `skinid` , `attribute`) VALUES('$keyid','$subject','$type','$_username','$fromdate','$todate','$PHP_TIME','$passed','$templateid','$skinid','$enableTourist')");
        $voteid = $db->insert_id();
		foreach($voteoption as $optionid=>$option)
		{
			if(empty($option)) continue;
			$db->query("INSERT INTO ".TABLE_VOTE_OPTION."(`voteid` , `option`) VALUES('$voteid','$option')");
		}
        showmessage($LANG['operation_success'],"?mod=vote&file=vote&action=getcode&updatejs=1&voteid=".$voteid."&keyid=".$keyid);
    }
	else
	{
		$fromdate = date("Y-m-d",$PHP_TIME);
		$todate = $PHP_TIME+3600*24*30;
		$todate = date("Y-m-d",$todate);
		$showskin = showskin('skinid');
		$showtpl = showtpl($mod,'show','templateid');
        include admintpl('vote_add');
    } 
	break;

	case 'manage':
	if(!isset($page))
	{
		$page=1;
		$offset=0;
	}
	else
	{
		$offset = ($page-1)*$pagesize;
	}
	$passed = isset($passed) ? $passed : '1';
	$today = date("Y-m-d",$PHP_TIME);
	$timeout = isset($timeout) ? 1 : 0;
	$sql = "";
	if($keyid == 'phpcms' || !$keyid)
	{
		$sql .= 1;
	}
	else
	{
		$sql .= " keyid = '$keyid' ";
	}
	$sql .= isset($passed) ? " AND passed='$passed' " : "";
	$sql .= $timeout ? " AND todate<'$today' AND todate!='0000-00-00' " : " AND (todate>='$today' OR todate='0000-00-00') ";
	$r = $db->get_one("SELECT COUNT(voteid) AS num FROM ".TABLE_VOTE_SUBJECT." WHERE $sql");
	$number = $r['num'];
	$pages = phppages($number,$page,$pagesize);
	$result = $db->query("SELECT * FROM  ".TABLE_VOTE_SUBJECT." WHERE $sql ORDER BY voteid DESC LIMIT $offset,$pagesize");
	$votes = array();
	while($r=$db->fetch_array($result))
	{
		$r['adddate'] = date("Y-m-d",$r['addtime']);
		$r['addtime'] = date("Y-m-d H:i:s",$r['addtime']);
		$votes[]=$r;
	}
	include admintpl('vote_manage');
	break;

	case 'edit':
	if(isset($submit))
	{
		$db->query("UPDATE ".TABLE_VOTE_SUBJECT." SET subject='$subject',type='$type',fromdate='$fromdate',todate='$todate',templateid='$templateid',skinid='$skinid',attribute='$enableTourist' WHERE voteid='$voteid' ");
		foreach($voteoptionedit as $optionid=>$option)
		{
			if($option)
			{
				$db->query("UPDATE ".TABLE_VOTE_OPTION." SET `option`='$option' WHERE optionid='$optionid'");
			}
			else
			{
				$db->query("DELETE FROM ".TABLE_VOTE_OPTION." WHERE optionid='$optionid'");
			}
		}
		//Edition time new increase option
		if(isset($voteoption))
		{
			foreach($voteoption as $optionid=>$option)
			{
				if(empty($option)) continue;
				$db->query("INSERT INTO ".TABLE_VOTE_OPTION."(`voteid` , `option`) VALUES('$voteid','$option')");
			}
		}
		showmessage($LANG['operation_success'],"?mod=vote&file=vote&action=getcode&updatejs=1&voteid=".$voteid."&keyid=".$keyid);
	}
	else
	{
		@extract($db->get_one("SELECT * FROM ".TABLE_VOTE_SUBJECT."  WHERE voteid='$voteid'"));
		$result=$db->query("SELECT * FROM ".TABLE_VOTE_OPTION." WHERE voteid='$voteid'");
		$ops = array();
		while($r=$db->fetch_array($result))
		{
			$ops[]=$r;
		}
		$number = $db->num_rows($result);
		$todate = $todate>'0000-00-00' ? $todate : "";
		$showskin = showskin('skinid',$skinid);
        $showtpl = showtpl($mod,'show','templateid',$templateid);
		include admintpl('vote_edit');
	}
	break;

	case 'delete':
		if(empty($voteid)) showmessage($LANG['illegal_parameters']);

		$voteids=is_array($voteid) ? implode(',',$voteid) : $voteid;
		$db->query("DELETE FROM ".TABLE_VOTE_SUBJECT." WHERE voteid IN ($voteids)");
		if($db->affected_rows()>0)
		{
			$db->query("DELETE FROM ".TABLE_VOTE_OPTION." WHERE voteid IN ($voteids)");
			$db->query("DELETE FROM ".TABLE_VOTE_DATA." WHERE voteid IN ($voteids)");
			showmessage($LANG['operation_success'],$forward);
		}
		else
		{
			showmessage($LANG['operation_failure']);
		}
	break;

	case 'pass':
		if(empty($voteid)) showmessage($LANG['illegal_parameters'],$forward);
		if(!ereg('^[0-1]+$',$passed)) showmessage($LANG['illegal_parameters'],$forward);
		$voteids = is_array($voteid) ? implode(',',$voteid) : $voteid;
		$db->query("UPDATE ".TABLE_VOTE_SUBJECT." SET passed=$passed WHERE voteid IN ($voteids)");
		if($db->affected_rows()>0)
		{
			showmessage($LANG['operation_success'],$forward);
		}
		else
		{
			showmessage($LANG['operation_failure']);
		}
	break;
	
	case 'detail':
		require PHPCMS_ROOT."/include/ip.class.php";
		$getip = new Ip;
		if(!isset($page))
		{
			$page=1;
			$offset=0;
		}
		else
		{
			$offset = ($page-1)*$pagesize;
		}
		$r = $db->get_one("SELECT COUNT(id) AS num FROM ".TABLE_VOTE_DATA." WHERE voteid='$voteid' ORDER BY id DESC LIMIT $offset,$pagesize");
		$number = $r['num'];
		$pages = phppages($number,$page,$pagesize);
		$memberdata = array();
		$resultdata = $db->query("SELECT voteuser,votetime,ip FROM ".TABLE_VOTE_DATA." WHERE voteid='$voteid' ORDER BY id DESC LIMIT $offset,$pagesize ");
		while($rdata=$db->fetch_array($resultdata))
		{
			$rdata['vip'] = $getip->getlocation($rdata['ip']);
			$rdata['votetime'] = date("Y-m-d H:i:s",$rdata['votetime']);
			$memberdata[] = $rdata;
		}
		$i=0;
		$result = $db->query("SELECT * FROM ".TABLE_VOTE_OPTION." WHERE voteid='$voteid' ");
		$ops = array();
		while($rs=$db->fetch_array($result))
		{
			$per = $number ? round(100*$rs['number']/$number) : 0;
			$rs['per'] = $per ? $per."%" : "0";
			$rs['lenth'] = 4*$per;
			$rs['i'] = substr($i,-1,1);
			$ops[] = $rs;
			$i++;
		}
		include admintpl('vote_detail');
	break;

	case 'getcode':
	function voteform($voteid,$condition)
	{
		global $db,$MOD,$MODULE;
		$frmVote = 'frmvote'.$voteid;
		$m = $db->get_one("SELECT subject,voteid,type,fromdate,todate,totalnumber FROM ".TABLE_VOTE_SUBJECT." WHERE voteid = $voteid");
		if(!$m) return FALSE;
		extract($m);
		$result = $db->query("SELECT * FROM ".TABLE_VOTE_OPTION." WHERE voteid = $voteid");
		$totalnum = $db->num_rows($result);
		$totalnum = $totalnum-1;
		$number = 0;
		$options = '';
		$condition = '';
		while($r=$db->fetch_array($result))
		{
			$options .= "<input type='$type' name='op[]' id='op$number$voteid' value='".$r['optionid']."'>".$r['option']."<br>\n";
			$condition .= "document.getElementById('op$number$voteid').checked";
			if($totalnum!=$number)
			{
				$condition .= ' || ';
			}
			$number++;
		}		
		ob_start();
		include template('vote', 'tag_vote_show');
		$str = ob_get_contents();
		ob_clean();
		return $str;
	}
	$condition = isset($condition) ? $condition : '';
	if(!isset($updatejs))
	{
		$voteform = voteform($voteid,$condition);
		include admintpl('vote_getcode');
	}
	else
	{
		$today = date("Y-m-d",$PHP_TIME);
		$sql = isset($voteid) ? "voteid = ".$voteid : "passed=1 AND todate>'$today' OR todate='0000-00-00' ORDER BY voteid DESC ";
		$result = $db->query("SELECT voteid FROM  ".TABLE_VOTE_SUBJECT." WHERE $sql ");
		while($r = $db->fetch_array($result))
		{
			$voteid = $r['voteid'];
			$voteform = voteform($voteid,$condition);
			include PHPCMS_ROOT.'/vote/include/createhtml/updatejs.php';
		}
		showmessage($LANG['js_update_success']);
	}
	break;
}
?>