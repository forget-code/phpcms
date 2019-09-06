<?php
require dirname(__FILE__).'/include/common.inc.php';
if(!isset($a_k)) showmessage($LANG['illegal_parameters']);

$a_k = phpcms_auth($a_k, 'DECODE', AUTH_KEY);
if(empty($a_k)) showmessage($LANG['illegal_parameters']);
unset($i, $m, $f, $p);
parse_str($a_k);
if(isset($i)) $i = intval($i);
if(!isset($m)) showmessage($LANG['illegal_parameters']);

if(empty($f)) showmessage('地址失效');
if(preg_match('/(php|phtml|php3|php4|jsp|exe|dll|asp|cer|asa|shtml|shtm|aspx|asax|cgi|fcgi|pl)(\.|$)/i',$f) || strpos($f, ":\\")!==FALSE || strpos($f,'..')!==FALSE) showmessage('地址有误');
if(!$i || $m<0) showmessage($LANG['illegal_parameters']);
$allow_readpoint = 1;

if (preg_match('/([^a-z_]+)/i',$mod)) {
	showmessage($LANG['illegal_parameters']);
}
if($mod == 'phpcms')
{
	$contentid = $i;
	include 'admin/content.class.php';
	$content = new content;
	$data = $content->get($contentid);
	$readpoint = $data['readpoint'];

	$title = $data['title'];
	$keys = array_keys($data);

	if(in_array('groupids_view',$keys))
	{
		if($data['groupids_view'])
		{
			if(!$priv_group->check('contentid', $contentid, 'view', $_groupid)) showmessage('您没有查看权限');
		}
		if(in_array('readpoint', $keys))
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


$player = load('player.class.php');
$result = $player->get($p);
@extract($result);
$videourl = trim($f);
$code = str_replace('{$filepath}',$videourl, $code);
$code = str_replace('{$PHPCMS[siteurl]}', $PHPCMS['siteurl'], $code);
$code = str_replace('{$PHPCMS[sitename]}', $PHPCMS['sitename'], $code);
$templateid = $templateid ? $templateid : 'play';
include template($mod, $templateid);
?>