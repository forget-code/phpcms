<?php
defined('IN_PHPCMS') or exit('Access Denied');

$val = ($val==1)?1:0;

if (is_numeric($placeid) && is_numeric($val)) {
  $db->query("update ".TABLE_ADS_PLACE." set passed = $val where placeid=$placeid limit 1");
} elseif (is_array($placeid)) {
  $placeids = implode(",", $placeid);
  $db->query("update ".TABLE_ADS_PLACE." set passed = $val where placeid in ($placeids)");
}

if ($db->affected_rows() >0) {
  showmessage($LANG['opration_completed'], $referer);
} else {
  showmessage($LANG['opration_completed'].$LANG['no_record'], $referer);
}
showmessage($LANG['incorrect_parameters']);

?>