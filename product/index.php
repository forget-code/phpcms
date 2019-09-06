<?php 
require './include/common.inc.php';

$logo = imgurl($PHPCMS['logo']);

$head['title'] = $MOD['seo_title'];
$head['keywords'] = $MOD['seo_keywords'];
$head['description'] = $MOD['seo_description'];

$templateid = $MOD['templateid'] ? $MOD['templateid'] : "index";
include template($mod,$templateid);
?>