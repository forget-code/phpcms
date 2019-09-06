<?php 
require dirname(__FILE__).'/include/common.inc.php';

$head['title'] = '热门标签-'.$PHPCMS['sitename'];

include template('phpcms', 'tags');
?>