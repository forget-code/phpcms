<?php
require './include/common.inc.php';
if ($dosubmit)
{
	if (isset($find))
	{
		if (!in_array($range, array('title', 'content')))
		{
			$range = 'title';
		}
		$range = " AND $range LIKE '%{$keyword}%'";
		$days = intval($days);
		if ($days > 0)
		{
			$secs = time() - $days * 60 * 60 * 24;
			switch ($term)
			{
				case 'after':
					$term = '>';
					break;
				case 'before':
					$term = '<';
					break;
				default:
					showmessage($LANG['illegal_operation'], $PHP_REFERER);
			}
			$term = " AND sendtime{$term}={$secs}";
		}
		else
		{
			$term = '';
		}
		switch ($aim)
		{
			case 'inbox':
				$sql = "(SELECT id,sender,title,sendtime,types FROM ".TABLE_MESSAGE_INBOX." WHERE receiver IN ('$_username','null'){$range}{$term} and types=0 AND forsake=0";
				$temp = ") UNION ALL (SELECT ".TABLE_MESSAGE_INBOX.".id,".TABLE_MESSAGE_INBOX.".sender,".TABLE_MESSAGE_INBOX.".title,".TABLE_MESSAGE_INBOX.".sendtime,1 FROM ".TABLE_MESSAGE_INBOX;
				if (isset($sighted) && !isset($sight))
				{
					$sql .= " AND sight=1";
					$temp .= ",".TABLE_MESSAGE_READ." WHERE ".TABLE_MESSAGE_INBOX.".id=".TABLE_MESSAGE_READ.".messageid AND ".TABLE_MESSAGE_READ.".userid=$_userid AND ".TABLE_MESSAGE_READ.".forsake=0 AND ".TABLE_MESSAGE_INBOX.".types=1 AND (".TABLE_MESSAGE_INBOX.".title LIKE '%{$keyword}%' OR ".TABLE_MESSAGE_INBOX.".content LIKE '%{$keyword}%')";
				}
				elseif (!isset($sighted) && isset($sight))
				{
					$sql .= " AND sight=0";
					$temp .= " LEFT JOIN ".TABLE_MESSAGE_READ." ON ".TABLE_MESSAGE_INBOX.".id=".TABLE_MESSAGE_READ.".messageid AND ".TABLE_MESSAGE_READ.".userid=$_userid WHERE ".TABLE_MESSAGE_INBOX.".types=1 AND ".TABLE_MESSAGE_READ.".messageid IS NULL AND (".TABLE_MESSAGE_INBOX.".title LIKE '%{$keyword}%' OR ".TABLE_MESSAGE_INBOX.".content LIKE '%{$keyword}%'))";
				}
				else
				{
					$temp .= " LEFT JOIN ".TABLE_MESSAGE_READ." ON ".TABLE_MESSAGE_INBOX.".id=".TABLE_MESSAGE_READ.".messageid AND ".TABLE_MESSAGE_READ.".userid=$_userid AND ".TABLE_MESSAGE_READ.".forsake=1 WHERE ".TABLE_MESSAGE_INBOX.".types=1 AND ".TABLE_MESSAGE_READ.".messageid IS NULL AND (".TABLE_MESSAGE_INBOX.".title LIKE '%{$keyword}%' OR ".TABLE_MESSAGE_INBOX.".content LIKE '%{$keyword}%'))";
				}
				$sql = $sql . $temp;
				if ($orderby == 'username')
				{
					$sql .= " ORDER BY sender";
				}
				break;
			case 'outbox':
				$sql = "SELECT id,receiver,title,sendtime FROM ".TABLE_MESSAGE_OUTBOX." WHERE sender='$_username'{$range}{$term} AND forsake=0";
				if ($orderby == 'username')
				{
					$sql .= " ORDER BY receiver";
				}
				break;
			case 'track':
				$sql = "SELECT id,receiver,title,sendtime FROM ".TABLE_MESSAGE_INBOX." WHERE sender='$_username'{$range}{$term} and types=0 AND forsake=0";
				if ($orderby == 'username')
				{
					$sql .= " ORDER BY sender";
				}
				break;
			default:
				showmessage($LANG['illegal_operation'], $PHP_REFERER);
		}
		if ($orderby == 'sendtime')
		{
			$sql .= " ORDER BY sendtime";
		}
		if (in_array($ordermethod, array('asc', 'desc')))
		{
			$sql .= " $ordermethod";
		}
		$res = $db->query($sql);
		if ($db->num_rows($res) > 0)
		{
			while ($row = $db->fetch_row($res))
			{
				$messages[] = $row;
			}
		}
		else
		{
			showmessage($LANG['not_exist'], $PHP_REFERER);
		}
	}
	else
	{
		$mids = '';
		if ($aim == 'inbox' || $aim == 'track')
		{
			foreach ($mid as $value)
			{
				if (is_numeric($value))
				{
					$mids .= intval($value) . ',';
				}
				else
				{
					$arrTmp = explode('|', $value);
					if (intval($arrTmp[1]) == 0)
					{
						$mids .= intval($arrTmp[0]) . ',';
					}
					else
					{
						$messageid = intval($arrTmp[0]);
						$db->query("UPDATE ".TABLE_MESSAGE_READ." SET forsake=1 WHERE messageid=$messageid AND userid=$_userid");
						if ($db->affected_rows() < 1)
						{
							$db->query("INSERT INTO ".TABLE_MESSAGE_READ." (messageid,userid,forsake) VALUES ($messageid,$_userid,1)");
						}
					}
				}
			}
			if (!empty($mids))
			{
				$mids0 = substr($mids0, 0, -1);
				$db->query("DELETE FROM ".TABLE_MESSAGE_INBOX." WHERE id IN ($mids0) AND receiver='$_username' AND types=0");
			}
		}
		elseif ($aim == 'outbox')
		{
			foreach ($mid as $value)
			{
				$mids .= intval($value) . ',';
			}
			$mids = substr($mids, 0, -1);
			$db->query("DELETE FROM ".TABLE_MESSAGE_OUTBOX." WHERE id IN ($mids) AND sender='$_username'");
		}
		else
		{
			showmessage($LANG['illegal_operation'], $PHP_REFERER);
		}
	}
}
include(MOD_ROOT.'/include/global.inc.php');
include template('message','search');
?>