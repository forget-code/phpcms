<?php
$modtitle[$mod] = '问吧管理';
$menu[$mod][] = array('类别管理', "?mod=$mod&file=category&action=manage");
$menu[$mod][] = array('问题管理', "?mod=$mod&file=question&action=manage");
$menu[$mod][] = array('回答管理', "?mod=$mod&file=answer&action=manage");
$menu[$mod][] = array('积分管理', "?mod=$mod&file=credit&action=manage");
$menu[$mod][] = array('会员头衔', "?mod=$mod&file=project&action=manage");
$menu[$mod][] = array('模块配置', "?mod=$mod&file=setting&action=setting");
$menu[$mod][] = array('标签调用管理', "?mod=$mod&file=tag&action=manage");
?>