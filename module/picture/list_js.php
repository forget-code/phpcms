<?php
/**
* 图片列表JS显示
* @version phpcms 3.0.0 build 20060424
* @package phpcms
* @subpackage class
* @link http://dev.phpcms.cn phpcms模块开发网站
* @license http://www.phpcms.cn/license.html phpcms版权声明
* @copyright (C) 2005 - 2006 Phpcms Group
*/
defined('IN_PHPCMS') or exit('Access Denied');

include PHPCMS_ROOT."/module/".$mod."/common.php";

$js_path = $_CHA['channeldomain'] ? "" : "http://".$PHP_DOMAIN;

$catid = intval($catid);
$specialid = intval($specialid);

$iselite = $iselite==1 ? 1 : 0;

$picturenum = intval($picturenum);
$picturenum = $picturenum>0 ? $picturenum : 10;

$titlelen = intval($titlelen);
$titlelen = $titlelen>0 ? $titlelen : 30;

$datenum = intval($datenum);

$ordertype = intval($ordertype);
$ordertype = ($ordertype >= 1 && $ordertype <= 6) ? $ordertype : 0;

$width = intval($width);
$width = $width ? $width : 180;

$height = intval($height);
$height = $height ? $height : 160;

if($type=="picture")
{
    picpicture(0,$channelid,$catid,1,$specialid,0,$picturenum,$titlelen,0,$iselite,$datenum,$ordertype,1,1,$width,$height,1);
}
else
{
    picturelist(0,$channelid,$catid,1,$specialid,0,$picturenum,$titlelen,0,$iselite,$datenum,$ordertype,0,0,0,0,0,1);
}

$filecaching = 1;

output("strip_js");
?>