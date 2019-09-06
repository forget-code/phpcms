<?php
defined('IN_PHPCMS') or exit('Access Denied');
$tab = $infocat;
$houseid = isset($houseid) ? intval($houseid) : 0;
$houseid or showmessage($LANG['illegal_operation'], $PHP_SITEURL);
$house = $db->get_one("SELECT * FROM ".TABLE_HOUSE." WHERE houseid=$houseid");
if(!$house || $house['status'] < 1 || !$house['ishtml']) return FALSE;

$house['img1'] = imgurl($house['img1']);
$house['img2'] = imgurl($house['img2']);
$house['img3'] = imgurl($house['img3']);
$house['img4'] = imgurl($house['img4']);
extract($house);
unset($house);

$title = $name;
$typeid = $tab = $infocat;
$manage = $manage==0 ? '无' : '有';
$inter = $isinter==0 ? '否' : '是';
$validto = $addtime+$validperiod*3600*24;
$adddate = date('Y-m-d H:i', $addtime);
$validdate = date('Y-m-d H:i', $validto);
$housetypearr = explode(',', $housetype);
$housetype = '';
$stw = array('室','厅','卫','阳台');
foreach ($housetypearr as $k=>$v)
{
	$housetype .= $v=='不限' ? '' : $v.$stw[$k];
}
$infrastructurearr = explode(",",$infrastructure);
$indoorarr = explode(",",$indoor);
$peripheralarr = explode(",",$peripheral);
$infrastructure = '';
foreach($infrastructurearr as $v)
{
	if($v)
	$infrastructure .= $INFRASTRUCTURE[$v].'&nbsp;';
}
$indoor = '';
foreach($indoorarr as $v)
{
	if($v)
	$indoor .= $INDOOR[$v].'&nbsp;';
}
$peripheral = '';
foreach($peripheralarr as $v)
{
	if($v)
	$peripheral .= $PERIPHERAL[$v].'&nbsp;';
}
if($infocat==3)
{
	$r = $db->get_one("SELECT * FROM ".TABLE_HOUSE_COOP." WHERE houseid=$houseid");
	extract($r);
	unset($r);
	$havehouse = $havehouse===1 ? '有房' : ($havehouse===0 ? '无房' : '');
	$mygender = $mygender==1 ? '男' : ($mygender==2 ? '女' : ($mygender==3 ? '夫妻/情侣' : ''));
	$yourgender = $yourgender==1 ? '男' : ($yourgender==2 ? '女':($yourgender==3 ? '夫妻/情侣' : ''));	
}

$head['title'] = $name;
$head['keywords'] = $name.','.$MOD['seo_keywords'];
$head['description'] = $description.'-'.$MOD['seo_description'];

$house_propertytype = $propertytype > 0 ? $HOUSETYPE[$propertytype] : '';
$house_towards = $towards ? $TOWARDS[$towards] : '';
$itemurl = linkurl($linkurl);
$infotypename = $PARS['infotype']['type_'.$infocat];
if($skinid) $skindir = PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid;
if(!$templateid) $templateid = 'showinfo';

ob_start();
include template($mod, $templateid);
$data = ob_get_contents();
ob_clean();
$filepath = house_item_url('path',$typeid,$ishtml,$urlruleid, $htmldir, $prefix, $houseid, $addtime);		
$filepath = PHPCMS_ROOT.'/'.$filepath;
$dir = dirname($filepath);
dir_create($dir);
file_put_contents($filepath, $data);
@chmod($filepath, 0777);
return TRUE;
?>