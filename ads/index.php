<?php 
require './include/common.inc.php';

$page = isset($page) ? intval($page) : 1;
$offset = ($page-1)*$PHPCMS['pagesize'];
$r = $db->get_one("SELECT count(*) as num FROM ".TABLE_ADS_PLACE);
$pages = phppages($r['num'], $page, $PHPCMS['pagesize']);

$places = array();
$query ="SELECT *  ".
		"FROM ".TABLE_ADS_PLACE." as p ".
    "order by placeid ".
    "limit $offset,$PHPCMS[pagesize] ";
$result = $db->query($query);
while($r = $db->fetch_array($result))
{
	$places[] = $r;
}

foreach ($places as $key=>$place)
{
	$placeid = $place['placeid'];
	$query ="SELECT count(*) as users,max(todate),a.* ".
	  "FROM ".TABLE_ADS." as a left join ".TABLE_ADS_PLACE." as p on (a.placeid=p.placeid) ".
	  "where a.placeid=".$placeid." and a.todate>UNIX_TIMESTAMP() and p.passed=1 and a.passed=1 GROUP BY p.placeid";
	$ads = $db->get_one($query);
	if(empty($ads)) 
	{
		$ads['todate'] = "-";
		$ads['users'] = "-";
		$places[$key]['status'] = "<font color='red'>".$LANG['no_sign']."</font>";
		$places[$key]['bgcolor'] = "#FFCC00";
	}
	else
	{
		$ads['todate'] = date("Y-m-d", $ads['todate']);
		$places[$key]['status'] = $LANG['yes_sign'];
		$places[$key]['bgcolor'] = "#efefef";
	}
	$places[$key]['ads'] = $ads;
}

include template($mod, 'placelists');
?>