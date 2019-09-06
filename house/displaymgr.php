<?php
require './include/common.inc.php';
require PHPCMS_ROOT.'/include/area.func.php';

$MOD['enablecontribute'] or showmessage('系统关闭了前台提交信息的功能', 'goback');

$head['title'] = $MOD['seo_title'];
$head['keywords'] = $MOD['seo_keywords'];
$head['description'] = $MOD['seo_description'];

$action = isset($action) ? $action : 'manage';
if(!$_userid && $action != 'add') showmessage('游客无权限进行此操作', 'goback');
if(!$_userid && !$MOD['enable_guest_add']) {header('Location:'.$PHPCMS['siteurl'].'member/login.php?forword='.$forward);exit;}

$displayid = isset($displayid) ? intval($displayid) : 0;
$pagesize = $PHPCMS['pagesize'];
$referer = isset($referer) ? $referer : $PHP_REFERER;
$action = isset($action) ? $action : 'manage';
if(!isset($checkcodestr)) $checkcodestr = '';

$fields = include MOD_ROOT.'/include/fields_house_display.php';

switch($action)
{
	case 'add':
		if($dosubmit)
		{		
			checkcode($checkcodestr, $MOD['enablecheckcode'], $forward);
			if(!$display['name']) showmessage('没有指定指定新楼市名称', 'goback');
			if(!$display['areaid'])	showmessage('没有指定区域', 'goback');
			if(!$display['address']) showmessage('没有指定楼市的详细地址', 'goback');		
			if(!$display['develop']) showmessage('没有填写开发商名称', 'goback');	
			//赋值处理
			$display['areaid'] = intval($display['areaid']);
			$display['startprice'] = intval($display['startprice']);
			$display['avgprice'] = intval($display['avgprice']);
			$display['introduce'] = str_safe($display['introduce']);
			$display['transit'] = str_safe($display['transit']);
			$display['housetype'] = $house['propertytype'];
			$display['addtime'] = $PHP_TIME;
			$display['username'] = $_username;
			$display['urlruleid'] = $MOD['displayishtml'] ? $MOD['displayitem_html_urlruleid'] : $MOD['displayitem_php_urlruleid'];
			$display['ishtml'] = $MOD['displayishtml'];
			$display['htmldir'] = '';
			$display['prefix'] = '';
			
			$display = new_htmlspecialchars($display);
			$display['status'] = $MOD['enablecheck'] ? 0 : 1;
			$keys = $values = $s = "";
			foreach($display as $key => $value)
			{
				if(!in_array($key, $fields)) continue;
				$keys .= $s.$key;
				$values .= $s."'".$value."'";
				$s = ",";
			}   
			$db->query("INSERT INTO ".TABLE_HOUSE_DISPLAY." ($keys) VALUES($values)");
			$displayid = $db->insert_id();		
			
			//插入房型图表house_hold
			foreach($householdimage_url as $k=>$v)
			{
				if($v)
				{
					$thumb = '';
					if(strpos($v,'http')===false)
					{
						$thumb = str_replace(basename($v),'thumb_'.basename($v),$v);
					}
					$db->query("INSERT INTO ".TABLE_HOUSE_HOLD." (title,thumb,image,area,displayid) VALUES('".$householdimage_title[$k]."','$thumb','$v','".$householdimage_area[$k]."','$displayid')");
				}		
			}

			update_display_url($displayid);

			if($MOD['ishtml']) createhtml('index');
			if($MOD['displayishtml']) createhtml('newhouse');
			if($MOD['createlistdisplay']) createhtml("listdisplay");

			if($MOD['add_point'])
			{
				$db->query("update ".TABLE_MEMBER." set point=point+$MOD[add_point] where userid=$_userid");
			}
			showmessage('楼盘信息发布成功！', $PHP_REFERER);
		}
		else
		{			
			$rs = $db->get_one('SELECT truename,telephone,mobile,qq,msn,homepage FROM '.TABLE_MEMBER_INFO.' WHERE userid='.$_userid);
			$_truename = $_telephone = $_mobile = $_qq = $_msn = $_homepage = '';
			if($rs)
			{
				$_truename = $rs['truename'];
				$_telephone = $rs['telephone'];
				$_mobile = $rs['mobile'];
				$_qq = $rs['qq'];
				$_msn = $rs['msn'];
				$_homepage = $rs['homepage'] ? $rs['homepage'] : 'http://';
			}		
		}
	break;

	case 'edit':

		$displayid or showmessage('没有指定信息的ID', 'goback');
		if($dosubmit)
		{	
			checkcode($checkcodestr, $MOD['check_code'], $forward);
			if(!$display['name']) showmessage('没有指定指定新楼市名称', 'goback');
			if(!$display['areaid'])	showmessage('没有指定区域', 'goback');
			if(!$display['address']) showmessage('没有指定楼市的详细地址', 'goback');		
			if(!$display['develop']) showmessage('没有填写开发商名称', 'goback');	
			
			$rs = $db->get_one('SELECT username FROM '.TABLE_HOUSE_DISPLAY.' WHERE displayid='.$displayid);
			if($_username !=$rs['username'])
			{
				showmessage('您没有修改该用户房产信息的权限！', 'goback');
			}			
			//赋值处理
			$display['areaid'] = intval($display['areaid']);
			$display['startprice'] = intval($display['startprice']);
			$display['avgprice'] = intval($display['avgprice']);
			$display['introduce'] = str_safe($display['introduce']);
			$display['transit'] = str_safe($display['transit']);
			$display['username'] = $_username;
			$display['edittime'] = $PHP_TIME;
			$display = new_htmlspecialchars($display);

			//更新SQL
			$sql = $s = '';
			foreach($display as $key=>$value)
			{
				if(!in_array($key, $fields)) continue;
				$sql .= $s.$key."='".$value."'";
				$s = ',';
			}
			$db->query("UPDATE ".TABLE_HOUSE_DISPLAY." SET $sql WHERE displayid=$displayid");		
			$db->query("DELETE FROM ".TABLE_HOUSE_HOLD." WHERE displayid=$displayid");
			//插入房型图表house_hold
			foreach($householdimage_url as $k=>$v)
			{
				if($v)
				{
					$thumb = '';
					if(strpos($v,'http')===false)
					{
						$thumb = str_replace(basename($v),'thumb_'.basename($v),$v);
					}
					$db->query("INSERT INTO ".TABLE_HOUSE_HOLD." (title,thumb,image,area,displayid) VALUES('".$householdimage_title[$k]."','$thumb','$v','".$householdimage_area[$k]."','$displayid')");
				}		
			}	
			if($MOD['ishtml']) createhtml('index');
			if($MOD['displayishtml']) createhtml('newhouse');
			if($MOD['createlistdisplay']) createhtml("listdisplay");

			showmessage('楼盘信息修改成功！', $forward);
		}
		else
		{
			$r = $db->get_one("SELECT * FROM ".TABLE_HOUSE_DISPLAY." WHERE displayid=$displayid");
			if(!$r) showmessage('信息不存在！', 'goback');
			if($r['username'] != $_username) showmessage('您无权编辑他人发布的信息！', 'goback');
			if($r['disabled']) showmessage('该信息不已被管理员禁用，您无权编辑！', 'goback');
			extract($r);

			$uploadimages = array();
			$result = $db->query("SELECT * FROM ".TABLE_HOUSE_HOLD." WHERE displayid=$displayid ORDER BY holdid ASC");
			while($r = $db->fetch_array($result))
			{ 
				$uploadimages[] = $r;
			}
			$uploadimagescount = count($uploadimages);
			$db->free_result($result);			
		}
	break;

	case 'delete':

		$displayid or showmessage("没有指定信息的ID", ' goback'); 
		$db->query("DELETE FROM ".TABLE_HOUSE_DISPLAY." WHERE displayid=$displayid AND username='$_username'");
		if($db->affected_rows()>0)
		{
			showmessage('指定的信息删除成功！', 'goback');
		}
		else
		{
			showmessage('指定的信息删除失败！<br />请确认提交来源及是否存在权限！', 'goback');
		}
		break;

	case 'manage':

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

		$ordertimes = array('listorder DESC, displayid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC');

		$status = isset($status) ? intval($status) : 1;
		if(!empty($keywords))
		{
			$keyword = str_replace(array(' ','*'),array('%','%'),$keywords);
			$searchtypes = array('title', 'author');
			$searchtype = in_array($searchtype, $searchtypes) ? $searchtype : 'title';
			$sql.= " AND $searchtype LIKE '%$keyword%' ";
		}

		$r = $db->get_one("SELECT COUNT(displayid) as num FROM ".TABLE_HOUSE_DISPLAY." WHERE username='$_username' AND status=$status $sql ");
		$number = $r['num'];
		$pages = phppages($number, $page, $pagesize);

		$displays = array();
		
		$TYPES = array_flip($PARS['type']);
		$result = $db->query("SELECT * FROM ".TABLE_HOUSE_DISPLAY." WHERE username='$_username' AND status=$status $sql ORDER BY $ordertimes[$ordertime] LIMIT $offset,$pagesize ");
		if($db->num_rows($result)>0)
		{
			while($r = $db->fetch_array($result))
			{
				$r['linkurl'] = $r['status'] ==1 ? linkurl($r['linkurl']) : $MOD['linkurl'].'displaymgr.php?action=edit&displayid='.$r['displayid'];
				$r['adddate']=date('Y-m-d',$r['addtime']);
				$r['thumb'] = imgurl($r['thumb']);
			    $r['areaname'] = $AREA[$r['areaid']]['areaname'];
				$displays[]=$r;
			}
		}
	break;
}
if($MOD['moduledomain'] && strpos($PHP_URL, $MOD['moduledomain'])!==false)
{
   header('Location:'.$PHPCMS['siteurl'].'/'.$MOD['moduledir'].'/displaymgr.php?'.$PHP_QUERYSTRING);
   exit;
}
$head['title'] = "管理我发布的新楼盘信息";
$head['keywords'] = "管理我发布的新楼盘信息";
$head['description'] = "管理我发布的新楼盘信息";
include template('house', 'displaymgr');
?>