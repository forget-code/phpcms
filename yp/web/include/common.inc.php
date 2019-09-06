<?php
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/yp/include/global.func.php';
if($MOD['enableSecondDomain'])
{
	$domains = explode('.',$PHP_DOMAIN);
	$domainName = $domains[0];
	$r = $db->get_one("SELECT companyid,companyname AS pagename,templateid,username,banner,background,introduce,menu FROM ".TABLE_MEMBER_COMPANY." WHERE sitedomain='$domainName'");
	if(!$r) showmessage($LANG['sitedomain_no_exist']);
	$mydomain = 'http://'.$domainName.'.'.$MOD['secondDomain'];
	$introduceurl = $mydomain.'/?categroy-introduce/';
	$articleurl = $mydomain.'/?categroy-article/';
	$producturl = $mydomain.'/?categroy-product/';
	$buyurl = $mydomain.'/?categroy-buy/';
	$salesurl = $mydomain.'/?categroy-sales/';
	$joburl = $mydomain.'/?categroy-job/';
	$guestbookurl = $mydomain.'/index.php?categroy-guestbook/';
	$orderurl = $mydomain.'/index.php?categroy-order/';
}
else
{
	if(!isset($categroy) && !isset($enterprise))
	{
		$enterprise = intval($PHP_QUERYSTRING);
	}
	elseif($categroy)
	{
		$strings = explode('/',$PHP_QUERYSTRING);
		$enterprise = intval($strings[0]);
	}
	else
	{
		$enterprise = intval($enterprise);
	}
	if($enterprise<=0) showmessage($LANG['illegal_parameters']);
	$r = $db->get_one("SELECT m.username,c.companyid,c.companyname AS pagename,c.templateid,c.banner,c.background,c.introduce,c.menu FROM ".TABLE_MEMBER." m, ".TABLE_MEMBER_COMPANY." c WHERE m.username=c.username AND m.userid=$enterprise");
	if(!$r) showmessage($LANG['sitedomain_no_exist']);
	$domainName = $enterprise;
	if(!preg_match("/http:\/\//",$MOD['linkurl']))
	{
		$MOD['linkurl'] = $PHPCMS['siteurl'].'yp';
	}
	$mydomain = $MOD['linkurl'].'/web/?'.$enterprise;
	$posturl = $MOD['linkurl'].'/web/index.php?'.$enterprise;	
	$introduceurl = $mydomain.'/categroy-introduce/';
	$articleurl = $mydomain.'/categroy-article/';
	$producturl = $mydomain.'/categroy-product/';
	$buyurl = $mydomain.'/categroy-buy/';
	$salesurl = $mydomain.'/categroy-sales/';
	$joburl = $mydomain.'/categroy-job/';
	$guestbookurl = $posturl.'/categroy-guestbook/';
	$orderurl = $posturl.'/categroy-order/';
}
extract($r);
if($background)
{
	$backgrounds = explode('|',$background);
	$backgroundtype = $backgrounds[0];
	$background = $backgrounds[1];
}

$SITEURL = substr($PHPCMS['siteurl'],0,-1);//主站url
if($templateid)
{
	$tplType = $templateid;
}
else
{
	require PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/'.$mod.'/companytplnames.php';
	foreach($companytpl_config AS $k=>$v)
	{
		if($companytpl_config[$k]['defaulttpl']===1)
		$tplType = $companytpl_config[$k]['filename'];
	}
}
$_userdir = substr($domainName,0,2);//ID:123=>12 | book=>bo
$skindir = $skindir.'/'.$tplType;
$menusettings = unserialize($menu);
$m_system = $menusettings['system'];
$m_user = $menusettings['user'];
?>