<?php
defined('IN_PHPCMS') or exit('Access Denied');


// 广告位
$query = "SELECT placeid,placename FROM ".TABLE_ADS_PLACE." ORDER BY placeid ";
$result = $db->query($query);
unset($properties);
while($r = $db->fetch_array($result))
{
	$adsplaces[$r['placeid']] = $r;
}

// 广告位过期及开放选择
$ads_expired = empty($ads_expired)?0:1;
$ads_noexpired_checked = ($ads_expired==0)?" checked":"";
$ads_expired_checked = ($ads_expired==1)?" checked":"";
$ads_expired_select = "<INPUT TYPE='radio' NAME='ads_expired' value='0'{$ads_noexpired_checked} onclick='location.href=\"?mod=".$mod."&file=".$file."&action=manage&adsplaceid=".$adsplaceid."&ads_expired=0\"'>".$LANG['selling_ads'];
$ads_expired_select .= "<INPUT TYPE='radio' NAME='ads_expired' value='1'{$ads_expired_checked} onclick='location.href=\"?mod=".$mod."&file=".$file."&action=manage&adsplaceid=".$adsplaceid."&ads_expired=1\"'>".$LANG['timeout_ads'];

// 广告位选择
$adsplaces_select = "<select onchange='location.href=\"?mod=".$mod."&file=".$file."&action=manage&ads_expired=".$ads_expired."&adsplaceid=\"+this.value'><option value='0'>".$LANG['all_advertisement']."</option>";
foreach ($adsplaces as $place) {
  $checked = ($place['placeid']==$adsplaceid)?" selected":"";
  $adsplaces_select .= "<option value='{$place['placeid']}'{$checked}>{$place['placename']}</option>";
}
$adsplaces_select .= "</select>";

$page = (isset($page))?$page:1;
$page = is_numeric($page) ? $page : 1;
$offset=($page-1)*$PHPCMS['pagesize'];
$adsplacewhere = $adsplaceid?" and a.placeid={$adsplaceid}":"";
$adsplacewhere .= $ads_expired?" and a.todate<UNIX_TIMESTAMP()":" and a.todate>=UNIX_TIMESTAMP()";

$result=$db->query("SELECT count(*) as num FROM ".TABLE_ADS." as a left join ".TABLE_ADS_PLACE." as p on (a.placeid=p.placeid) where 1=1 and p.passed=1 {$adsplacewhere}");
$r=$db->fetch_array($result);
$number=$r['num'];
$pages = phppages($number,$page,$PHPCMS['pagesize'],"?mod=".$mod."&file=".$file."&action=manage&adsplaceid=".$adsplaceid."&ads_expired=".$ads_expired);
$query ="SELECT a.*,p.placename as placename,if(a.todate<UNIX_TIMESTAMP(),1,0) as passdate ".
		"FROM ".TABLE_ADS." as a left join ".TABLE_ADS_PLACE." as p on (a.placeid=p.placeid)".
    "where 1=1 and p.passed=1 {$adsplacewhere} ".
    "order by a.addtime desc ".
    "limit $offset,{$PHPCMS['pagesize']}";

$result=$db->query($query);
unset($properties);
while($r=$db->fetch_array($result))
{
  $r['status'] = ($r['passed'])?"<b style='color:green'>".$LANG['normal']."</b>":"<b style='color:red'>".$LANG['locked']."</b>";
  $r['status'] = ($r['passdate'])?"<b style='color:#FF9900'>".$LANG['timeout']."</b>":$r['status'];
  $r['checked'] = ($r['checked']==1)?"<b style='color:#33CC00'>".$LANG['passed']."</b>":"<b style='color:#FF9900'>".$LANG['checking']."</b>";
	$adssigns[]=$r;
}
$adssigns = isset($adssigns)?$adssigns:"";

$referer = urlencode($referer);
include admintpl('ads_manage');

?>