<?php
require './include/common.inc.php';
$r = $special->get($specialid);
if(!$r) showmessage('专题不存在！');
extract($r);
$head['title'] = $title;
$head['keywords'] = $title;
$head['description'] = strip_tags($description);
include template($mod, 'list');
?>