<?php 
defined('IN_PHPCMS') or exit('Access Denied');

if($dosubmit)
{
	if(!isset($name)) $name = array();
	foreach($name as $id=>$v)
	{
		if(isset($delete[$id]) && $delete[$id])
		{
			$db->query("DELETE FROM ".TABLE_POSITION." WHERE posid=$id");
		}
		else
		{
			$keyid = 'keyid'.$id;
			$keyid = $$keyid;
			$db->query("UPDATE ".TABLE_POSITION." SET name='$name[$id]',listorder='$listorder[$id]',keyid='$keyid' WHERE posid=$id");
		}
	}
	if($newname)
	{
		$db->query("INSERT INTO ".TABLE_POSITION."(name,listorder,keyid) VALUES('$newname','$newlistorder','$newkeyid')");
		$posid = $db->insert_id();
		$posfile = '';
		if(is_numeric($newkeyid))
		{
			$channelid = intval($newkeyid);
			$posfile = PHPCMS_ROOT.'/'.$CHANNEL[$channelid]['channeldir'].'/pos/'.$posid.'.txt';
		}
		elseif($newkeyid)
		{
			$posfile = PHPCMS_ROOT.'/'.$MODULE[$newkeyid]['moduledir'].'/pos/'.$posid.'.txt';
		}
		if($posfile) file_put_contents($posfile, '');
	}
	showmessage($LANG['operation_success'], $forward);
}
else
{
	$keyid = isset($keyid) ? $keyid : 0;
	$sql = $keyid ? " WHERE keyid='$keyid' " : "";
	$maxposid = 0;
	$poss = array();
	$result = $db->query("SELECT * FROM ".TABLE_POSITION." $sql ORDER BY listorder");
	while($r = $db->fetch_array($result))
	{
		$poss[$r['posid']] = $r;
		$maxposid = max($maxposid, $r['posid']);
	}
	$newlistorder = $maxposid + 1;
	include admintpl('position');
}
?>