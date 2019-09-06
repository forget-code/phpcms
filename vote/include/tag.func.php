<?php
function vote_list($templateid = 0, $keyid = 'phpcms', $page = 0, $votenum = 10, $subjectlen = 30, $cols = 1)
{
	global $db,$MODULE,$PHP_TIME;
	$votenum = intval($votenum);
	$subjectlen = intval($subjectlen);
	$cols = intval($cols);
	$page = isset($page) ? $page : 1;
	$offset = $page ? ($page-1)*$votenum : 0;
	$limit = $votenum ? " LIMIT $offset,$votenum " : '';
	$today = date('Y-m-d', $PHP_TIME);
	$sql = $keyid ? " AND keyid='$keyid' " : '';
	if($page)
	{
	    $r = $db->get_one("SELECT COUNT(voteid) AS number FROM ".TABLE_VOTE_SUBJECT." WHERE passed=1 AND (todate>='$today' OR todate='0000-00-00') $sql");
	    $pages = phppages($r['number'], $page, $votenum);
	}	
	$votes = array();
	$result = $db->query("SELECT * FROM ".TABLE_VOTE_SUBJECT." WHERE passed=1 AND (todate>='$today' OR todate='0000-00-00') $sql ORDER BY voteid DESC $limit");
	while($r = $db->fetch_array($result))
	{
		$r['voteid'] = $r['voteid'];
		$r['url'] = $MODULE['vote']['linkurl'].'show.php?voteid='.$r['voteid'];
		$r['subject'] = $subjectlen ? str_cut($r['subject'], $subjectlen, '...') : $r['subject'];	
		$votes[] = $r;
	}
	$db->free_result($result);
	$templateid = $templateid ? $templateid : 'tag_vote_list';
	include template('vote', $templateid);
}

function vote_show($templateid = 0,$voteid = '')
{
	global $db,$MODULE;
	$voteid = intval($voteid);
	$frmVote = 'frmvote'.$voteid;
	$k = $db->get_one("SELECT subject,voteid,type,fromdate,todate,totalnumber FROM ".TABLE_VOTE_SUBJECT." WHERE voteid = $voteid");
	if(!$k) return FALSE;
	extract($k);
	$result = $db->query("SELECT * FROM ".TABLE_VOTE_OPTION." WHERE voteid = ".$voteid);
	$totalnum = $db->num_rows($result);
	$totalnum = $totalnum-1;
	$number = 0;
	$options = '';
	$condition = '';
	while($r = $db->fetch_array($result))
	{
		$options .= "<input type='$type' name='op[]' id=op$number$voteid value='".$r['optionid']."'>".$r['option']."<br>\n";
		$condition .= "document.getElementById('op$number$voteid').checked";
		if($totalnum != $number)
		{
			$condition .= ' || ';
		}
		$number++;
	}
	$db->free_result($result);
	$templateid = $templateid ? $templateid : 'tag_vote_show';
	include template('vote', $templateid);
}
?>