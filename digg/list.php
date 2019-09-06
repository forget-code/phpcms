<?php
require_once './include/common.inc.php';
$cat_file = "category_" . $digg_catid . ".php";
$all_cats = cache_read($cat_file);
$head['title'] = $all_cats['catname'].$LANG['message_head_title'];
$head['keywords'] = $all_cats['catname'];
$head['description'] = $all_cats['catname'];
include template('digg', 'index');

?>