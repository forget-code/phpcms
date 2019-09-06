<?php
defined('IN_PHPCMS') or exit('Access Denied');

if($_grade>1) showmessage($LANG['you_have_no_permission']);

$referer = isset($referer) ? $referer : $PHP_REFERER;
$action = $action ? $action : 'manage';
$type = isset($type) ? intval($type) : 1;
set_time_limit(0);
if($action=='getfields')
{
	$fields = '';
	if(!$tablename) $message=$LANG['illegal_parameters'];
	else 
	{
		$query = "SHOW COLUMNS FROM `$tablename` ";
		$result = $db->query($query);
		while($r = $db->fetch_array($result))
		{
			$fields.= $r['Field'].',';
		}
		$fields = substr($fields,0,-1);
	}
	echo $fields;
	exit;

}
if($dosubmit)
{
		if(empty($fromtable))
		{
			showmessage($LANG['the_datatable_to_replace_cannot_null'],$referer);
		}
		if(empty($fromfield))
		{
			showmessage($LANG['the_field_to_replace_cannot_null'],$referer);
		}
		$query = "SHOW COLUMNS FROM `$fromtable`";
		$result = $db->query($query);
		while($r = $db->fetch_array($result))
		{
			if($r['Key'] == 'PRI')
			{
				$priid = $r['Field'];
				break;
			}
		}
		if(!$priid) showmessage($LANG['no_primary_key_int_this_table'],'goback');
	
		$condition = $condition ? 'where '.stripslashes($condition) : '';
		
		if($type==1) //replace
		{		
			if(empty($search))
			{
				showmessage($LANG['the_content_to_replace_cannot_null'],$referer);
			}
			$query = "select $fromfield,$priid from $fromtable $condition ";
			$result = $db->query($query);
			while($r = $db->fetch_array($result))
			{
				$r[$fromfield] = str_replace($search,$replace,$r[$fromfield]);
				$r[$fromfield] = addslashes($r[$fromfield]);
				$db->query("update $fromtable set $fromfield='".$r[$fromfield]."' where $priid='".$r[$priid]."'");
			}
			showmessage($LANG['replace_success'],$referer);
		}
		elseif($type==2) //ubb
		{
			require PHPCMS_ROOT.'/include/ubb.func.php';		
			$query = "select $fromfield,$priid from $fromtable $condition ";
			$result = $db->query($query);
			while($r = $db->fetch_array($result))
			{
				$r[$fromfield] = ubb($r[$fromfield]);
				$r[$fromfield] = addslashes($r[$fromfield]);
				$db->query("update $fromtable set $fromfield='".$r[$fromfield]."' where $priid='".$r[$priid]."'");
			}
			showmessage($LANG['ubb_replace_success'],$referer);	
		}
		elseif($type==3) // add on front
		{
			if(empty($addstr))
			{
				showmessage($LANG['prefix_of_content_not_null'],$referer);
			}
			$query = "select $fromfield,$priid from $fromtable $condition ";
			$result = $db->query($query);
			while($r = $db->fetch_array($result))
			{
				$r[$fromfield] = $addstr.$r[$fromfield];
				$r[$fromfield] = addslashes($r[$fromfield]);
				$db->query("update $fromtable set $fromfield='".$r[$fromfield]."' where $priid='".$r[$priid]."'");
			}
			showmessage($LANG['replace_success'],$referer);
		}
		elseif($type==4) // add on front
		{
			if(empty($addstr))
			{
				showmessage($LANG['extention_of_content_not_null'],$referer);
			}
			$query = "select $fromfield,$priid from $fromtable $condition ";
			$result = $db->query($query);
			while($r = $db->fetch_array($result))
			{
				$r[$fromfield] = $r[$fromfield].$addstr;
				$r[$fromfield] = addslashes($r[$fromfield]);
				$db->query("update $fromtable set $fromfield='".$r[$fromfield]."' where $priid='".$r[$priid]."'");
			}
			showmessage($LANG['replace_success'],$referer);
		}
}
else
{
	$query = $db->query("SHOW TABLES FROM `".$CONFIG['dbname']."`");
	$tables ='';
	while($r = $db->fetch_row($query))
	{
		$table = $r[0];
		if(preg_match("/^".$CONFIG['tablepre']."/i", $table))
		{
			$tables.= "<option value='$table'>$table</option>";         
		}
	}	
	$referer = urlencode('?mod='.$mod.'&file='.$file.'&action='.$action);
	include admintpl('strreplace','phpcms');
}

?>