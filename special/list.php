<?php
require './include/common.inc.php';

if(!isset($TYPE[$typeid])) showmessage('非法参数！');

$TYPE[$typeid] = cache_read('type_'.$typeid.'.php');
@extract($TYPE[$typeid]);
$template = $TYPE[$typeid]['template'];
$typename = $TYPE[$typeid]['name'];
$head['title'] = $name.'_'.$PHPCMS['sitename'];
$head['keywords'] = $head['description'] = $name;

include template($mod, $template);
?>