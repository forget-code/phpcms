<?php
/**
* 评论列表JS显示
* @version phpcms 3.0.0 build 20060424
* @package phpcms
* @subpackage class
* @link http://dev.phpcms.cn phpcms模块开发网站
* @license http://www.phpcms.cn/license.html phpcms版权声明
* @copyright (C) 2005 - 2006 Phpcms Group
*/
require "common.php";

$commentnum = intval($commentnum);
$commentnum = $commentnum>0 ? $commentnum : 10;
$ordertype = $ordertype==1 ? 1 : 0;

commentlist(0,$item,$itemid,0,$commentnum,$ordertype);

$filecaching = 0;
output("strip_js");
?>