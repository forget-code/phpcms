<?php
require './include/common.inc.php';
session_start();

if($_SESSION['moodtime'] && (TIME-$_SESSION['moodtime']<10))
{
	echo "document.getElementById(\"moodrank_div\").innerHTML = \"请勿连续刷新\";";
	exit;
}
$_SESSION['moodtime'] = TIME;
require_once MOD_ROOT.'include/mood.class.php';
$mood = new mood();
$moodid = intval($moodid);
$r = $mood->add($moodid, $contentid, $vote_id);
$data = cache_read('mood'.$moodid.'.php');
$number = count($data);
foreach($data AS $k=>$v)
{
	$field = 'n'.$k;
	$infos[$k]['title'] = $v;
	$infos[$k]['height'] = ceil($r[$field]/$r['total'] * 79);
	$infos[$k]['number'] = $r[$field];
}
ob_start();
include template('mood','result');
$data = ob_get_contents();
ob_clean();
$data =  format_js($data,0);
echo "document.getElementById(\"moodrank_div\").innerHTML = \"$data\";";
?>