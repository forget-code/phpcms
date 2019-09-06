<?php
defined('IN_PHPCMS') or exit('Access Denied');

$page = is_numeric($page) ? $page : 1;
$offset=($page-1)*$PHPCMS['pagesize'];
$result=$db->query("SELECT count(*) as num FROM ".TABLE_ADS_PLACE);
$r=$db->fetch_array($result);
$number=$r['num'];
$pages = phppages($number,$page,$PHPCMS['pagesize']);
$query ="SELECT *  ".
		"FROM ".TABLE_ADS_PLACE." as p ".
    "order by placeid ".
    "limit $offset,$PHPCMS[pagesize] ";

$result=$db->query($query);
while($r=$db->fetch_array($result))
{
	$places[]=$r;
}

// 取得各广告位 广告信息情况
foreach ($places as $key=>$place) {
  $placeid = $place['placeid'];
  
  $query ="SELECT count(*) as users,max(todate),a.* ".
      "FROM ".TABLE_ADS." as a left join ".TABLE_ADS_PLACE." as p on (a.placeid=p.placeid) ".
      "where a.placeid=".$placeid." and a.todate>UNIX_TIMESTAMP() and p.passed=1 and a.passed=1 GROUP BY p.placeid";
  $ads = $db->get_one($query);
  if (empty($ads)) 
  {
    $ads['todate'] = "-";
    $ads['users'] = "-";
    $places[$key]['status'] = "<font color='red'>".$LANG['o_sign']."</font>";
    $places[$key]['bgcolor'] = "#FFCC00";
  }
  else
  {
    $ads['todate'] = date("Y-m-d",$ads['todate']);
    $places[$key]['status'] = $LANG['right_sign'];
    $places[$key]['bgcolor'] = "#efefef";
  }
  $places[$key]['ads'] = $ads;
}

$referer = urlencode($referer);
include admintpl('adsplace_manage');

?>