<?php
defined('IN_PHPCMS') or exit('Access Denied');

$action = $action ? $action : 'manage';
$job = $job ? $job : 'manage';
$jobs = array("manage"=>"status=3 ", "check"=>"status=1", "recycle"=>"status=-1");
array_key_exists($job, $jobs) or showmessage($LANG['illegal_action'], 'goback');
$submenu = array(
	array($LANG['apply_manage'],"?mod=$mod&file=$file&action=manage&job=manage"),
	array($LANG['recycle'],"?mod=$mod&file=$file&action=manage&job=recycle"),
	array($LANG['statistical_report'],"?mod=$mod&file=$file&action=stats"),

);
require_once PHPCMS_ROOT.'/include/tree.class.php';
$module = $mod;
$tree = new tree;

$catid = isset($catid) ? intval($catid) : 0;
if($catid) $CAT = cache_read('category_'.$catid.'.php');
$menu = adminmenu($LANG['apply_manage'],$submenu);
switch($action)
{
	case 'manage':
		
		if($job == 'manage')
		{
			$status = 'status>=3';
		}
		elseif($job == 'check')
		{
			$status = 'status=1';
		}
		else
		{
			$status = 'status=-1';
		}
		$pagesize = $PHPCMS['pagesize'];
		$page = isset($page) ? intval($page) : 1;
		$offset = ($page-1)*$pagesize;
		$srchtype = isset($srchtype) ? intval($srchtype) : 0;
		$typeid = isset($typeid) ? intval($typeid) : 0;
		$orders = array('applyid DESC', 'applyid ASC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC');
		$ordertype = isset($ordertype) ? intval($ordertype) : 0;
		$order = $orders[$ordertype];
		$category_select = category_select('catid', $LANG['please_select_catgory'], $catid);
		$category_jump = category_select('catid', $LANG['please_choose_category_manage'], $catid, "onchange=\"if(this.value!=''){location='?mod=$mod&file=$file&action=manage&typeid=$typeid&job=$job&catid='+this.value;}\"");
		$condition = '';
		$condition .= $catid ? 'AND catid='.$catid.' ' : '';
		$condition .= $typeid ? 'AND typeid='.$typeid.' ' : '';
		if(isset($keyword))
		{
			$keyword = trim($keyword);
			$keyword = str_replace(' ','%',$keyword);
			$keyword = str_replace('*','%',$keyword);
			if($srchtype==1)
			{
				$condition .= " AND school LIKE '%$keyword%' ";
			}
			elseif($srchtype==2)
			{
				$condition .= " AND specialty LIKE '%$keyword%' ";
			}
			else
			{
				$condition .= " AND edulevel = '$keyword' ";
			}
		}
		$r = $db->get_one("SELECT COUNT(applyid) AS num FROM ".TABLE_YP_APPLY." WHERE $status $condition");
		$number = $r['num'];
		$pages = phppages($number,$page,$pagesize);
		$applys = array();
		$result = $db->query("SELECT * FROM ".TABLE_YP_APPLY." WHERE $status $condition ORDER BY $order LIMIT $offset,$pagesize");		
		while($r = $db->fetch_array($result))
		{
			$r['addtime'] = date('Y-m-d',$r['addtime']);
			$r['edittime'] = date('Y-m-d H:i:s',$r['edittime']);
			@extract($db->get_one("SELECT userid FROM ".TABLE_MEMBER." WHERE username = '$r[username]'"));
			@extract($db->get_one("SELECT truename,edulevel FROM ".TABLE_MEMBER_INFO." WHERE userid = '$userid'"));
			$r['domain'] = $PHPCMS['siteurl']."yp/web/?".$userid."/";
			$r['truename'] = $truename;
			$r['edulevel'] = $edulevel;
			$applys[] = $r;
		}
		$station = isset($station) ? $station : '';
		$station_select = '<select id="station" name="station">';
		$station_select .= '<option value="0">'.$LANG['choose_station'].'</option>';
		$station_selects = explode("\n",$MOD['station']);
		foreach($station_selects AS $v)
		{
			$selected = '';
			if($station == $v) $selected = 'selected="selected"';
			$station_select .= '<option value="'.$v.'" '.$selected.'>'.$v.'</option>';
		}
		$station_select .= '</select>';
	include admintpl('apply_'.$job);
	break;

case 'listorder':

	if(empty($listorder) || !is_array($listorder))
	{
		showmessage($LANG['illegal_parameters']);
	}

	foreach($listorder as $key=>$val)
	{
		$db->query("UPDATE ".TABLE_YP_APPLY." SET `listorder`='$val' WHERE applyid=$key ");
	}

	showmessage($LANG['update_success'],$forward);

break;

case 'status' :
	if(empty($applyid))
	{
		showmessage($LANG['illegal_parameters']);
	}
	if(!is_numeric($status))
	{
		showmessage($LANG['illegal_parameters']);
	}
	$applyids = is_array($applyid) ? implode(',',$applyid) : $applyid;
	$db->query("UPDATE ".TABLE_YP_APPLY." SET status=$status WHERE applyid IN ($applyids)");
	if($db->affected_rows()>0)
	{
		showmessage($LANG['operation_success'],$forward);
	}
	else
	{
		showmessage($LANG['operation_failure']);
	}
	break;
case 'truncate':
	$db->query("DELETE FROM ".TABLE_YP_APPLY." WHERE status='-1'");
	showmessage($LANG['operation_success'],$forward);
	break;
case 'delete':
	if(empty($applyid))
	{
		showmessage($LANG['illegal_parameters']);
	}
	$applyids = is_array($applyid) ? implode(',',$applyid) : $applyid;
	$db->query("DELETE FROM ".TABLE_YP_APPLY." WHERE applyid IN ($applyids)");
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
	if($dosubmit)
	{
		$apply['introduce'] = htmlspecialchars($apply['introduce']);
		$apply['story'] = htmlspecialchars($apply['story']);
		$sql = $s = "";
		foreach($apply as $key=>$value)
		{
			$sql .= $s.$key."='".$value."'";
			$s = ",";
		}
		$db->query("UPDATE ".TABLE_YP_APPLY." SET $sql WHERE applyid='$applyid'");
		showmessage($LANG['operation_success'],$forward);

	}
	else
	{
		$applyid = isset($applyid) ? intval($applyid) : '';
		if($dosubmit)
		{
			$job['edittime'] = $PHP_TIME;
			$job['introduce'] = strip_tags($job['introduce']);
			$sql = $s = "";
			foreach($apply as $key=>$value)
			{
				$sql .= $s.$key."='".$value."'";
				$s = ",";
			}
			$db->query("UPDATE ".TABLE_YP_APPLY." SET $sql WHERE applyid='$applyid' AND username='$_username'");
			if($db->affected_rows()>0)
			{
				createhtml('apply','web');
				showmessage($LANG['operation_success'],$forward);
			}
			else
			{
				showmessage($LANG['operation_failure']);
			}
		}
		else
		{
			@extract($db->get_one("SELECT * FROM ".TABLE_YP_APPLY." WHERE applyid='$applyid'"),EXTR_OVERWRITE);

			$montharr = array('01','02','03','04','05','06','07','08','09','10','11','12');
			$dayarr = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');

			@extract($db->get_one("SELECT address,telephone,userface,truename,gender,birthday,idtype,idcard,province,city,area,edulevel FROM ".TABLE_MEMBER_INFO." WHERE userid='$_userid'"));
			$birthday = explode("-", $birthday);
			$byear = $birthday[0]=="0000" ? "19" : $birthday[0];
			$bmonth = $birthday[1];
			$bday = $birthday[2];
			$editstation = '<select id="station" name="apply[station]">';
			$stations = explode("\n",$MOD['station']);
			foreach($stations AS $v)
			{
				$selected = '';
				if($station == $v) $selected = 'selected';
				$editstation .= '<option value="'.$v.'" '.$selected.'>'.$v.'</option>';
			}
			$editstation .= '</select>';
			include admintpl('apply_edit');
		}
	}
	break;

	case 'editmemberinfo':
		$byear = intval($byear);
		$byear = $byear==19 ? '0000' : $byear;
		$bmonth = intval($bmonth);
		$bday = intval($bday);

		$birthday = $byear.'-'.$bmonth.'-'.$bday;
		if(!preg_match("/[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}/", $birthday)) $birthday = '0000-00-00';
		if(strlen($truename)>50) showmessage($LANG['truename_longth'],"goback");
		$db->query("UPDATE ".TABLE_MEMBER_INFO." SET truename='$truename',gender='$gender',birthday='$birthday',idtype='$idtype',idcard='$idcard',province='$province',city='$city',area='$area',edulevel='$edulevel',userface='$userface',address='$address',telephone='$telephone' WHERE userid='$_userid'");
		$db->query("UPDATE ".TABLE_MEMBER." SET email='$email' WHERE userid='$_userid'");
		showmessage($LANG['basic_edit_succss'],$forward);
	break;

	case 'stats':
		$sql = '';
		$stations = explode("\n",$MOD['station']);
		$station = '';
		$total = 0;
		$id = 1;
		foreach($stations as $k => $v)
		{
			$r = $db->get_one("select count(applyid) as num from ".TABLE_YP_APPLY." where station='$v' $sql ");
			$str = urlencode($v);
			$station .= "<tr onmouseout=this.style.backgroundColor='#F1F3F5' onmouseover=this.style.backgroundColor='#BFDFFF' bgColor='#F1F3F5' height='23'>
						<td>$id</td>
						<td><span style='float:left;font-size:12px;'>$v</span></td>
						<td><span style='float:left;font-size:10px;'>$r[num]</td>
						</tr>
			";
			$total += $r['num'];
			$id++;
		}		
		include admintpl('apply_stats');
	break;
}
?>