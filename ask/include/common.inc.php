<?php
define('MOD_ROOT', substr(dirname(__FILE__), 0, -8));

$mod = 'ask';
require substr(MOD_ROOT, 0, -strlen($mod)).'include/common.inc.php';

if(!$_userid) showmessage($LANG['please_login'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));

$GROUP = cache_read('member_group_'.$_groupid.'.php');
$STATUS = array($LANG['unsettled'], $LANG['under_dealing'], $LANG['dealed'], $LANG['reject_deal']);

$departments = cache_read('ask_department.php');
foreach($departments as $id=>$department)
{
	if(!check_purview($department['arrgroupid'])) 
	{
		unset($departments[$id]);
	}
}

if(isset($departmentid))
{
	$departmentid = intval($departmentid);
	if(!array_key_exists($departmentid, $departments) || !check_purview($departments[$departmentid]['arrgroupid'])) showmessage($LANG['you_have_no_permission']);
}
?>