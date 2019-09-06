<?php
function managetpl($file = 'index', $module = '')
{
	global $CONFIG,$PHPCMS;
	return PHPCMS_ROOT.'/yp/web/admin/templates/'.$file.'.tpl.php';
}
function createhtml_show($table,$label,$labelid,$flagid)
{
	global $db,$PHP_TIME,$skindir,$_userdir,$tplType,$mydomain,$pagename,$m_system,$m_user,$PHPCMS,$guestbookurl,$orderurl,$joburl,$producturl,$articleurl,$introduceurl,$domainName,$CONFIG;
	$r = $db->get_one("SELECT * FROM $table WHERE $flagid='$labelid'");
	while (list($key, $value) = each($r))
	{
		$temp[$key] = $value;
	}
	//print_r($temp);exit;
	if($label=='sales'||$label=='buy')
	{
		$product = $temp;
	}
	else
	{
		$$label = $temp;
	}
	$$flagid = $labelid;
	$companyid = $temp['companyid'];
	extract($db->get_one("SELECT SQL_CACHE m.username,m.userid,c.companyname AS pagename,c.templateid AS defaultTplType,c.banner,c.background,c.introduce,c.menu FROM ".TABLE_MEMBER_COMPANY." c, ".TABLE_MEMBER." m WHERE c.companyid='$companyid' AND m.username=c.username"));	
	if($background)
	{
		$backgrounds = explode('|',$background);
		$backgroundtype = $backgrounds[0];
		$background = $backgrounds[1];
	}
	$filename = $label;
	$_userid = $userid;
	require PHPCMS_ROOT.'/yp/web/include/createhtml/'.$label.'.php';
}
?>