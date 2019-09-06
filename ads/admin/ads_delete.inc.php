<?php
defined('IN_PHPCMS') or exit('Access Denied');

if (is_numeric($adsid))
{
  $db->query("delete from ".TABLE_ADS." where adsid=".$adsid);
} elseif (is_array($adsid))
{
  $adsids = implode(",", $adsid);
  $db->query("delete from ".TABLE_ADS." where adsid in ($adsids)");
}

if ($db->affected_rows() >0) 
{
  showmessage($LANG['opration_completed'], $referer);
}
else 
{
  showmessage($LANG['opration_completed'].' '.$LANG['no_record'], $referer);
}

showmessage($LANG['incorrect_parameters']);

?>