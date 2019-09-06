<?php
defined('IN_PHPCMS') or exit('Access Denied');

require PHPCMS_ROOT.'/admin/include/position.class.php';
$pos = new position($mod);

if(isset($submit))
{ 
	if(empty($house['areaid']))
	{
		showmessage('所在区域不得为空','goback');
	}
	if(empty($house['validperiod']))
	{
		showmessage('有效期不得为空','goback');
	}
	if(!isset($houseid))
	{
		showmessage($LANG['illegal_parameters']);
	}
	$houseid = intval($houseid);

	//如果以前生成了该html,先删除
	if($ishtmled) 
	{
		//
		//$housecls->delete($houseid,'html');
	}
	//赋值处理
	//$house['subtype'] = intval($house['subtype']);
	$house['edittime'] = $PHP_TIME;
	$house['endtime'] = $PHP_TIME+$house['validperiod']*86400;
	$house['urlruleid'] = $house['ishtml'] ? $html_urlrule : $php_urlrule;
	//生成URl规则
	
	if(isset($house['arrposid']))
	{
		$arrposid = $house['arrposid'];
		$house['arrposid'] = ','.implode(',', $arrposid).',';
	}
	else
	{
        $arrposid = array();
		$house['arrposid'] = '';
	}
	$house['peripheral'] = isset($house['peripheral']) ? $house['peripheral'] : array();
	$house['indoor'] = isset($house['indoor']) ? $house['indoor'] : array();
	$house['infrastructure'] = isset($house['infrastructure']) ? $house['infrastructure'] : array();
	$house['peripheral'] = implode(",",$house['peripheral']);
	$house['indoor'] = implode(",",$house['indoor']);
	$house['infrastructure'] = implode(",",$house['infrastructure']);
	
	$house['linkurl'] = house_item_url('url',$typeid,$house['ishtml'], $house['urlruleid'], $house['htmldir'], $house['prefix'], $houseid, $house['addtime']);
	//更新SQL
	$sql = $s = "";
	foreach($house as $key=>$value)
	{
		$sql .= $s.$key."='".$value."'";
		$s = ",";
	}
	$query = 'UPDATE '.TABLE_HOUSE.' SET '.$sql.' WHERE houseid='.$houseid;
	$db->query($query);
	if($typeid ==3)//合租的情况
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
		$query = "DELETE FROM ".TABLE_HOUSE_COOP." WHERE houseid=$houseid";
		$db->query($query);
		$query = "INSERT INTO ".TABLE_HOUSE_COOP." ($keys) values($values)";
		$db->query($query);
		$coopid = $db->insert_id();	
	}
	
	//生成html
	if($MOD['ishtml']) createhtml('index');
	if($MOD['houseishtml']) createhtml('showinfo');
	if($MOD['createlistinfo']) {$infocat = $typeid; createhtml("listinfo");}
	if(isset($arrposid) || isset($old_arrposid))
	{
		$old_posid_arr = $old_arrposid ? array_filter(explode(',', $old_arrposid)) : array();
		$house['arrposid'] = isset($house['arrposid']) ? $house['arrposid'] : array();
		$pos->edit($houseid, $old_posid_arr, $arrposid);
	}
	showmessage($LANG['operation_success'],"?mod=$mod&file=infomgr&typeid=$typeid&action=manage");	
	
}
else
{
	require_once PHPCMS_ROOT."/$mod/include/formselect.func.php";
	$TYPE = cache_read('type_house.php');
	
	$houseid = isset($houseid) ? intval($houseid) : 0;
	if(!$houseid)
	{
		showmessage($LANG['illegal_parameters'],$referer);
	}
	$query = "SELECT * FROM ".TABLE_HOUSE." WHERE houseid=".$houseid." limit 0 ,1";
	$r = $db->get_one($query);
	$r = new_htmlspecialchars($r);
	@extract($r,EXTR_OVERWRITE);
	if($infocat==3)
	{
		$havehouse = $mygender = $yourgender = 0;
		$query = "SELECT * FROM ".TABLE_HOUSE_COOP." WHERE houseid=".$houseid." limit 0 ,1";
		$r = $db->get_one($query);
		$r = new_htmlspecialchars($r);
		@extract($r,EXTR_OVERWRITE);
	}
	$housetype = explode(",",$housetype);
	$type_1 = $housetype[0];
	$type_2 = $housetype[1];
	$type_3 = $housetype[2];
	$type_4 = $housetype[3];
	$infrastructure = explode(",",$infrastructure);
	$indoor = explode(",",$indoor);
	$peripheral = explode(",",$peripheral);
	$style_edit = style_edit("house[style]",$style);	
	$subtypeselect = type_select('house[subtype]',"选择附属类别", $subtype);

	$househtmlurlruleid = $ishtml ? $urlruleid : $MOD['houseitem_html_urlruleid'];
	$housephpurlruleid = $ishtml ?  $MOD['houseitem_php_urlruleid'] : $urlruleid ;
	
	$html_urlrule = house_urlrule_select('html_urlrule','html','item',$househtmlurlruleid);
	$php_urlrule = house_urlrule_select('php_urlrule','php','item',$housephpurlruleid);
	$showskin = showskin('house[skinid]',$skinid);
	$showtpl = showtpl($mod,'content','house[templateid]',$templateid);
	$position = $pos->checkbox('house[arrposid][]', $arrposid);
	include admintpl('infomgr_edit');
}
?>