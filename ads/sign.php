<?php
require './include/common.inc.php';
require 'form.class.php';

if(!$_userid) showmessage('请登陆!',$MODULE['member']['url'].'login.php?forward='.urlencode(URL));
$placeid = intval($placeid);
if(!$priv_group->check('p_adsid', $placeid, 'input', $_groupid)) showmessage($LANG['not_add'], 'goback');
$places = array();
$places = $place->get_info($placeid);
$fromdate = form::date('ads[fromdate]', date('Y-n-j'));
$thumb = form::file("thumb", 'thumb');
$thumb1 = form::file("thumb1", 'thumb1');
$flash = form::file("flash", 'flash');
$code = form::editor('code');
$todate = form::date('ads[todate]', date('Y-n-j', mktime(0, 0, 0, date('n')+1, date('j'), date('Y'))));
include template($mod, 'sign');
?>