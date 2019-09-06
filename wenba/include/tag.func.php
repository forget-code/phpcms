<?php
function question_list($templateid = '', $catid = 0, $child = 0, $page = 0, $ques_num = 10, $subjectlen = 30, $elite = 0, $ques_type = '', $showcatname = 0, $datetype = 0, $datenum = 0, $ordertype = 0, $username = '', $target = 0, $cols = 1)
{
	global $db,$PHP_TIME,$MOD,$PHPCMS,$MODULE,$ques, $skindir;
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$ordertypes = array('qid DESC', 'qid ASC', 'hits DESC', 'hits ASC');
	$page = isset($page) ? intval($page) : 1;
	if($datetype < 0 || $datetype > 6) $datetype = 0;
	if($ordertype < 0 || $ordertype > 3) $ordertype = 0;

	$CATEGORY = cache_read('categorys_wenba.php');
	$ques_num = intval($ques_num);
	$subjectlen = intval($subjectlen);
	$cols = intval($cols);
	$target = intval($target);
	if($ques_type=='nosolve')
	{
		$sql = 'status=1';
	}
	elseif($ques_type=='solve')
	{
		$sql = 'status=2';
	}
	elseif($ques_type=='highscore')
	{
		$sql = 'score>'.$MOD['highscore'];
	}
	elseif($ques_type=='vote')
	{
		$sql = 'status=3';
	}
	else
	{
		$sql = '1';
	}
	$condition = '';
	if($catid)
	{
		if(is_numeric($catid))
		{
			if($child && $CATEGORY[$catid]['child'] && $CATEGORY[$catid]['arrchildid'])
			{
				$condition .= ' AND catid IN ('.$CATEGORY[$catid]['arrchildid'].') ';
			}
			else
			{
				$condition .= " AND catid=$catid ";
			}
		}
		else
		{
			$catid = new_addslashes($catid);
			$condition .= " AND catid IN ($catid) ";
		}
	}
	if($datenum) $condition .= " AND addtime>$PHP_TIME-86400*$datenum ";
	if($username) $condition .= " AND username='$username' ";
	if($elite) $sql .= ' AND elite=1';
	$offset = $page ? ($page-1)*$ques_num : 0;
	if($page && $ques_num)
	{
		$r = $db->get_one("SELECT SQL_CACHE count(qid) AS number FROM ".TABLE_WENBA_QUESTION." WHERE $sql $condition ","CACHE");
		$total = $r['number'];
		$pages = phppages($total, $page, $ques_num);
	}
	
	$ordertype = $ordertypes[$ordertype];
	$limit = $ques_num ? " LIMIT $offset, $ques_num " : 'LIMIT 0, 10';
	$question = array();
	$result = $db->query("SELECT SQL_CACHE * FROM ".TABLE_WENBA_QUESTION." WHERE $sql $condition ORDER BY $ordertype $limit ","CACHE");
	while($r = $db->fetch_array($result))
	{
		$r['adddate'] = $datetype ? date($datetypes[$datetype],$r['asktime']) : '';
		$r['catname'] = $CATEGORY[$r['catid']]['catname'];
		$r['title'] = $subjectlen ? str_cut($r['title'],$subjectlen,'...') : '';
		if($showcatname)
		{
			$r['catname'] = $CATEGORY[$r['catid']]['catname'];
			$r['catlinkurl'] = $MODULE['wenba']['linkurl'].$CATEGORY[$catid]['linkurl'];
		}
		$question[] = $r;
	}
	$db->free_result($result);
	$target = $target ? 'target="_blank"' : '';
	$width = ceil(100/$cols).'%';
	if(!$templateid) $templateid = 'tag_question_list';
	include template('wenba',$templateid);
}

function credit_list($templateid = '',$credit_num = 10, $page = 0, $datetype = 0, $target = 0,$cols = 1,$credit_status = '')
{
	global $db,$PHP_TIME,$MOD,$MODULE, $skindir;
	$credit_num = intval($credit_num);
	$cols = intval($cols);
	$target = intval($target);
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$page = isset($page) ? intval($page) : 1;
	if($datetype < 0 || $datetype > 6) $datetype = 0;
	$condition = '';
	$offset = $page ? ($page-1)*$credit_num : 0;
	$ACTOR = cache_read('actors.php');
	if($credit_status == 'all')
	{
		if($page && $credit_num)
		{
			$r = $db->get_one("SELECT SQL_CACHE count(userid) AS number FROM ".TABLE_MEMBER." $limit","CACHE");	
			$pages = phppages($r['number'], $page, $credit_num);
		}
		$limit = $credit_num ? " LIMIT $offset, $credit_num " : 'LIMIT 0, 10';
		$creditlist = array();
		$result = $db->query("SELECT SQL_CACHE username,credit,lastlogintime,totalonline,logintimes,answercounts,acceptcount,actortype FROM ".TABLE_MEMBER." ORDER BY credit DESC $limit ","CACHE");
		while($r = $db->fetch_array($result))
		{
			$r['lastlogintime'] = $datetype ? date($datetypes[$datetype],$r['lastlogintime']) : '';
			$r['totalonline_hour']=intval($r['totalonline']/3600);
			$r['totalonline_minute']=round(($r['totalonline']%3600)/60);
			if(!$r['actortype']) $r['actortype'] = 0;
			$acts = $ACTOR[$r['actortype']];
			foreach($acts As $k=>$v)
			{
				if($r['credit']>=$v['min'] && $r['credit']<$v['max'])
				{
					$r['grade'] = $v['grade'];
					$r['actor'] = $v['actor'];
				}
				elseif($r['credit']>$v['max'])
				{
					$r['grade'] = $v['grade'];
					$r['actor'] = $v['actor'];
				}
			}
			$creditlist[] = $r;
		}
	}
	else
	{
		if($page && $credit_num)
		{
			$r = $db->get_one("SELECT SQL_CACHE count(cid) AS number FROM ".TABLE_WENBA_CREDIT." $limit","CACHE");	
			$pages = phppages($r['number'], $page, $credit_num);
		}
		$limit = $credit_num ? " LIMIT $offset, $credit_num " : 'LIMIT 0, 10';

		$__tip = $credit_status == 'week' ? 'preweek' : 'premonth';
		$creditlist = array();
		$result = $db->query("SELECT SQL_CACHE * FROM ".TABLE_WENBA_CREDIT." ORDER BY $__tip DESC $limit ","CACHE");
		while($r = $db->fetch_array($result))
		{
			extract($db->get_one("SELECT credit,lastlogintime,totalonline,logintimes,answercounts,acceptcount,actortype FROM ".TABLE_MEMBER." WHERE username='$r[username]'"));
			$r['lastlogintime'] = $datetype ? date($datetypes[$datetype],$lastlogintime) : '';
			$r['totalonline_hour']=intval($totalonline/3600);
			$r['totalonline_minute']=round(($totalonline%3600)/60);
			$r['credit'] = $r[$__tip];
			$r['logintimes'] = $logintimes;
			$r['answercounts'] = $answercounts;
			$r['acceptcount'] = $acceptcount;
			if(!$actortype) $actortype = 0;
			$acts = $ACTOR[$actortype];
			foreach($acts As $k=>$v)
			{
				if($credit>=$v['min'] && $credit<=$v['max'])
				{
					$r['grade'] = $v['grade'];
					$r['actor'] = $v['actor'];
				}
				elseif($credit>$v['max'])
				{
					$r['grade'] = $v['grade'];
					$r['actor'] = $v['actor'];
				}
			}
			$creditlist[] = $r;
		}
	}
	$j = 1;
	$target = $target ? 'target="_blank"' : '';
	$width = ceil(100/$cols).'%';
	if(!$templateid) $templateid = 'tag_credit_list';
	include template('wenba',$templateid);
}
?>