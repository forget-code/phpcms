<?php
require './include/common.inc.php';
require_once MOD_ROOT.'/include/tag.func.php';

if(!$itemid || !$keyid || (!array_key_exists($keyid, $MODULE) && !array_key_exists($keyid, $CHANNEL))) showmessage($LANG['illegal_operation']);
if($keyid) $keyid = intval($keyid);
if($itemid) $itemid = intval($itemid);

$r = $db->get_one("SELECT count(cid) AS totalnumber,AVG(score) AS avgscore FROM ".TABLE_COMMENT." WHERE keyid='$keyid' AND itemid='$itemid' AND passed=1");
@extract($r);
$avgscore = stars($avgscore);
$page = isset($page) ? intval($page) : 1;
if(!isset($itemurl)) $itemurl = itemurl($keyid, $itemid);
$head['title'] = $title;
include template($mod, 'index');
?>