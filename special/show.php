<?php
require './include/common.inc.php';
$r = $special->get($specialid);
if(!$r) showmessage('专题不存在！');
extract($r);
if($disabled) showmessage('专题已经暂停播放');
$head['title'] = $title.'_'.$TYPE[$typeid]['name'].'_'.$PHPCMS['sitename'];
$head['keywords'] = $title;
$head['description'] = strip_tags($description);
include template($mod, $template);
?>