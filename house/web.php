<?php 
require './include/common.inc.php';
$tab = 'web';
$page = isset($page) ? intval($page) : 1;
$username = isset($username) ? trim($username) : '';

if($username)
{
	$r = $db->get_one("SELECT * FROM ".TABLE_MEMBER." m,".TABLE_MEMBER_INFO." i WHERE m.username='".$username."' AND m.userid=i.userid");
	if(!$r) showmessage("非法用户");
	extract($r);

	$lastlogintime = date('Y-m-d H:i', $lastlogintime);

	$head['title'] = $my_house_corpname.'主页';
	$head['keywords'] = $my_house_corpname.$MOD['seo_keywords'];
	$head['description'] = $my_house_corpname.$MOD['seo_description'];
	if($detail)
	{
		include template($mod, 'web_detail');
	}
	else
	{
		$my_house_introduce = str_cut(strip_tags($my_house_introduce), 200, '...');
		include template($mod, 'web');
	}
}
else
{
	$head['title'] = '中介列表';
	$head['keywords'] = $MOD['seo_keywords'];
	$head['description'] = $MOD['seo_description'];

	include template($mod, 'web_list');
}
?>