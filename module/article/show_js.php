<?php
/**
* 文章页浏览次数和评论数统计
* @version phpcms 3.0.0 build 20060424
* @package phpcms
* @subpackage class
* @link http://dev.phpcms.cn phpcms模块开发网站
* @license http://www.phpcms.cn/license.html phpcms版权声明
* @copyright (C) 2005 - 2006 Phpcms Group
*/
defined('IN_PHPCMS') or exit(FORBIDDEN);

$articleid = intval($articleid);
if(!$articleid) exit;

$r = $db->get_one("select articleid,catid,hits from ".TABLE_ARTICLE." where articleid=$articleid ");
if($r['articleid'])
{
	$db->query("update ".TABLE_ARTICLE." set hits=hits+1 where articleid=$articleid ");
	echo "try {setidval('hits','".$r['hits']."');}catch(e){}\n";
}

$catid = $r[catid];
$p->set_catid($catid);
$r = $db->get_one("select articleid,title,includepic,titlefontcolor,titlefonttype,showcommentlink,addtime,edittime,ontop,elite from ".TABLE_ARTICLE." where catid=$catid and articleid<$articleid order by articleid desc limit 0,1","CACHE",604800);
$link = $r[articleid] ? "<a href='".$p->get_itemurl($r[articleid],$r[addtime])."'>".titleformat($r[title],$r[titlefontcolor],$r[titlefonttype],$r[includepic])."</a>" : "无";
$pre_and_next  = "<li>上一篇：".$link."</li>";
$r = $db->get_one("select articleid,title,includepic,titlefontcolor,titlefonttype,showcommentlink,addtime,edittime,ontop,elite from ".TABLE_ARTICLE." where catid=$catid and articleid>$articleid order by articleid limit 0,1","CACHE",604800);
$link = $r[articleid] ? "<a href='".$p->get_itemurl($r[articleid],$r[addtime])."'>".titleformat($r[title],$r[titlefontcolor],$r[titlefonttype],$r[includepic])."</a>" : "无";
$pre_and_next .= "<li>下一篇：".$link."</li>";

echo "try {setidval('pre_and_next','".str_replace("'","\'",$pre_and_next)."');}catch(e){}\n";

$r = $db->get_one("select count(*) as commentnumber from ".TABLE_COMMENT." where item='articleid' and itemid=$articleid ");
echo "try {setidval('commentnumber','".$r['commentnumber']."');}catch(e){}\n";
for($i=1;$i<3;$i++) echo "try {setidval('commentnumber".$i."','".$r['commentnumber']."');}catch(e){}\n";

$comment_checkcode = 0;
if(@include_once PHPCMS_CACHEDIR."config_comment.php")
{
	if($_CONFIG['comment']['comment_checkcode']) echo "try {setidval('showcheckcode','<font color=\"red\">*</font>验证码：<input name=\"checkcode\" type=\"text\" id=\"checkcode\" size=\"5\"> <img src=\"".PHPCMS_PATH."checkcode.php\" align=\"absmiddle\" />');}catch(e){}\n";
}
?>