<?php
/**
* 下载页浏览次数和评论数统计
* @version phpcms 3.0.0 build 20060424
* @package phpcms
* @subpackage class
* @link http://dev.phpcms.cn phpcms模块开发网站
* @license http://www.phpcms.cn/license.html phpcms版权声明
* @copyright (C) 2005 - 2006 Phpcms Group
*/
defined('IN_PHPCMS') or exit(FORBIDDEN);

$downid = intval($downid);
if(!$downid) exit;

$r = $db->get_one("select downid,catid,hits,downs,daydowns,weekdowns,monthdowns from ".TABLE_DOWN." where downid=$downid ");
if($r['downid'])
{
	$db->query("update ".TABLE_DOWN." set hits=hits+1 where downid=$downid ");
	echo "try {setidval('hits','".$r['hits']."');}catch(e){}\n";
	echo "try {setidval('downs','".$r['downs']."');}catch(e){}\n";
	echo "try {setidval('daydowns','".$r['daydowns']."');}catch(e){}\n";
	echo "try {setidval('weekdowns','".$r['weekdowns']."');}catch(e){}\n";
	echo "try {setidval('monthdowns','".$r['monthdowns']."');}catch(e){}\n";
}

$catid = $r[catid];

$r = $db->get_one("select count(*) as commentnumber from ".TABLE_COMMENT." where item='downid' and itemid=$downid ");
echo "try {setidval('commentnumber','".$r['commentnumber']."');}catch(e){}\n";
for($i=1;$i<3;$i++) echo "try {setidval('commentnumber".$i."','".$r['commentnumber']."');}catch(e){}\n";

$comment_checkcode = 0;
if(@include_once PHPCMS_CACHEDIR."config_comment.php")
{
	if($_CONFIG['comment']['comment_checkcode']) echo "try {setidval('showcheckcode','<font color=\"red\">*</font>验证码：<input name=\"checkcode\" type=\"text\" id=\"checkcode\" size=\"5\"> <img src=\"".PHPCMS_PATH."checkcode.php\" align=\"absmiddle\" />');}catch(e){}\n";
}
?>