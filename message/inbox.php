<?php
require './include/common.inc.php';
if ($dosubmit)
{
	$mids = '';
	foreach ($mid as $value)
	{
		$arrTmp = explode('|', $value);
		if ($arrTmp[1] == 0)
		{
			$mids .= intval($arrTmp[0]) . ',';
		}
		elseif ($arrTmp[1] == 1)
		{
			$messageid = intval($arrTmp[0]);
			$db->query("UPDATE ".TABLE_MESSAGE_READ." SET forsake=1 WHERE messageid=$messageid AND userid=$_userid");
			if ($db->affected_rows() < 1)
			{
				$db->query("INSERT INTO ".TABLE_MESSAGE_READ." (messageid,userid,forsake) VALUES ($messageid,$_userid,1)");
			}
		}
	}
	if (!empty($mids))
	{
		$mids = substr($mids, 0, -1);
		if (isset($quite))
		{
			$db->query("DELETE FROM ".TABLE_MESSAGE_INBOX." WHERE id IN ($mids) AND receiver='$_username'");
		}
		else
		{
			$db->query("UPDATE ".TABLE_MESSAGE_INBOX." SET forsake=1 WHERE id IN ($mids) AND receiver='$_username'");
		}
	}
} elseif (isset($action))
{
	switch ($action)
	{
		case 'markunread':
			if (isset($mid) && isset($types))
			{
				if (intval($types) == 0)
				{
					$db->query("UPDATE ".TABLE_MESSAGE_INBOX." SET sight=0 WHERE id=".intval($mid)." AND receiver='$_username'");
				}
				else
				{
					$db->query("DELETE FROM ".TABLE_MESSAGE_READ." WHERE messageid=".intval($mid)." AND userid='$_userid'");
				}
			}
			break;
		case 'delete':
			if (isset($mid))
			{
				$db->query("UPDATE ".TABLE_MESSAGE_INBOX." SET forsake=1 WHERE id=".intval($mid)." AND types=0 AND receiver='$_username'");
			}
			break;
		case 'quite':
			if (isset($mid) && isset($types))
			{
				if (intval($types) == 0)
				{
					$db->query("DELETE FROM ".TABLE_MESSAGE_INBOX." WHERE id=".intval($mid)." AND types=0 AND receiver='$_username'");
				}
				else
				{
					$db->query("UPDATE ".TABLE_MESSAGE_READ." SET forsake=1 WHERE messageid=".intval($mid)." AND userid='$_userid'");
					if ($db->affected_rows() < 1)
					{
						$db->query("INSERT INTO ".TABLE_MESSAGE_READ." (messageid,userid,forsake) VALUES (".intval($mid).",'$_userid',1)");
					}
				}
			}
	}
}
include(MOD_ROOT.'/include/global.inc.php');
include template('message','inbox');
?>