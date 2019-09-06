<?php 
require './include/common.inc.php';

$head['title'] = "设置用户组";
$head['keywords'] = "设置用户组";
$head['description'] ="设置用户组";

if(!$_userid) showmessage($LANG['please_login'], $MOD['linkurl'].'login.php?forward='.urlencode($PHP_URL));
if($dosubmit)
{
	if(!$membertype) showmessage('请先选择用户类型!');
	if(($membertype==2 || $membertype==3) && $corpname=='') showmessage('请将公司名填写完整!');
	$my_house_introduce = str_safe($my_house_introduce);

	$r = $db->query("UPDATE ".TABLE_MEMBER_INFO." SET my_house_membertype='$membertype',my_house_corpname='$corpname',my_house_introduce='$my_house_introduce' WHERE userid=$_userid");
	showmessage('成功设置了用户类型，欢迎到房产频道添加发布信息！',$forward);
}
else
{
	$r = $db->get_one("SELECT my_house_membertype,my_house_corpname,my_house_introduce FROM ".TABLE_MEMBER_INFO." WHERE userid=$_userid");
	//if($r['my_house_membertype']) showmessage('您已经设置了用户类型，欢迎到房产频道添加发布信息！', $MOD['linkurl']);
	
	include template($mod, 'membertype');
}
?>