<?php
defined('IN_PHPCMS') or exit('Access Denied');

$placeid = intval($placeid);
$loadadsplace = $db->get_one("SELECT * FROM ".TABLE_ADS_PLACE." WHERE placeid=$placeid AND passed=1");
if(!$loadadsplace) showmessage($LANG['incorrect_parameters']);
$referer = urlencode($referer);
include admintpl('adsplace_loadjs');
?>