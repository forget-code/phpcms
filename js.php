<?php
/**
* JS显示
* @version phpcms 3.0.0 build 20060424
* @package phpcms
* @subpackage class
* @link http://dev.phpcms.cn phpcms模块开发网站
* @license http://www.phpcms.cn/license.html phpcms版权声明
* @copyright (C) 2005 - 2006 Phpcms Group
*/
include "common.php";

preg_match("/^[0-9a-z_]+$/i",$tag) or exit("document.write(\"wrong!\")");

$js_path = "http://".$PHP_DOMAIN;

@include PHPCMS_CACHEDIR."jstag.php";
if(!isset($jstag[$tag])) exit("document.write(\"wrong!\")");

$channelid = intval($channelid);
$catid = intval($catid);
$specialid = intval($specialid);
$page = intval($page);
$page = $page ? $page : 1;

eval($jstag[$tag].";");

$filecaching = 1;

output("strip_js");
?>