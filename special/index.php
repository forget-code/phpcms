<?php
require './include/common.inc.php';
$head['title'] = '专题'.'_'.$PHPCMS['sitename'];
$head['keywords'] = $head['description'] = '专题';
include template($mod, 'index');
?>