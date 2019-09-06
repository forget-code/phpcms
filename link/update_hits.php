<?php
require './include/common.inc.php';

if(isset($linkid)) $linkid = intval($linkid);
if($linkid < 1) exit;
if(!getcookie('linkid_'.$linkid))
{
	$db->query("UPDATE ".TABLE_LINK." SET hits=hits+1 WHERE linkid=$linkid");
	$db->close();
	mkcookie('linkid_'.$linkid, 1 , $PHP_TIME+3600);
	echo $LANG['hits_success'];
}

?>