<?php
define('WEB_ROOT', str_replace("\\", '/',dirname(__FILE__)).'/');
require '../include/common.inc.php';
require WEB_ROOT.'include/common.inc.php';
if(!$category) $category = 'index';
$page = $page ? $page : 1;

$head['title'] = $system_name[$category].' - '.$companyname;
$head['keywords'] = $system_name[$category];
$head['description'] = $system_name[$category];
$urlrule = "$siteurl/category-$category.html|$siteurl/category-$category/page-\$page.html";
include template('yp','com_'.TPL.'-'.$category);
?>