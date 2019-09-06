<?php 
require './include/common.inc.php';
cache_page_start();
$solve_ques_count = solve_ask_count(1);
$nosolve_ques_count = solve_ask_count(0);

$head['keywords'] = $M['name'];
$head['description'] = $head['title'] = $M['name'].'_'.$PHPCMS['sitename'];
include template('ask', 'index');
cache_page(intval($M['autoupdate']));
?>