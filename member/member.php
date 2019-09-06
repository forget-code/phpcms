<?php
/**
* 会员作品集
* @version phpcms 3.0.0 build 20060424
* @package phpcms
* @subpackage member
* @link http://dev.phpcms.cn phpcms模块开发网站
* @license http://www.phpcms.cn/license.html phpcms版权声明
* @copyright (C) 2005 - 2006 Phpcms Group
*/
require_once("common.php");

$m = $db->get_one("SELECT * FROM ".TABLE_MEMBER." m , ".TABLE_MEMBERINFO." i WHERE m.userid=i.userid AND m.username='$username' ","CACHE",86400);
if(!$m[userid]) message("用户名不存在!","goback");
@extract($m);

$userface = $userface ? $userface : PHPCMS_PATH."member/images/defaultface.gif";
$facewidth = $facewidth ? $facewidth : 150;
$faceheight = $faceheight ? $faceheight : 172;
$gender = $gender ? "男" : "女";
$birthday = $birthday == "0000-00-00" ? "未知" : $birthday;

$meta_title = $username."的作品集";

if($module || $channelid)
{
	if($channelid) $module = $_CHA['module'];
	array_key_exists($module,$_MODULE) or message('非法参数！');
	$skindir = PHPCMS_PATH."templates/".$defaulttemplate."/skins/".$defaultskin;
	include PHPCMS_ROOT."/module/".$module."/member.php";
}
else
{
	foreach($_CHANNEL as $channel)
	{
		if($channel[channeltype])
		{
			$channelid = $channel[channelid];
			@include PHPCMS_CACHEDIR."channel_".$channelid.".php";
			@include PHPCMS_CACHEDIR."category_".$channelid.".php";
			$_CHA = $_MYCHANNEL[$channelid];
			$_CAT = $_CATEGORY[$channelid];
			$module = $_CHA[module];
			$itemid = $module."id";
			$p->urlpath($_CHA,$_CAT);
			$p->set_type('url');

            $cha[$channelid]['channelurl'] = changeurl("channelid",$channelid);
			$cha[$channelid]['channelname'] = $_CHA['channelname'];

			$r = $db->get_one("SELECT count(*) as number FROM $tablepre$module WHERE channelid=$channelid AND status=3 AND recycle=0 AND username='$username'","CACHE",7200);
			$cha[$channelid]['itemnumber'] = $r['number'];

			$result = $db->query("SELECT * FROM $tablepre$module WHERE channelid=$channelid AND status=3 AND recycle=0 AND username='$username' ORDER BY addtime DESC LIMIT 0,10","CACHE",7200);
			while($r = $db->fetch_array($result))
			{
				$p->set_catid($r['catid']);
				$r['itemurl'] = $p->get_itemurl($r[$itemid],$r['addtime']);
				$r[title] = titleformat($r[title],$r[titlefontcolor],$r[titlefonttype],$r[includepic]);
				$r['adddate'] = date("Y-m-d",$r['addtime']);
				$items[$channelid][] = $r;
			}
		}
	}
	$channelid = 0;
	include template("member","member");
}
?>