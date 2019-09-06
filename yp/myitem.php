<?php 
require './include/common.inc.php';
$action = isset($action) ? $action : 'manage';
if(!$_username) showmessage($LANG['please_login'],$PHPCMS['siteurl'].'member/login.php?forward='.$PHP_URL);
if($action == 'edit')
{
	@extract($db->get_one("SELECT applyid FROM ".TABLE_YP_APPLY." WHERE username = '$_username'"));
	$action = isset($applyid) ? 'edit' : 'add';
}
switch($action)
{
	case 'add':
		if($dosubmit)
		{
			$apply['introduce'] = str_safe($apply['introduce']);
			$apply['username'] = $apply['editor'] = $_username;
			$apply['addtime'] = $apply['edittime'] = $apply['listorder'] = $PHP_TIME;
			$sql1 = $sql2 = $s = "";
			foreach($apply as $key=>$value)
			{
				$sql1 .= $s.$key;
				$sql2 .= $s."'".$value."'";
				$s = ",";
			}
			$sql = "INSERT INTO ".TABLE_YP_APPLY." ($sql1) VALUES($sql2)";
			$result = $db->query($sql);
			if($db->affected_rows($result))
			$applyid = $db->insert_id();
			$linkurl = $MODULE['yp']['linkurl'].'apply.php?item-'.$applyid.'.html';
			$db->query("UPDATE ".TABLE_YP_APPLY." SET status=3,linkurl='$linkurl' WHERE applyid=$applyid ");
			showmessage('添加成功',$forward);
		}
		else
		{
			$montharr = array('01','02','03','04','05','06','07','08','09','10','11','12');
			$dayarr = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
			$station = '<select id="station" name="apply[station]">';
			$stations = explode("\n",$MOD['station']);
			foreach($stations AS $v)
			{
				$station .= '<option value="'.$v.'">'.$v.'</option>';
			}
			$station .= '</select>';
			@extract($db->get_one("SELECT address,telephone,userface,truename,gender,birthday,idtype,idcard,province,city,area,edulevel FROM ".TABLE_MEMBER_INFO." WHERE userid='$_userid'"));
			$birthday = explode("-", $birthday);
			$byear = $birthday[0]=="0000" ? "19" : $birthday[0];
			$bmonth = $birthday[1];
			$bday = $birthday[2];
			include template($mod, 'myitem_add');
		}
	break;
	case 'manage':
		$label = isset($label) ? intval($label) : 0;
		$pagesize = $PHPCMS['pagesize'];
		if(!isset($page) || $page == '') $page = 1;
		$page = intval($page);
		$offset = ($page-1)*$pagesize;
		$condition = " AND username='$_username'";
		$r = $db->get_one("SELECT COUNT(stockid) AS num FROM ".TABLE_YP_STOCK." WHERE label=$label $condition");
		$number = $r['num'];
		$pages = phppages($number,$page,$pagesize);
		$applys = array();
		$result = $db->query("SELECT * FROM ".TABLE_YP_STOCK." WHERE label=$label $condition ORDER BY stockid DESC LIMIT $offset,$pagesize");		
		while($r = $db->fetch_array($result))
		{
			$rj = $db->get_one("SELECT title,station,companyid,period,edittime,linkurl FROM ".TABLE_YP_JOB." WHERE jobid='$r[jobid]'");
			if($rj) extract($rj);
			extract($db->get_one("SELECT companyname FROM ".TABLE_MEMBER_COMPANY." WHERE companyid='$companyid'"));
			$r['title'] = $title;
			$r['station'] = $station;
			$r['linkurl'] = $linkurl;
			$r['companyname'] = $companyname;
			$r['addtime'] = date('Y-m-d',$r['addtime']);
			$periodtime = intval($period*86400+$edittime);
			if($periodtime>=$PHP_TIME || $period==0)
			{
				$r['period'] = 1;
			}
			else
			{
				$r['period'] = 0;
			}
			$stocks[] = $r;
		}
		$templateid = $label ? 'myitem_record' : 'myitem_manage';
		include template($mod, $templateid);

		break;

	case 'edit':
		$applyid = isset($applyid) ? intval($applyid) : '';
		if($dosubmit)
		{
			$apply['edittime'] = $PHP_TIME;
			$apply['introduce'] = str_safe($apply['introduce']);
			$apply['linkurl'] = $MODULE['yp']['linkurl'].'apply.php?item-'.$applyid.'.html';
			$sql = $s = "";
			foreach($apply as $key=>$value)
			{
				$sql .= $s.$key."='".$value."'";
				$s = ",";
			}
			$db->query("UPDATE ".TABLE_YP_APPLY." SET $sql WHERE applyid='$applyid' AND username='$_username'");
			if($db->affected_rows()>0)
			{
				
				showmessage($LANG['operation_success'],$forward);
			}
			else
			{
				showmessage($LANG['operation_failure']);
			}
		}
		else
		{
			$montharr = array('01','02','03','04','05','06','07','08','09','10','11','12');
			$dayarr = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');

			@extract($db->get_one("SELECT address,telephone,userface,truename,gender,birthday,idtype,idcard,province,city,area,edulevel FROM ".TABLE_MEMBER_INFO." WHERE userid='$_userid'"));
			$birthday = explode("-", $birthday);
			$byear = $birthday[0]=="0000" ? "19" : $birthday[0];
			$bmonth = $birthday[1];
			$bday = $birthday[2];
			extract($db->get_one("SELECT * FROM ".TABLE_YP_APPLY." WHERE applyid='$applyid' AND username='$_username'"));
			
			$editstation = '<select id="station" name="apply[station]">';
			$stations = explode("\n",$MOD['station']);
			foreach($stations AS $v)
			{
				$selected = '';
				if($station == $v) $selected = 'selected';
				$editstation .= '<option value="'.$v.'" '.$selected.'>'.$v.'</option>';
			}
			$editstation .= '</select>';
			include template($mod,'myitem_'.$action);
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

	case 'delete':
		if(empty($stockid))
		{
			showmessage($LANG['illegal_parameters']);
		}
		$stockids = is_array($stockid) ? implode(',',$stockid) : $stockid;
		$db->query("DELETE FROM ".TABLE_YP_STOCK." WHERE stockid IN ($stockids) AND username='$_username'");
		if($db->affected_rows()>0)
		{
			showmessage($LANG['operation_success'],$forward);
		}
		else
		{
			showmessage($LANG['operation_failure']);
		}
		break;
	case 'update':
		$db->query("UPDATE ".TABLE_YP_APPLY." SET edittime = $PHP_TIME WHERE username='$_username'");
		echo 1;
	break;
}

?>