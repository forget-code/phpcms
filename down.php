<?php
require dirname(__FILE__).'/include/common.inc.php';
if(!isset($a_k)) showmessage($LANG['illegal_parameters']);

$a_k = phpcms_auth($a_k, 'DECODE', AUTH_KEY);
if(empty($a_k)) showmessage($LANG['illegal_parameters']);
unset($i,$m,$f);
parse_str($a_k);
if(isset($i)) $i = intval($i);
if(!isset($m)) showmessage($LANG['illegal_parameters']);
if(empty($f)) showmessage('地址失效');
if(preg_match('/\.php/i',$f) || strpos($f, ":\\")) showmessage('地址有误');
if(!$i || $m<0) showmessage($LANG['illegal_parameters']);
$allow_readpoint = 1;

if($mod == 'phpcms')
{
	include 'admin/content.class.php';
	$content = new content;
	$data = $content->get($i);
	$contentid = $i;
	$readpoint = $data['readpoint'];

	$head['title'] = $data['title'];
	$keys = array_keys($data);
	
	if(in_array('groupids_view',$keys))
	{
		if($data['groupids_view'])
		{
			if(!$priv_group->check('contentid', $contentid, 'view', $_groupid)) showmessage('您没有下载权限');
		}
		if(in_array('readpoint',$keys))
		{
			$C = cache_read('category_'.$data['catid'].'.php');
			if($C['defaultchargepoint'] || !empty($readpoint))
			{
				$readpoint = $readpoint ? $readpoint : $C['defaultchargepoint'];
				$pay = load('pay_api.class.php', 'pay', 'api');
				if($C['repeatchargedays'])
				{
					if($pay->is_exchanged($contentid, $C['repeatchargedays']) === FALSE)
					{
						$allow_readpoint = 0;
					}
				}
				else
				{
					session_start();
					if($_SESSION['pay_contentid'] != $contentid) $allow_readpoint = 0;
				}
			}
		}
	}
}

if(strpos($f, 'http://') !== FALSE || strpos($f, 'ftp://') !== FALSE || strpos($f, '://') === FALSE)
{
	$phpcms_auth_key = md5(AUTH_KEY.$_SERVER['HTTP_USER_AGENT']);
	$a_k = urlencode(phpcms_auth("i=$i&f=$f&d=$d&s=$s&t=".TIME."&ip=".IP."&m=".$m, 'ENCODE', $phpcms_auth_key));
	$downurl = 'download.php?a_k='.$a_k;
}
else
{
	require_once 'admin/content.class.php';
	$c = new content();
	$c->hits($contentid);
	$downurl = $f;
	
}

include template('phpcms', 'down');
?>