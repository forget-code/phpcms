<?php
/**
* 图片页浏览次数和评论数统计
* @version phpcms 3.0.0 build 20060424
* @package phpcms
* @subpackage class
* @link http://dev.phpcms.cn phpcms模块开发网站
* @license http://www.phpcms.cn/license.html phpcms版权声明
* @copyright (C) 2005 - 2006 Phpcms Group
*/
defined('IN_PHPCMS') or exit(FORBIDDEN);

$pictureid = intval($pictureid);
if(!$pictureid) exit;

$r = $db->get_one("select pictureid,catid,hits from ".TABLE_PICTURE." where pictureid=$pictureid ");
if($r['pictureid'])
{
	$db->query("update ".TABLE_PICTURE." set hits=hits+1 where pictureid=$pictureid ");
	echo "try {setidval('hits','".$r['hits']."');}catch(e){}\n";
}

$catid = $r[catid];

$r = $db->get_one("select count(*) as commentnumber from ".TABLE_COMMENT." where item='pictureid' and itemid=$pictureid ");
echo "try {setidval('commentnumber','".$r['commentnumber']."');}catch(e){}\n";
for($i=1;$i<3;$i++) echo "try {setidval('commentnumber".$i."','".$r['commentnumber']."');}catch(e){}\n";

$comment_checkcode = 0;
if(@include_once PHPCMS_CACHEDIR."config_comment.php")
{
	if($_CONFIG['comment']['comment_checkcode']) echo "try {setidval('showcheckcode','<font color=\"red\">*</font>验证码：<input name=\"checkcode\" type=\"text\" id=\"checkcode\" size=\"5\"> <img src=\"".PHPCMS_PATH."checkcode.php\" align=\"absmiddle\" />');}catch(e){}\n";
}
?>