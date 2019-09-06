<?php
require './include/common.inc.php';
if(!$M['enableshowlist']) showmessage('请开启列表页'); 
if(!$forward) $forward = HTTP_REFERER;
$modelid = intval($modelid);

$member_model = $member->MODEL;
if($modelid < 1 || !in_array($modelid, array_keys($member_model))) showmessage('选择正确的模型');
if(!$modelid) showmessage('请选择模型');

include template($mod, 'list');
?>