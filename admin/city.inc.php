<?php 
defined('IN_PHPCMS') or exit('Access Denied');

if($_grade>0) showmessage($LANG['you_have_no_permission']);

$referer = $referer ? $referer : $PHP_REFERER;
$action = $action ? $action : 'manage';

$submenu = array(
array($LANG['province_city_admin'], "?mod=".$mod."&file=province&action=manage"),
);
$menu = adminmenu($LANG['city_area_county_admin'],$submenu);

if($dosubmit)
{
	foreach($city as $id=>$v)
	{
		if($delete[$id])
		{
			$db->query("delete from ".TABLE_CITY." where cityid='$id'");
		}
		else
		{
			$db->query("update ".TABLE_CITY." set city='$city[$id]',area='$area[$id]',postcode='$postcode[$id]',areacode='$areacode[$id]' where cityid='$id'");
		}
	}
	if($newcity)
	{
		$db->query("insert into ".TABLE_CITY."(province,city,area,postcode,areacode) values('$newprovince','$newcity','$newarea','$newpostcode','$newareacode')");
	}
	showmessage($LANG['operation_success'],$PHP_REFERER);
}
else
{
	$result = $db->query("select * from ".TABLE_CITY." where province='$province'");
	while($r = $db->fetch_array($result))
	{
		$citys[$r['cityid']] = $r;
	}
	include admintpl('city');
}
?>