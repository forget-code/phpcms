<?php
defined('IN_PHPCMS') or exit('Access Denied');

if (is_numeric($placeid))
{
  $db->query("delete from ".TABLE_ADS." where placeid=".$placeid);
  $db->query("delete from ".TABLE_ADS_PLACE." where placeid=".$placeid." limit 1");
} elseif (is_array($placeid))
{
  $placeids = implode(",", $placeid);
  $db->query("delete from ".TABLE_ADS." where placeid in ($placeids)");
  $db->query("delete from ".TABLE_ADS_PLACE." where placeid in ($placeids)");
}

if ($db->affected_rows() >0) 
{
  showmessage($LANG['opration_completed'], $referer);
}
else 
{
  showmessage($LANG['opration_completed'] . ' ' . $LANG['no_record'], $referer);
}

showmessage($LANG['incorrect_parameters']);

?>