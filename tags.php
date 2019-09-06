<?php 
require dirname(__FILE__).'/include/common.inc.php';
if(isset($page)) $page = max(intval($page), 1);
$head['title'] = '热门标签-'.$PHPCMS['sitename'];

include template('phpcms', 'tags');
?>