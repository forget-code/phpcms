<?php
/**
* 获取视频内容页地址
*
* @param int $vid 视频id
* @param string $url 外部链接地址
* @param string $specialid 专辑id
*
* return string
*/
function video_show_url($vid, $url = '', $specialid = 0)
{
	global $URLRULE,$page;
	if($url) return $url;
	if(!$page) $page = 1;
	$M = cache_read('module_video.php', '', 1);
	if($specialid)
	{
		$urlrule = $URLRULE[$M['SUrlRuleid']];
	}
	else
	{
		$urlrule = $URLRULE[$M['showUrlRuleid']];
	}
	if(strpos($urlrule, '|'))
	{
		$urlrules = explode('|', $urlrule);
		$urlrule = $page < 2 ? $urlrules[0] : $urlrules[1];
	}
	eval("\$url = \"$urlrule\";");
	return $M['url'].$url;
}

/**
* 获取视频专辑地址
*
* @param int $specialid 专辑id
*
* return string
*/
function video_special_url($specialid)
{
	global $URLRULE,$page;
	if($url) return $url;
	if(!$page) $page = 1;
	$M = cache_read('module_video.php', '', 1);
	$urlrule = $URLRULE[$M['specialUrlRuleid']];
	if(strpos($urlrule, '|'))
	{
		$urlrules = explode('|', $urlrule);
		$urlrule = $page < 2 ? $urlrules[0] : $urlrules[1];
	}
	eval("\$url = \"$urlrule\";");
	return $M['url'].$url;
}
function format_time($time)
{
	$time = intval($time);
	if($time>3600)
	{
		$m = floor($time/60);
		$s = $time%60;
		return $m.':'.$s;
	}
	else
	{
		return date('i:s',$time);
	}
}
?>