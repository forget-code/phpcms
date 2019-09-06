<?php
defined('IN_PHPCMS') or exit('Access Denied');

$userid = $userid ? $userid : intval(QUERY_STRING);
$r = $db->get_one("SELECT * FROM `".DB_PRE."member_company` WHERE `userid`='$userid'");
if($r)
{
	extract($r);
}

if(!$userid)
{
	$MS['title'] = '你要访问的站点不存在';
	$MS['description'] = '请核对网址是否正确.';
	$MS['urls'][0] = array(
		'name'=>'访问网站首页',
		'url'=>$PHPCMS['siteurl'],
		);
	$MS['urls'][1] = array(
		'name'=>'注册为本站会员',
		'url'=>$PHPCMS['siteurl'].'member/register.php',
		);
	msg($MS);
}
if(empty($tplname)) $tplname = 'default';
//用户选择的默认模板
$companytpl_config = include PHPCMS_ROOT.'templates/'.TPL_NAME.'/yp/companytplnames.php';

$tpl = $companytpl_config[$tplname]['tplname'];

define('TPL', $tpl);
define('WEB_SKIN', 'templates/'.TPL_NAME.'/yp/css/');
if($diy)
{
	define('SKIN_DIY', WEB_SKIN.$userid.'_diy.css');
}
else
{
	define('SKIN_DIY', WEB_SKIN.$companytpl_config[$tplname]['style']);
}
$menu = string2array($menu);

$siteurl = $m_s_url[1] = $M['url'].'web/?'.$userid;
$introduceurl = $m_s_url[2] = $siteurl.'/category-introduce.html';
$newsurl = $m_s_url[3] = $siteurl.'/category-news.html';
$product = $m_s_url[4] = $siteurl.'/category-product.html';
$buyurl = $m_s_url[5] = $siteurl.'/category-buy.html';
$joburl = $m_s_url[6] = $siteurl.'/category-job.html';
$joburl = $m_s_url[7] = $siteurl.'/category-certificate.html';
$guestbookurl = $m_s_url[8] = $siteurl.'/category-guestbook.html';
$contacturl = $m_s_url[9] = $siteurl.'/category-contact.html';

/*
	[1] => 首页
	[2] => 公司介绍
	[3] => 公司新闻
	[4] => 产品展示
	[5] => 商机
	[6] => 人才招聘
	[7] => 在线留言
	[8] => 联系方式
*/

$system_action = array('','index','introduce','news','product','buy','job','certificate','guestbook','contact');
if(!in_array($category,$system_action)) showmessage("非法参数");
if(empty($menu)) $menu = cache_read('menu.inc.php',MOD_ROOT.'include/');
$system_name = array();
foreach($menu['system']['catname'] AS $_k=>$_v)
{
	if($menu['system']['use'][$_k])
	{
		$m_system[$_k]['catname'] = $_v;
		$m_system[$_k]['url'] = $m_s_url[$_k];
	}
	$system_name[$system_action[$_k]] = $_v;
}
foreach($menu['usermenu']['catname'] AS $_k=>$_v)
{
	if($menu['usermenu']['use'][$_k])
	{
		$m_user[$_k]['catname'] = $_v;
		$m_user[$_k]['url'] = $menu['usermenu']['linkurl'][$_k];
	}
}

$position = "<a href='$siteurl'>$system_name[index]</a> > $system_name[$category]";
if($map)
{
	$maps = explode('|',$map);
	$x = $maps[0];
	$y = $maps[1];
	$z = $maps[2];
}
include MOD_ROOT.'include/stats.class.php';
$stats = new stats();
$vid = $_userid ? $_userid : 0;
$stats_number = $stats->get($userid,$vid);
$stats->set_userid($userid);
if($stats_number)
{
	$stats->update($stats_number['sid']);
}
else
{
	$stats->add(array('userid'=>$userid,'vid'=>$vid,'addtime'=>TIME,'updatetime'=>TIME,'ip'=>IP));
}
$banner = $banner ? $banner : 'yp/images/banner.jpg';
require_once MOD_ROOT.'include/output.func.php';
?>