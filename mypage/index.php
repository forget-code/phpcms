<?php
require "../include/common.inc.php"; 
isset($name) or showmessage("对不起，参数错误！");
preg_match('/^[0-9a-z_]+$/i',$name) or showmessage("对不起，参数错误！");

$r = $db->get_one("select * from ".TABLE_MYPAGE." where name='$name'","CACHE",604800);
$r['mypageid'] or showmessage("网页不存在！");
@extract($r);

$skindir = $skinid ? PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid : $skindir;
$templateid = $templateid ? $templateid : 'mypage';
$filecaching = 1;

$head['title'] = $seo_title;
$head['keywords'] = $seo_keywords;
$head['description'] = $seo_description;

include template("mypage",$templateid);
?>