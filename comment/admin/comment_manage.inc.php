<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once PHPCMS_ROOT."/include/ip.class.php";

$i = 1;
$keyid = isset($keyid)? strval($keyid) : '';
$link = $linkfonta = $linkfontb = '';

foreach($CHANNEL as $channelid=>$cha)
{
	if($cha['islink']) continue;
	$i++;
	$linkfonta = $channelid == $keyid  ? '<font color=#f340cd><strong>' : '';
	$linkfontb = $channelid == $keyid  ? '</strong></font>' : '';
	$link .= "<a href=\"?mod=comment&file=comment&action=manage&keyid=$channelid\" class='pagelink'>".$linkfonta.$cha['channelname'].$linkfontb."</a>";
	if($i%15==0) $link .='<br/>'; else $link .=' | ';
}
foreach($MODULE as $module=>$m)
{
	$i++;
	if($m['iscopy']) continue;
	if($module == 'phpcms') continue;
	$linkfonta = $module == $keyid ? '<font color=#f340cd><strong>' : '';
	$linkfontb = $module == $keyid ? '</strong></font>' : '';
	
	$link .= "<a href=\"?mod=comment&file=comment&action=manage&keyid=$module\" class='pagelink'>".$linkfonta.$m['name'].$linkfontb."</a>";
	if($i%15==0) $link .='<br/>'; else $link .=' | ';
}
	
$srchfrom = isset($srchfrom) ? $srchfrom : 0;
$keywords = isset($keywords) ? $keywords : '';
$itemid = isset($itemid) ? $itemid : '';
$page = isset($page) ? $page : '';
$passed = isset($passed) ? $passed : "1";
$referer = urlencode("?mod=".$mod."&file=comment&action=manage&passed=".$passed."&keyid=".$keyid."&itemid=".$itemid."&page=".$page);
$getip = new ip();
$pagesize = isset($pagesize) ? $pagesize : $PHPCMS['pagesize'];
if(!$page)
{
	$page=1;
	$offset=0;
}
else
{
	$offset=($page-1)*$pagesize;
}
$condition = " AND passed=$passed ";
$condition .= $keywords ? " AND username LIKE '%$keywords%' OR content LIKE '%$keywords%' " : "";
$condition .= $itemid ? " AND itemid='$itemid' " : "";
$condition .= isset($ip) ? " AND ip='$ip' " : "";
$condition .= $keyid ? " AND keyid='$keyid' " : "";
$condition .= $srchfrom ? " AND addtime>$PHP_TIME-$srchfrom*86400 " : "";
$r = $db->get_one("SELECT COUNT(cid) AS num FROM ".TABLE_COMMENT." WHERE 1 $condition");
$number = $r['num'];
$pages = phppages($number,$page,$pagesize);

$comments = array();
$result = $db->query("SELECT * FROM ".TABLE_COMMENT." WHERE 1 $condition ORDER BY cid DESC LIMIT $offset,$pagesize");
while($r = $db->fetch_array($result))
{
	$r['adddate']=date("Y-m-d",$r['addtime']);
	$r['gip']=$getip->getlocation($r['ip']);
	$r['url'] = itemurl($r['keyid'],$r['itemid']);	
	$r['content'] = strip_textarea($r['content']);
	$r['content'] = preg_replace_callback("/\[smile_[0-9]{1,3}\]/",'smilecallback',$r['content']);
	$r['content'] = str_replace('[quote]','<div class="comment_quote">',$r['content']);
	$r['content'] = str_replace('[/quote]','</div>',$r['content']);
	$r['content'] = str_replace('[blue]','<span style="color:blue">',$r['content']);
	$r['content'] = str_replace('[/blue]','<span><br />',$r['content']);
	if(!$MOD['enablekillurl'] && $MOD['enableparseurl']) $r['content'] = preg_replace("/(http:\/\/)?(([A-Za-z0-9_-])+[.]){1,}(net|com|cn|org|cc|tv|[0-9]{1,3})/i",'<a href="\0" target="_blank" >\0</a>',$r['content']);
	if($MOD['enablekillurl']) $r['content'] = preg_replace("/(www\.)([A-Za-z0-9_-]+[.]){1,}(net|com|cn|org|cc|tv|[0-9]{1,3})/i",'\1***.\3',$r['content']);
	$comments[] = $r;
}

include admintpl('comment_manage');
?>