<?php
require './include/common.inc.php';
require_once MOD_ROOT.'admin/include/mood.class.php';
$mood = new mood();
$r = $mood->show($moodid);
for($i=1;$i<=$r['number'];$i++)
{
	$field = 'm'.$i;
	$m = explode('|',$r[$field]);
	$cache[$i] = $infos[$i]['title'] = trim($m[0]);
	$infos[$i]['id'] = $i;
	$infos[$i]['img'] = trim($m[1]);
}
$head['title'] = '心情排行'.'_'.$PHPCMS['sitename'];
$head['keywords'] = '心情排行,心情指数,排行';
include template($mod, 'rank');
?>