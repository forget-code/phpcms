<?php
/*
*####################################################
* PHPCMS v3.0.0 - Advanced Content Manage System.
* Copyright (c) 2005-2006 phpcms.cn
*
* For further information go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*####################################################
*/

//投票列表调用标签
function votelist($templateid,$channelid,$page=0,$votenum=12,$subjectlen=30,$showtype=0,$cols=1){
	global $db,$timestamp;
	$today = date("Y-m-d");
	$offset = $page ? ($page-1)*$votenum : 0;
	$limit = $votenum ? ' LIMIT '.$offset.','.$votenum : '';
	$width = ceil(100/$cols).'%';
	if($page)
	{
	    $r = $db->get_one("SELECT count(*) AS number FROM ".TABLE_VOTESUBJECT." WHERE channelid='$channelid' AND passed=1 AND (todate>='$today' OR todate='0000-00-00')");
	    $url = "?channelid=".$channelid;
	    $pages = phppages($r[number],$page,$votenum,$url);
	}
	$result = $db->query("SELECT * FROM ".TABLE_VOTESUBJECT." WHERE channelid='$channelid' AND passed=1 AND (todate>='$today' OR todate='0000-00-00') $limit ");
	while($r=$db->fetch_array($result))
	{
		$vote[voteid] = $r[voteid];
		$vote[url] = "show.php?voteid=".$r[voteid];
		$vote[subject] = $subjectlen ? wordscut($r[subject],$subjectlen,0) : '';
		$votes[]=$vote;
	}
	include template('vote','tag_votelist');
	unset($r);
	$db->free_result($result);
}
?>