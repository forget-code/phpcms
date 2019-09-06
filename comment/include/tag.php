<?php
/**
* 评论标签
* @version phpcms 3.0.0 build 20060424
* @package phpcms
* @subpackage class
* @link http://dev.phpcms.cn phpcms模块开发网站
* @license http://www.phpcms.cn/license.html phpcms版权声明
* @copyright (C) 2005 - 2006 Phpcms Group
*/
defined('IN_PHPCMS') or exit(FORBIDDEN);

function commentlist($templateid,$item,$itemid,$page=0,$commentnum=10,$ordertype=0)
{
	global $db,$p,$timestamp;
	$offset = $page ? ($page-1)*$commentnum : 0;
	$limit = $commentnum ? ' LIMIT '.$offset.','.$commentnum : '';
	if($page && $commentnum)
	{
		$r = $db->get_one("SELECT count(*) AS number FROM ".TABLE_COMMENT." WHERE item='$item' AND itemid='$itemid' AND passed=1","CACHE");
		$url = "?item=".$item."&itemid=".$itemid;
        $number = $r['number']; 
		$pages = phppages($number,$page,$commentnum,$url);
	}
	$order = $ordertype ? "DESC" : "";
	$result=$db->query("SELECT * FROM ".TABLE_COMMENT." WHERE item='$item' AND itemid='$itemid' AND passed=1 ORDER BY commentid $order $limit","CACHE");
	while($r=$db->fetch_array($result))
	{
		$r[addtime] = date('Y-m-d H:i:s',$r[addtime]);
		$r[score] = stars($r[score]);
		$r[content] = strip_textarea(keylink(reword($r[content])));
		$comments[] = $r;
	}
	unset($r);
	$db->free_result($result);
	include template('comment','tag_commentlist');
}
?>