<?php
define('IN_YP', TRUE);
define('ADMIN_ROOT', str_replace("\\", '/',dirname(__FILE__)).'/');
require '../include/common.inc.php';

if(!$_userid) showmessage('您还没有登陆，即将跳转到登陆页面',$MODULE['member']['url'].'login.php?forward='.urlencode(URL));
session_start();
require_once MOD_ROOT.'include/output.func.php';
if(!isset($file) || empty($file)) $file = 'panel';

/* $company_user_infos 获取企业会员信息 */
$company_user_infos = $db->get_one("SELECT * FROM `".DB_PRE."member_company` WHERE `userid`='$_userid'");
$userid = $_userid;

if(!$company_user_infos)
{
	$MS['title'] = '您不是企业会员';
	$MS['description'] = '你可以做下面操作';
	$MS['urls'][0] = array(
		'name'=>'免费升级为企业会员',
		'url'=>$PHPCMS['siteurl'].$M['url'].'company.php?action=member',
		);
	$MS['urls'][1] = array(
		'name'=>'退出当前帐号，换其他帐号登陆',
		'url'=>$PHPCMS['siteurl'].'member/logout.php',
		);
	$MS['urls'][2] = array(
		'name'=>'重新注册为企业会员',
		'url'=>$PHPCMS['siteurl'].'member/logout.php?forward='.urlencode($PHPCMS['siteurl'].'member/register.php'),
		);
	msg($MS);
}
$CATEGORY = subcat('yp');
$siteurl = company_url($userid, $company_user_infos['sitedomain']);

$_SESSION['url'] = QUERY_STRING;

if($file != 'company' && $M['enableSecondDomain'] && !$company_user_infos['sitedomain']) showmessage('请先绑定您的二级域名',BUSINESSDIR.'?file=company');

check_priv($file);
$GROUP = cache_read('member_group.php');
if(!@include ADMIN_ROOT.$file.'.inc.php') showmessage('The file ./yp/'.$file.'.inc.php is not exists!');

function check_priv($file)
{
	global $M,$PHPCMS,$_groupid;
	if(!$M["allow_add_$file"]) return true;
	if(!in_array($_groupid,$M["allow_add_$file"]))
	{
		$MS['title'] = '您所在的会员组没有此项操作权限';
		$MS['description'] = '你可以做下面操作';
		$MS['urls'][0] = array(
			'name'=>'升级会员组',
			'url'=>$PHPCMS['siteurl'].'member/upgrade.php',
			);
		$MS['urls'][1] = array(
			'name'=>'返回商务中心',
			'url'=>'?',
			);
		msg($MS);	
	}
}
?>