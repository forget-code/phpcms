<?php
define('SHOWJS', 1);
require './include/common.inc.php';

$GROUP = cache_read('member_group_'.$_groupid.'.php');

if($_chargetype == 1)
{
	$validdatenum = $_enddate == '0000-00-00' ? $LANG['without_day'] : 	$date->get_diff($_enddate, $_begindate).$LANG['day'];
}

include template('member', 'info');
$CONFIG['phpcache'] = 0;
phpcache(1);
?>