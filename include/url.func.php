<?php 
function space_url($userid)
{
	global $MODULE;
	return $MODULE['space']['url'].'?userid='.$userid;
}

function ip_url($ip)
{
	return 'http://tool.phpcms.cn/ip.php?ip='.$ip;
}

function content_url($contentid)
{
	global $db;
	$contentid = intval($contentid);
	if($contentid < 1) return '';
	$r = $db->get_one("SELECT `url` FROM `".DB_PRE."content` WHERE `contentid`=$contentid");
	return $r ? $r['url'] : '';
}

function member_view_url($userid)
{
	return "?mod=member&file=member&action=view&userid=$userid";
}

function avatar($userid)
{
	global $PHPCMS, $member_api, $attachment;
	if(!$PHPCMS['uc'])
	{
		if(!is_a($member, 'member_api'))
		{
			$member_api = load('member_api.class.php', 'member', 'api');
			$attachmentid = $member_api->get($userid, array('avatar'));
			$aid = $attachmentid['avatar'];
		}
		if(!is_a($attachment, 'attachment'))
		{
			if(!class_exists('attachment'))
			{
				require 'attachment.class.php';
			}
			$attachment = new attachment();
		}
		$filepath = $attachment->get($aid, 'filepath');
		if($aid)
		{
			$avatar = UPLOAD_URL.$filepath['filepath'];
			return $avatar;
		}
		$avatar = 'images/nophoto.gif';
	}
	else
	{
		if(!defined('UC_API'))
		{
			define('UC_API', $PHPCMS['uc_api']) ;
		}
		$avatar = UC_API."/avatar.php?uid=".$userid."&size=big";
	}
	return $avatar;
}
?>