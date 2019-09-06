<?php
function tag_ask($array = array())
{
	if(!$array['mode'])
	{
		if($array['catid']) $sql .= " AND catid='$array[catid]'";
		if($array['userid']) $sql .= " AND userid='$array[userid]'";
		if($array['flag'] != -1) $sql .= " AND flag='$array[flag]'";
		if($array['status']== -1)
		{
			$sqls = "SELECT * FROM `".DB_PRE."ask` WHERE status>2 $sql ORDER BY $array[orderby]";
		}
		else
		{
			$sqls = "SELECT * FROM `".DB_PRE."ask` WHERE status='$array[status]' $sql ORDER BY $array[orderby]";
		}
	}
	return $sqls;
}
function tag_credit($array = array())
{
	if($array['flag'] == 0)//总积分
	{
		$sqls = "SELECT m.userid,m.username,m.point,i.lastlogintime,i.logintimes,i.actortype,i.answercount,i.acceptcount FROM `".DB_PRE."member` m LEFT JOIN `".DB_PRE."member_info` i ON m.userid=i.userid ORDER BY point DESC";
	}
	else if($array['flag'] == 1)//月积分排行榜
	{
		$sqls = "SELECT m.userid,m.username,m.premonth AS point,i.lastlogintime,i.logintimes,i.actortype,i.answercount,i.acceptcount FROM `".DB_PRE."ask_credit` m LEFT JOIN `".DB_PRE."member_info` i ON m.userid=i.userid ORDER BY premonth DESC";
	}
	else if($array['flag'] == 2)//周积分排行榜
	{
		$sqls = "SELECT m.userid,m.username,m.preweek AS point,i.lastlogintime,i.logintimes,i.actortype,i.answercount,i.acceptcount FROM `".DB_PRE."ask_credit` m LEFT JOIN `".DB_PRE."member_info` i ON m.userid=i.userid ORDER BY preweek DESC";
	}
	return $sqls;
}
?>