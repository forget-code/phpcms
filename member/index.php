<?php
require './include/common.inc.php';

if(!$_userid) showmessage($LANG['please_login'], $MOD['linkurl'].'login.php?forward='.urlencode($PHP_URL));

extract($member->get_info());
$GROUPS = cache_read('member_group.php');
extract(cache_read('member_group_'.$_groupid.'.php'));

$chargetype = $chargetype==1 ? $LANG['period_of_validity'] : $LANG['subtract_point'];
$gender = $gender==1 ? $LANG['male'] : $LANG['female'];
$regtime = $regtime ? date('Y-m-d H:i:s',$regtime) : '';
$lastlogintime = $lastlogintime ? date('Y-m-d H:i:s',$lastlogintime) : '';
$begindate = $begindate > '0000-00-00' ? $begindate : '';
$enddate = $enddate > '0000-00-00' ? $enddate : '';
$old = '';
if($birthday > '0000-00-00')
{
	$date->set_date($birthday);
	$old = date('Y') - $date->get_year();
}
$enableaddalways = $enableaddalways == 1 ? $LANG['yes'] : $LANG['no'];

$groupnames = '';
foreach($_arrgroupid as $gid)
{
	$groupnames .= ($groupnames ? ' ' : '').$GROUPS[$gid]['groupname'];
}

if($_groupid == 1 || $_groupid > 5)
{
	$status = $LANG['normal'];
}
else
{
	$status = $GROUP['groupname'];
}

require_once PHPCMS_ROOT.'/include/field.class.php';
$field = new field($CONFIG['tablepre'].'member_info');
$fields = $field->show_list('<tr>
<td width="15%"  class="td_right">$title:&nbsp;</td>
<td width="85%"  class="td_left">$value &nbsp;</td>
</tr>
');

include template($mod, 'index');
?>