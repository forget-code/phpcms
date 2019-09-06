<?php
require './include/common.inc.php';
if(!$cid) showmessage($LANG['illegal_operation']);
$cid = intval($cid);
if(!$MOD['issupportagainst'] && !$_userid) 
{
	echo "<script language=\"javascript\">alert(\"".$LANG['guest_cannot_support_against']."\");</script>";
	exit;
}
$floweregg = getcookie("floweregg");
$flowereggarray = array();
if($floweregg)
{
	$flowereggarray = explode(',',$floweregg);
}
$flowereggarray = array_unique($flowereggarray);
$flowereggarray = array_filter($flowereggarray);
$floweregg = implode(',',$flowereggarray);
$field = $obj=='flower' ? 'support' : 'against';
if(!in_array($cid,$flowereggarray))
{
	mkcookie('floweregg',$floweregg.','.$cid);
	if($obj!='flower' && $obj!='egg') showmessage($LANG['illegal_operation']);
	if($obj=='flower')
	{
		$condition = " support = support+1 ";
		$message = $LANG['success_support'];
	}
	else if($obj=='egg') 
	{
		$condition = " against = against+1 ";
		$message = $LANG['success_against'];
	}
	$db->query("UPDATE ".TABLE_COMMENT." SET $condition WHERE cid=$cid");
}
else
{
	$message = $LANG['have_commentted'];
}
$r = $db->get_one("SELECT  $field  FROM ".TABLE_COMMENT." WHERE cid=$cid");
echo $r[$field];
?>
<script language="javascript">
alert('<?=$message?>');
</script>