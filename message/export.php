<?php
require './include/common.inc.php';
if ($dosubmit)
{
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
	switch ($folder)
	{
		case 'inbox':
			$sql = "(SELECT id,sender,title,content,sendtime FROM ".TABLE_MESSAGE_INBOX." WHERE receiver='$_username' AND forsake=0 AND types=0". $term . ") UNION ALL (SELECT ".TABLE_MESSAGE_INBOX.".id,".TABLE_MESSAGE_INBOX.".sender,".TABLE_MESSAGE_INBOX.".title,".TABLE_MESSAGE_INBOX.".content,".TABLE_MESSAGE_INBOX.".sendtime FROM ".TABLE_MESSAGE_INBOX." LEFT JOIN ".TABLE_MESSAGE_READ." ON ".TABLE_MESSAGE_INBOX.".id=".TABLE_MESSAGE_READ.".messageid AND ".TABLE_MESSAGE_READ.".userid='$_userid' AND ".TABLE_MESSAGE_READ.".forsake=1 WHERE ".TABLE_MESSAGE_INBOX.".types=1";
			$term = str_replace('sendtime', TABLE_MESSAGE_INBOX.'.sendtime', $term);
			$sql .= $term . " AND ".TABLE_MESSAGE_READ.".messageid IS NULL)";
			break;
		case 'outbox':
			$sql = "SELECT id,receiver,title,content,sendtime FROM ".TABLE_MESSAGE_OUTBOX." WHERE sender='$_username' AND forsake=0" . $term;
			break;
		default:
			showmessage($LANG['illegal_operation'], $PHP_REFERER);
	}
	$sql .= " ORDER BY id DESC";
	$quantity = intval($quantity);
	if ($quantity > 0)
	{
		$sql .= " limit " . $quantity;
	}
	$res = $db->query($sql);
	if ($db->num_rows($res) > 0)
	{
		$export = 1;
	}
	else
	{
		showmessage($LANG['not_exist'], $PHP_REFERER);
	}
}
elseif (isset($folder) && isset($mid) && intval($mid) > 0)
{
	$mid = intval($mid);
	switch ($folder)
	{
		case 'inbox':
			$res = $db->query("SELECT sender,title,content,sendtime FROM ".TABLE_MESSAGE_INBOX." WHERE id=$mid AND receiver IN ('$_username','null') AND forsake=0");
			if ($db->num_rows($res) > 0)
			{
				$export = 1;
			}
			break;
		case 'outbox':
			$res = $db->query("SELECT receiver,title,content,sendtime FROM ".TABLE_MESSAGE_OUTBOX." WHERE id=$mid AND sender='$_username' AND forsake=0");
			if ($db->num_rows($res) > 0)
			{
				$export = 1;
			}
			break;
		case 'track':
			$res = $db->query("SELECT receiver,title,content,sendtime FROM ".TABLE_MESSAGE_INBOX." WHERE id=$mid AND sender='$_username'");
			if ($db->num_rows($res) > 0)
			{
				$export = 1;
			}
			break;
		default:
			showmessage($LANG['illegal_operation'], $PHP_REFERER);
	}
}
if (isset($export))
{
	ob_start();
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title><?php echo $PHP_DOMAIN; ?></title>
<style type="text/css">
<!--
body {
	font-family:Verdana,Tahoma;
	font-size:12px;
	margin:20px;
	padding: 0px;
	background-color:#FFFFFF;
	color:#000000;
}
h1 {
	text-align:left;
	font-size:18px;
	margin-top:0px;
	margin-bottom:10px;
	width:auto;
}
h2 {
	text-align:left;
	padding-top:8px;
	padding-left:5px;
	margin-bottom:0px;
	font-size:12px;
	height:30px;
	border-bottom:1px solid #86B9D6;
	background-color:#EBF6FB;
}
h3 {
	margin-right:5px;
	margin-bottom:0px;
	text-align:right;
	font-size:12px;
	font-weight:normal;
}
div {
	margin-top:10px;
	padding-bottom:5px;
	width:100%;
	text-align:left;
	border:1px solid #86B9D6;
}
span {
	margin-left:5px;
	color:#000066;
}
-->
</style>
</head>
<body>
<?php
echo '<h1>' . $LANG['export_message'];
if ($dosubmit)
{
	echo '(';
	switch ($folder)
	{
		case 'inbox':
			echo $LANG['inbox'];
			break;
		case 'outbox':
			echo $LANG['outbox'];
	}
	echo ')';
}
?>
</h1>
<h3><?php echo "{$_username}@" . date('Y-m-d H:i:s'); ?></h3>
<?php
if ($dosubmit)
{
	switch ($folder)
	{
		case 'inbox':
			$fromto = $LANG['from'];
			break;
		case 'outbox':
			$fromto = $LANG['send_to'];
	}
	$mids = '';
	$i = 1;
	while ($row = $db->fetch_row($res))
	{
		$time = date('Y-m-d H:i:s', $row[4]);
		$content = strip_tags($row[3]);
		echo "<div><h2>{$i}.{$row[2]}</h2><span>{$LANG['time']}:</span>{$time}<br><span>{$fromto}:</span>";
		if ($row[1] == $LANG['systems_manager'])
		{
			$mids .= $row[0] . 'a,';
			echo $row[1];
		}
		else
		{
			$mids .= $row[0] . ',';
			echo "{$row[1]}";
		}
		echo "<br><span>{$LANG['Content']}:</span>{$content}</div>";
		$i++;
	}
	if (isset($delete))
	{
		$mids = substr($mids, 0, -1);
		switch ($folder)
		{
			case 'inbox':
				$arrTmp = explode(',', $mids);
				$mids0 = '';
				for ($i = 0; $i < count($arrTmp); $i++)
				{
					if (is_numeric($arrTmp[$i]))
					{
						$mids0 .= $arrTmp[$i] . ',';
					}
					else
					{
						$mids1 = intval($arrTmp[$i]);
						$db->query("UPDATE ".TABLE_MESSAGE_READ." SET forsake=1 WHERE messageid=$mids1 AND userid=$_userid");
						if ($db->affected_rows() < 1)
						{
							$db->query("INSERT INTO ".TABLE_MESSAGE_READ." (messageid,userid,forsake) VALUES ($mids1,$_userid,1)");
						}
					}
				}
				if (!empty($mids0))
				{
					$mids0 = substr($mids0, 0, -1);
					$db->query("DELETE FROM ".TABLE_MESSAGE_INBOX." WHERE id IN ($mids)");
				}
				break;
			case 'outbox':
				$db->query("DELETE FROM ".TABLE_MESSAGE_OUTBOX." WHERE id IN ($mids)");
		}
	}
} elseif (isset($mid))
{
	$row = $db->fetch_row($res);
	$time = date('Y-m-d H:i:s', $row[3]);
	$content = strip_tags($row[2]);
	switch ($folder)
	{
		case 'inbox':
			$fldname = $LANG['inbox'];
			$fromto = $LANG['from'];
			break;
		case 'outbox':
			$fldname = $LANG['outbox'];
			$fromto = $LANG['send_to'];
			break;
		case 'track':
			$fldname = $LANG['inbox'];
			$fromto = $LANG['send_to'];
	}
	echo "<div><h2>{$row[1]}</h2><span>{$LANG['time']}:</span>{$time}<br><span>{$LANG['folder']}:</span>{$fldname}<br><span>{$fromto}:</span>";
	if ($row[0] == $LANG['systems_manager'])
	{
		echo $row[0];
	}
	else
	{
		echo "{$row[0]}";
	}
	echo "<br><span>{$LANG['Content']}:</span>{$content}</div>";
}
?>
</body>
</html>
<?php
$filename = "message_{$_username}_" . date('YmdHis') . ".htm";
header("Content-Disposition: attachment; filename=$filename");
ob_end_flush();
}
else
{
	include(MOD_ROOT.'/include/global.inc.php');
	include template('message','export');
}
?>