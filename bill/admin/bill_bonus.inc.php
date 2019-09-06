<?php
defined('IN_PHPCMS') or exit('Access Deined');
if (!isset($display))
{
	$display = 'date';
	$addtime = "to_days(addtime)=to_days(curdate())";
}
else
{
	$addtime = "year(addtime)=year(curdate()) and month(addtime)=month(curdate())";
}
if (!isset($groupby))
{
	$groupby = 'userid';
}
$res = $db->query("SELECT COUNT(*) AS times,userid,refurl FROM ".TABLE_BILL." WHERE $addtime GROUP By $groupby ORDER BY times DESC limit 10");
if ($db->num_rows($res) > 0)
{
	$record = array();
	while ($row = $db->fetch_row($res))
	{
		$record[] = $row;
	}
}
$today = array_fill(0, 3, 0);
$res = $db->query("select type,sum(number) FROM ".TABLE_BILL." WHERE TO_DAYS(addtime)=TO_DAYS(CURDATE()) GROUP BY type");
if ($db->num_rows($res) > 0)
{
	while ($row = $db->fetch_row($res))
	{
		switch ($row[0])
		{
			case 'points':
				$today[0] = $row[1];
				break;
			case 'days':
				$today[1] = $row[1];
				break;
			case 'money':
				$today[2] = $row[1];
		}
	}
}
$month = array_fill(0, 3, 0);
$res = $db->query("select type,sum(number) FROM ".TABLE_BILL." WHERE YEAR(addtime)=YEAR(CURDATE()) AND MONTH(addtime)=MONTH(CURDATE()) GROUP BY type");
if ($db->num_rows($res) > 0)
{
	while ($row = $db->fetch_row($res))
	{
		switch ($row[0])
		{
			case 'points':
				$month[0] = $row[1];
				break;
			case 'days':
				$month[1] = $row[1];
				break;
			case 'money':
				$month[2] = $row[1];
		}
	}
}
$res = $db->query("SELECT points,days,money FROM ".TABLE_BILL_BONUS." WHERE bonusid=1");
if ($db->num_rows($res) > 0)
{
	$row = $db->fetch_row($res);
}
else
{
	$row = array_fill(0, 3, 0);
}
$curUri = "?mod=$mod&file=$file&action=$action";
?>