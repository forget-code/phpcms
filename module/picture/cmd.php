<?php
/**
* 图片模块命令执行程序
* @version phpcms 3.0.0 build 20060424
* @package phpcms
* @subpackage class
* @link http://dev.phpcms.cn phpcms模块开发网站
* @license http://www.phpcms.cn/license.html phpcms版权声明
* @copyright (C) 2005 - 2006 Phpcms Group
*/
defined('IN_PHPCMS') or exit(FORBIDDEN);

require PHPCMS_ROOT."/module/".$mod."/common.php";
require_once PHPCMS_ROOT."/include/cmd.php";

@extract(cmd_check($action,$forward,$auth,$verify));

switch($action)
{
	case 'picture2html':
        tohtml("picture");
        include PHPCMS_ROOT."/include/updatewithinfo.php";
	break;
}

$enablemessage ? message('操作成功！',$forward) : header("location:".$forward);
?>