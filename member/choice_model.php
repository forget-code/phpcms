<?php
require './include/common.inc.php';
if(!$M['allowregister']) showmessage('该网站不能注册，请与网站管理员联系');
if(!$forward) $forward = HTTP_REFERER;
if($_userid) showmessage($LANG['you_have_logined'], $forward);
if(!$M['choosemodel'] || $member->count_model() < 2) showmessage('请添加用户模型', $forward);
if($dosubmit)
{
	$modelname = $member->MODEL[$modelid]['name'];
	showmessage("已选择$modelname,请填写注册信息", "$M[url]register.php?modelid=$modelid",1);
}
else
{
	$model = $member->MODEL;
	include template($mod, 'choice_model');
}
?>