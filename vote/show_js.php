<?php 
require_once "common.php";

require_once MOD_ROOT.'/include/tag.php';

$voteid = intval($voteid);
if(!$voteid) message("非法参数","goback");

voteshow(0,$voteid);

$filecaching = 1;
output("strip_js");
?>