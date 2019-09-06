<?php
/**
* 生成搜索框
* @version phpcms 3.0.0 build 20060424
* @package phpcms
* @subpackage class
* @link http://dev.phpcms.cn phpcms模块开发网站
* @license http://www.phpcms.cn/license.html phpcms版权声明
* @copyright (C) 2005 - 2006 Phpcms Group
*/
defined('IN_PHPCMS') or exit(FORBIDDEN);

ob_start();
include template("phpcms","search");
$data = ob_get_contents();
ob_clean();
$data = strip_js($data);
file_write(PHPCMS_ROOT."/data/js/search.js",$data);
?>