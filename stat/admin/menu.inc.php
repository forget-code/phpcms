<?php
defined('IN_PHPCMS') or exit('Access Denied');
$modtitle[$mod] = '访问统计';
$menu[$mod][] = array("实时统计","?mod=$mod&file=$mod&action=realt");
$menu[$mod][] = array("流量分析","?mod=$mod&file=$mod&action=flux");
$menu[$mod][] = array("访问统计","?mod=$mod&file=$mod&action=ivsit");
$menu[$mod][] = array("客户端分析","?mod=$mod&file=$mod&action=client");
$menu[$mod][] = array("自定义分析","?mod=$mod&file=$mod&action=custom");
$menu[$mod][] = array("访客跟踪","?mod=$mod&file=$mod&action=track");
$menu[$mod][] = array("统计设置","?mod=$mod&file=setting");
?>