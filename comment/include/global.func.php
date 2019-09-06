<?php
function stars($n = 0, $str = '')
{
	if($n == 0) return $LANG['not'];
	$stars = '';
	if($str!='')
	{		
		for($i = 0; $i < $n; $i++) $stars .= $str;
	}
	else
	{
		for($i = 0; $i < $n; $i++)
		$stars.= '<img src="'.PHPCMS_PATH.'images/comment/star.gif" alt="'.$LANG['star'].'" />';
	}
	return $stars;
}

function smilecallback($matches)
{
	global $SMILIES;
	if($matches)
	{
		$fname = substr($matches[0],1,-1);
		if(array_key_exists('comment/smilies/'.$fname.'.gif',$SMILIES))
		{
			return "<img src='".PHPCMS_PATH."comment/smilies/".$fname.".gif' border='0' />";
		}
		else return $LANG['not_exist_smile'];

	}
	else return '';
}

function update_comments($keyid, $itemid, $operation = 1)
{
	global $db, $CONFIG, $CHANNEL;
    $itemid = intval($itemid);
	if(is_numeric($keyid))
	{
		$channelid = intval($keyid);
		$module = $CHANNEL[$keyid]['module'];
		$tablename = channel_table($module, $channelid);
		$tableid = $module.'id';
	}
	else
	{
		$tablename = $CONFIG['tablepre'].$keyid;
		$tableid = $keyid == 'member' ? 'userid' : $keyid.'id';
	}
	if($operation == 1)
	{
		$db->query("UPDATE $tablename SET comments=comments+1 where $tableid=$itemid");
	}
	else
	{
		$db->query("UPDATE $tablename SET comments=comments-1 where $tableid=$itemid");
	}
	return $db->affected_rows();
}
?>