<?php 
if(!defined('IN_ADMIN'))
{
	$r = $db->get_one("SELECT SQL_CACHE companyid,companyname AS pagename,sitedomain AS domainName,templateid AS defaultTplType,menu,status AS companystatus,vip FROM ".TABLE_MEMBER_COMPANY." WHERE username='$_username'");
	if(!$r) showmessage($LANG['no_register_company'],$PHPCMS['siteurl'].'yp/register.php?forward='.$PHP_URL);
	extract($r);
	unset($r);
	require YP_ROOT_DIR.'/web/admin/include/global.func.php';
}
require PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/'.$mod.'/companytplnames.php';
$SITEURL = substr($PHPCMS['siteurl'],0,-1);//主站url
if($MOD['enableSecondDomain'])
{	
	$INDEX = $mydomain = 'http://'.$domainName.'.'.$MOD['secondDomain'];
	$asksign = '?';
	$guestbookurl = $mydomain.'/index.php?categroy-guestbook/';
	$orderurl = $mydomain.'/index.php?categroy-order/';
}
else
{
	$userid = $userid ? $userid : $_userid;
	if(preg_match('/http:\/\//',$MODULE['yp']['linkurl']))
	{
		$INDEX = $MODULE['yp']['linkurl'].'?'.$_userid;
		$mydomain = $MODULE['yp']['linkurl'].'web/?'.$_userid;
		$posturl = $MODULE['yp']['linkurl'].'web/index.php?'.$_userid;
	}
	else
	{		
		$INDEX = $SITEURL."/yp/?".$userid;
		$mydomain = $SITEURL."/yp/web/?".$userid;
		$posturl = $SITEURL."/yp/web/index.php?".$userid;
	}
	$domainName = $userid;
	$asksign = '';
	$guestbookurl = $posturl.'/categroy-guestbook/';
	$orderurl = $posturl.'/categroy-order/';
}

$introduceurl = $mydomain.'/'.$asksign.'categroy-introduce.html';
$articleurl = $mydomain.'/'.$asksign.'categroy-article.html';
$producturl = $mydomain.'/'.$asksign.'categroy-product.html';
$buyurl = $mydomain.'/'.$asksign.'categroy-buy.html';
$salesurl = $mydomain.'/'.$asksign.'categroy-sales.html';
$joburl = $mydomain.'/'.$asksign.'categroy-job.html';

if($defaultTplType)
{
	$tplType = $defaultTplType;
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
$skindir = $CONFIG['rootpath'].'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$CONFIG['defaultskin'].'/'.$tplType;
$menusettings = unserialize($menu);
$m_system = $menusettings['system'];
$m_user = $menusettings['user'];

/*
$domainName : 二级域名模式：sitedomain 字段值 => book、life
							$_userid 用户ID 索引 => 1、2334

$mydomain   : 二级域名模式：$mydomain = 'http://'.$domainName.'.'.$MOD['secondDomain'];
							$mydomain = $MODULE['yp']['linkurl'].'web/?'.$_userid;

$tplType    : 当前用户正在使用的模板风格 => com_blue

$pagename   : 企业名称

*/

?>