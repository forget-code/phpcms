<?php
require './include/common.inc.php';

if(!$_userid) showmessage($LANG['please_login_or_register'] , $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));

$placeid = intval($placeid);

$query ="SELECT max(todate) as todate,p.* ".
      "FROM ".TABLE_ADS." as a right join ".TABLE_ADS_PLACE." as p on (a.placeid=p.placeid) ".
      "where p.placeid=".$placeid." and p.passed=1 GROUP BY p.placeid";

$result = $db->get_one($query);
if (empty($result)) 
{
  showmessage($LANG['opration_failure_or_advertisement _not_exists']);
}
$place = $result;

$fromdate = ($place['todate'] && $PHP_TIME < $place['todate']) ? date('Y-m-d', $place['todate']) : date('Y-m-d');
$_month = "<SELECT NAME='ads[longtime]'>";		
for ($i=1;$i<=12;$i++)
{
  $_month .= "<option value='$i'>$i {$LANG['month']}</option>";
}
$_month .= "</SELECT>";

include template($mod, 'sign');
?>