<?php
$keyid = isset($keyid) ? $keyid : 0;
$modtitle[$mod] = '公告管理';
$menu[$mod][] = array('添加公告', "?mod=$mod&file=$mod&action=add&keyid=$keyid");
$menu[$mod][] = array('管理公告', "?mod=$mod&file=$mod&action=manage&passed=1&keyid=$keyid");
$menu[$mod][] = array('审批公告', "?mod=$mod&file=$mod&action=manage&passed=0&keyid=$keyid");
$menu[$mod][] = array('过期公告', "?mod=$mod&file=$mod&action=manage&timeout=1&keyid=$keyid");
$menu[$mod][] = array('标签调用管理', "?mod=$mod&file=tag&keyid=$keyid");
?>