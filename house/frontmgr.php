<?php
require './include/common.inc.php';
require PHPCMS_ROOT.'/include/area.func.php';
require PHPCMS_ROOT.'/include/tree.class.php';
$tree = new tree;
$MOD['enablecontribute'] or showmessage('系统关闭了前台提交信息的功能', 'goback');

$head['title'] = $MOD['seo_title'];
$head['keywords'] = $MOD['seo_keywords'];
$head['description'] = $MOD['seo_description'];

$action = isset($action)? $action : 'manage';

if(!$_userid && $action != 'add') showmessage('游客无权限进行此操作', 'goback');
$forward = $MOD['linkurl'].'frontmgr.php?action='.$action.'&type='.$type;
if(!$_userid && !$MOD['enable_guest_add'])
{
	header('Location:'.$PHPCMS['siteurl'].'member/login.php?forword='.$forward);
}
$houseid = isset($houseid) ? intval($houseid) : 0;
$pagesize = $PHPCMS['pagesize'];
$referer = isset($referer) ? $referer : $PHP_REFERER;
$action = isset($action) ? $action : 'manage';
if(!isset($checkcodestr)) $checkcodestr = '';

$type = isset($type) ? intval($type) : 1;
if($type > 6 || $type < 1) $type = 1;
$types = array(1=>'出租',2=>'求租',3=>'合租',4=>'出售',5=>'求购',6=>'置换');

$fields = include MOD_ROOT.'/include/fields_house.php';

switch($action)
{
	case 'add':
		if($dosubmit)
		{
			checkcode($checkcodestr, $MOD['enablecheckcode'], $forward);
			if(!$house['validperiod']) showmessage('没有指定信息的有效期限', 'goback');
			if(!$house['areaid']) showmessage('没有指定区域', 'goback');
			if(!$house['address']) showmessage('没有指定信息的详细地址', 'goback');		
			//赋值处理
			$infocat = $house['infocat'] = intval($type);
			$house['validperiod'] = intval($house['validperiod']);
			if($house['validperiod']<1) $house['validperiod'] = 1;
            $house['endtime'] = $PHP_TIME + $house['validperiod']*86400;
			$house['areaid'] = intval($house['areaid']);
			$house['buildarea'] = sprintf('%01.2f',$house['buildarea']);
			$house['usearea'] = sprintf('%01.2f',$house['usearea']);
			$house['decorate'] = intval($house['decorate']);
			if(isset($house['infrastructure'])) $house['infrastructure'] = implode(',',$house['infrastructure']);
			if(isset($house['indoor'])) $house['indoor'] = implode(',',$house['indoor']);
			if(isset($house['peripheral'])) $house['peripheral'] = implode(',',$house['peripheral']);
			$house['addtime'] = $PHP_TIME;
			$house['username'] = $_username;
			$house['urlruleid'] = $MOD['houseishtml'] ? $MOD['houseitem_html_urlruleid'] : $MOD['houseitem_php_urlruleid'];
			$house['ishtml'] = $MOD['houseishtml'];
			$house['htmldir'] = '';
			$house['prefix'] = $PARS['infotype']['typename_'.$type].'_';
			$house['housetype'] = $type_1.','.$type_2.','.$type_3.','.$type_4;
			$house['description'] = str_safe($house['description']);
			$house = new_htmlspecialchars($house);
			$house['status'] = $MOD['enablecheck'] ? 0 : 1;

			$r = $db->get_one("SELECT my_house_membertype,my_house_corpname FROM ".TABLE_MEMBER_INFO." WHERE userid=$_userid");
			$house['isinter'] = $r['my_house_membertype'];
			$house['corpname'] = $r['my_house_corpname'];

			$keys = $values = $s = '';
			foreach($house as $key => $value)
			{
				if(!in_array($key, $fields)) continue;
				$keys .= $s.$key;
				$values .= $s."'".$value."'";
				$s = ',';
			}
			$db->query("INSERT INTO ".TABLE_HOUSE." ($keys) VALUES($values)");
			$houseid = $db->insert_id();		
			
			if($type ==3)//合租的情况
			{
				$coop = new_htmlspecialchars($coop);
				$coop['houseid'] = $houseid;
				$keys = $values = $s = '';
				foreach($coop as $key => $value)
				{
					$keys .= $s.$key;
					$values .= $s."'".$value."'";
					$s = ',';
				}
				$db->query("INSERT INTO ".TABLE_HOUSE_COOP." ($keys) values($values)");
			}		
			
			update_house_url($houseid);

			if($MOD['ishtml']) createhtml('index');
			if($MOD['houseishtml']) createhtml('showinfo');
			if($MOD['createlistinfo']) {$infocat = $type; createhtml("listinfo");}

			if($MOD['add_point'])
			{
				$db->query("update ".TABLE_MEMBER." set point=point+$MOD[add_point] where userid=$_userid");
			}
			showmessage('信息发布成功！', $PHP_REFERER);
		}
		else
		{
			$infotype = $PARS['infotype']['type_'.$type];
			$email = $_email;
		}
	break;

	case 'edit':

		$houseid or showmessage('没有指定信息的ID！', 'goback');
		if($dosubmit)
		{
			checkcode($checkcodestr, $MOD['enablecheckcode'], $forward);
			if(!$house['validperiod']) showmessage('没有指定信息的有效期限', 'goback');
			if(!$house['areaid']) showmessage('没有指定区域', 'goback');
			if(!$house['address']) showmessage('没有指定信息的详细地址', 'goback');

			$r = $db->get_one("SELECT username FROM ".TABLE_HOUSE." WHERE houseid=$houseid");
			if($r['username'] != $_username) showmessage('您没有编辑该用户房产信息的权限！', 'goback');
				
			//赋值处理
			$house['infocat'] = intval($type);
			$house['validperiod'] = intval($house['validperiod']);
			$house['validperiod'] = intval($house['validperiod']);
			if($house['validperiod']<1) $house['validperiod'] = 1;
			$house['areaid'] = intval($house['areaid']);
			$house['buildarea'] = sprintf('%01.2f',$house['buildarea']);
			$house['usearea'] = sprintf('%01.2f',$house['usearea']);
			$house['decorate'] =intval($house['decorate']);
			if(isset($house['infrastructure'])) $house['infrastructure'] = implode(',',$house['infrastructure']);
			if(isset($house['indoor'])) $house['indoor'] = implode(',',$house['indoor']);
			if(isset($house['peripheral'])) $house['peripheral'] = implode(',',$house['peripheral']);
			$house['username'] = $_username;
			$house['housetype'] = $type_1.','.$type_2.','.$type_3.','.$type_4;
			$house['description'] = str_safe($house['description']);
			$house = new_htmlspecialchars($house);
			
			//更新SQL
			$sql = $s = '';
			foreach($house as $key=>$value)
			{
				if(!in_array($key, $fields)) continue;
				$sql .= $s.$key."='".$value."'";
				$s = ',';
			}
			$timeadd = $house['validperiod']*86400;
			$db->query("UPDATE ".TABLE_HOUSE." SET $sql,endtime=addtime+$timeadd WHERE houseid=$houseid");		
			
			if($type == 3)//合租的情况
			{
				$coop = new_htmlspecialchars($coop);
				$coop['houseid'] = $houseid;
				$keys = $values = $s = '';
				foreach($coop as $key => $value)
				{
					$keys .= $s.$key;
					$values .= $s."'".$value."'";
					$s = ',';
				}
				$db->query("REPLACE INTO ".TABLE_HOUSE_COOP." ($keys) values($values)");
			}
			if($MOD['ishtml']) createhtml('index');
			if($MOD['houseishtml']) createhtml('showinfo');
			if($MOD['createlistinfo']) {$infocat = $type; createhtml("listinfo");}
			showmessage('信息修改成功！', $PHP_REFERER);
		}
		else
		{
			$r = $db->get_one("SELECT * FROM ".TABLE_HOUSE." WHERE houseid=$houseid");
			if(!$r) showmessage('信息不存在！', 'goback');
			if($r['username'] != $_username) showmessage('您无权编辑他人发布的信息！', 'goback');
			if($r['disabled']) showmessage('信息已被管理员禁用，您无权编辑！', 'goback');
			extract($r);
			$type = $infocat;
			$infotype = $PARS['infotype']['type_'.$type];
			if($type == 3)
			{
				$r = $db->get_one("SELECT * FROM ".TABLE_HOUSE_COOP." WHERE houseid=$houseid");
				@extract($r);
			}
			$housetype = explode(',', $housetype);
			$type_1 = $housetype[0];
			$type_2 = $housetype[1];
			$type_3 = $housetype[2];
			$type_4 = $housetype[3];
			$infrastructure = explode(',', $infrastructure);
			$indoor = explode(',', $indoor);
			$peripheral = explode(',', $peripheral);
		}
	break;

	case 'delete':

		$houseid or showmessage("没有指定信息的ID", ' goback'); 
		$db->query("DELETE FROM ".TABLE_HOUSE." WHERE houseid=$houseid AND username='$_username'");
		if($db->affected_rows()>0)
		{
			showmessage("指定的房产信息删除成功",$referer);
		}
		else
		{
			showmessage("删除失败,请确认提交来源及是否存在权限", 'goback');
		}
		break;

	case 'manage':

		$type = isset($type) ? $type : 1;
		$infotype = $PARS['infotype']['type_'.$type];
		$ordertime = isset($ordertime) ? intval($ordertime) : 0;
		$searchtype = isset($searchtype) ? trim($searchtype) : 'title';
		$keywords = isset($keywords) ? trim($keywords) : '';
		if($ordertime<0 || $ordertime>5) $ordertime = 0;
		if(!isset($page))
		{
			$page=1;
			$offset=0;
		}
		else
		{
			$offset=($page-1)*$pagesize;
		}

		$ordertimes = array('listorder DESC, houseid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC');

		$status = isset($status) ? intval($status) : 1;
		$overdue = isset($overdue) ? intval($overdue) : 0;
		
		$sql = '';
		if(!empty($keywords))
		{
			$keyword = str_replace(array(' ','*'),array('%','%'),$keywords);
			$searchtypes = array('title', 'author');
			$searchtype = in_array($searchtype, $searchtypes) ? $searchtype : 'title';
			$sql.= " AND $searchtype LIKE '%$keyword%' ";
		}
		if(isset($type) && is_numeric($type))
		{
			$sql.= " AND infocat=$type ";
		}
		if($overdue) $sql.= " AND endtime<$PHP_TIME ";

		$r = $db->get_one("SELECT COUNT(houseid) as num FROM ".TABLE_HOUSE." WHERE username='$_username' AND status=$status $sql ");
		$number = $r['num'];
		$pages = phppages($number, $page, $pagesize);

		$houses = array();
		$result = $db->query("SELECT * FROM ".TABLE_HOUSE." WHERE username='$_username' AND status=$status $sql ORDER BY $ordertimes[$ordertime] LIMIT $offset,$pagesize ");
		if($db->num_rows($result)>0)
		{
			while($r = $db->fetch_array($result))
			{
				$r['linkurl'] = $r['status'] ==1 ? linkurl($r['linkurl']) : $MOD['linkurl'].'frontmgr.php?action=edit&houseid='.$r['houseid'];
				$r['adddate'] = date('Y-m-d', $r['addtime']);
				$housetypearr = explode(',', $r['housetype']);
				$housetype = '';
				$stw = array('室','厅','卫','阳台');
				foreach ($housetypearr as $k=>$v)
				{
					$housetype .= $v == '不限' ? '' : $v.$stw[$k];
				}
				$r['housetype'] = $housetype;
				$houses[] = $r;
			}
		}
	    break;
}

$head['title'] = "管理我发布的房产信息";
$head['keywords'] = "管理我发布的房产信息";
$head['description'] = "管理我发布的房产信息";
if($MOD['moduledomain'] && strpos($PHP_URL, $MOD['moduledomain'])!==false)
{
	
   header('Location:'.$PHPCMS['siteurl'].'/'.$MOD['moduledir'].'/frontmgr.php?'.$PHP_QUERYSTRING);
}
if($_userid)
{
	$r = $db->get_one("SELECT my_house_membertype,my_house_corpname,truename,telephone,mobile,qq,msn FROM ".TABLE_MEMBER_INFO." WHERE userid=$_userid");
	if(!$r['my_house_membertype']) showmessage('您尚未设置了用户类型，请先进行设置后再添加信息！', $PHPCMS['siteurl'].'/'.$MOD['moduledir'].'/membertype.php?forward='.urlencode($PHP_URL));
	extract($r);
}
include template('house','frontmgr');
?>