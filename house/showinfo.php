<?php
require './include/common.inc.php';

$houseid = isset($houseid) ? intval($houseid) : 0;
$houseid or showmessage($LANG['illegal_operation'], $PHP_SITEURL);

$msg = '';
if($MOD['enablepurview'])
{
	if($MOD['arrgroupid_browse'] && !check_purview($MOD['arrgroupid_browse'])) showmessage($MOD['purview_message']);
	if($MOD['readpoint'] && array_key_exists('pay', $MODULE))
	{
		$readpoint = $MOD['readpoint'];
        require PHPCMS_ROOT.'/pay/include/pay.func.php';
		if(!$_userid) showmessage('查看本信息需要'.$MOD['readpoint'].$LANG['point'].$LANG['please_login'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));
		if($_chargetype)
		{
			check_time();
		}
		elseif(!is_exchanged($_userid.'-'.$mod.'-'.$houseid, $MOD['chargedays']))
        {
			$readurl = $MOD['linkurl'].'readpoint.php?houseid='.$houseid;
			$msg = preg_replace("/[{]([$][a-z_][a-z_\[\]]*)[}]/ie", "\\1", $MOD['point_message']);
		}
	}
}


$house = $db->get_one("SELECT * FROM ".TABLE_HOUSE." WHERE houseid=$houseid");
if(!$house || $house['status'] < 1) showmessage('请求的信息不存在');

$house['img1'] = imgurl($house['img1']);
$house['img2'] = imgurl($house['img2']);
$house['img3'] = imgurl($house['img3']);
$house['img4'] = imgurl($house['img4']);
extract($house);
unset($house);

$title = $name;
$tab = $typeid = $infocat;
$manage = $manage==0?'无':'有';
$inter = $isinter==0?'否':'是';
$validto = $addtime+$validperiod*3600*24;
$adddate = date('Y-m-d H:i',$addtime);
$validdate = date('Y-m-d H:i',$validto);
$housetypearr = explode(",",$housetype);
$housetype = '';
$stw = array('室','厅','卫','阳台');
foreach ($housetypearr as $k=>$v)
{
	$housetype.=$v=='不限'?'':$v.$stw[$k];
}
$infrastructurearr = explode(",",$infrastructure);
$indoorarr = explode(",",$indoor);
$peripheralarr = explode(",",$peripheral);
$infrastructure = '';
foreach($infrastructurearr as $v)
{
	if($v)
	$infrastructure.= $INFRASTRUCTURE[$v].'&nbsp;';
}
$indoor = '';
foreach($indoorarr as $v)
{
	if($v)
	$indoor.=$INDOOR[$v].'&nbsp;';
}
$peripheral = '';
foreach($peripheralarr as $v)
{
	if($v)
	$peripheral.=$PERIPHERAL[$v].'&nbsp;';
}
if($infocat==3)
{
	$query = "SELECT * FROM ".TABLE_HOUSE_COOP." WHERE houseid=".$houseid." limit 0,1";
	$r = $db->get_one($query);
	extract($r);
	unset($r);
	
	$havehouse = $havehouse===1?'有房':($havehouse===0?'无房':'');
	$mygender = $mygender==1?'男':($mygender==2?'女':($mygender==3?'夫妻/情侣':''));
	$yourgender = $yourgender==1?'男':($yourgender==2?'女':($yourgender==3?'夫妻/情侣':''));
		
}
$head['title'] = $name;
$head['keywords'] = $name.",".$MOD['seo_keywords'];
$head['description'] = $description.'-'.$MOD['seo_description'];
$house_propertytype = $propertytype>0 ? $HOUSETYPE[$propertytype]:'';
$house_towards = $towards? $TOWARDS[$towards]:'';
$newlinkurl = house_item_url('url',$infocat,$ishtml,$urlruleid, $htmldir, $prefix, $houseid, $addtime);
$itemurl = linkurl($newlinkurl);

if($newlinkurl!=$linkurl) $db->query("UPDATE ".TABLE_HOUSE." SET linkurl='$newlinkurl' WHERE houseid='$houseid'");
$infotypename = $PARS['infotype']['type_'.$infocat];
$skinid = $skinid ? $skinid : 0;
$skindir = $skinid ? PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid : $skindir;
$templateid = $templateid ? $templateid : 0;
$templateid = $templateid ? $templateid : "showinfo";
include template($mod, $templateid);
?>