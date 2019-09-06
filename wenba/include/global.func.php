<?php 
defined('IN_PHPCMS') or exit('Access Denied');

function update_score($username, $credit, $add = 0)
{
	global $db,$PHP_TIME;
	if($add)
	{
		$r = $db->get_one("SELECT COUNT(*) AS num FROM ".TABLE_WENBA_CREDIT." WHERE username='$username'");
		if($r['num']==0)
		{
			$db->query("INSERT INTO ".TABLE_WENBA_CREDIT." (username, month, week, addtime) VALUES ('$username', 0, 0, $PHP_TIME)");
		}

		$timestamp = $PHP_TIME;
		$months = date('n',$timestamp);
		$years = date('Y',$timestamp);
		$liveweek = date('w', $timestamp);
		$weeks = $liveweek*86400+date('H')*3600+date('i')*60+date('s');
		$ymdate = mktime(0,0,0,$months,1,$years);
		$credit = intval($credit);

		@extract($db->get_one("SELECT * FROM ".TABLE_WENBA_CREDIT." WHERE username='$username'"));
		if($timestamp-$addtime>=$weeks)
		{
			$db->query("UPDATE ".TABLE_WENBA_CREDIT." SET `preweek`=`week`, `week`=$credit WHERE username='$username'");
			if(($timestamp-$addtime)>=($addtime-$ymdate))
			$db->query("UPDATE ".TABLE_WENBA_CREDIT." SET `premonth`=`month`, `month`=$credit WHERE username='$username'");
		}
		else
		{
			$db->query("UPDATE ".TABLE_WENBA_CREDIT." SET `week`=`week`+$credit WHERE username='$username'");
			if(($timestamp-$addtime)<($addtime-$ymdate))
			$db->query("UPDATE ".TABLE_WENBA_CREDIT." SET `month`=`month`+$credit WHERE username='$username'");
		}
	}
	else 
	{
		$r = $db->get_one("SELECT COUNT(*) AS num FROM ".TABLE_WENBA_CREDIT." WHERE username='$username'");
		if($r['num']==0)
		{
			$db->query("INSERT INTO ".TABLE_WENBA_CREDIT." (username, month, week, addtime) VALUES ('$username', 0, 0, $PHP_TIME)");
		}
		else
		{
			extract($db->get_one("SELECT month,week FROM ".TABLE_WENBA_CREDIT." WHERE username='$username'"));
			if(($month && $credit<$week && $credit<$month) || ($week && $credit<$week && $credit<$month))
			{
				$db->query("UPDATE ".TABLE_WENBA_CREDIT." SET `month`=`month`-$credit, `week`=`week`-$credit WHERE username='$username'");
			}
			elseif($credit>$week)
			{
				$db->query("UPDATE ".TABLE_WENBA_CREDIT." SET `month`=0, `week`=0 WHERE username='$username'");
			}
		}
	}
}
?>