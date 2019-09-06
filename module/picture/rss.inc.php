<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
if(!$MOD['enable_rss'] || $MOD['rss_num']<1) showmessage($LANG['rss_banned']);
$catid = isset($catid) ? intval($catid) : 0;
$num = $MOD['rss_num'] ? $MOD['rss_num'] : 50;
$sql = '';
if($catid)
{
	if($CATEGORY[$catid]['arrchildid'])
	{
		$arrchildid = $CATEGORY[$catid]['arrchildid'];
		$sql .= " AND catid IN($arrchildid) ";
	}
	else
	{
		$sql .= " AND catid=$catid ";
	}
}
$title = $description = $catid ? $CATEGORY[$catid]['catname'] : $CHA['channelname'];
$link = $catid ? linkurl($CATEGORY[$catid]['linkurl'], 1)  : linkurl($CHA['linkurl'], 1);

$pictures = array();

$query = "select pictureid,title,addtime,introduce,linkurl,catid,author,username from ".channel_table('picture', $channelid)." where status=3 $sql order by pictureid desc limit 0,$num";
$result = $db->query($query);
while($r = $db->fetch_array($result))
{
	$r['adddate'] = date('Y-m-d H:i:s', $r['addtime']);
	$r['linkurl'] = linkurl($r['linkurl'], 1);
	$r['introduce'] = strip_tags($r['introduce']);
	if($MOD['rss_length']) $r['introduce'] = str_cut($r['introduce'], $MOD['rss_length'], '...');
	$r['author'] = $r['author'] ? $r['author'] : $r['username'];
	$r['catname'] = $CATEGORY[$r['catid']]['catname'];
	$r['caturl'] = linkurl($CATEGORY[$r['catid']]['linkurl'], 1);
	$pictures[] = $r;
}
header("Content-type:application/xml");
print('<?xml version="1.0" encoding="'.$CONFIG['charset'].'"?>');
?>

<rss version="2.0">
<channel>
<title><?php echo $title;?></title>
<link><?php echo $link;?></link>
<description><?php echo $description;?></description>

<?php
foreach($pictures as $picture)
{
?>
<item id="<?php echo $picture['pictureid'];?>">
<title><![CDATA[<?php echo $picture['title'];?>]]></title>
<link><![CDATA[<?php echo $picture['linkurl'];?>]]></link>
<description><![CDATA[<?php echo $picture['introduce'];?>]]></description>
<author><![CDATA[<?php echo $picture['author'];?>]]></author>
<?php if(!$catid) { ?>
<categoryname><![CDATA[<?php echo $picture['catname'];?>]]></categoryname>
<categorylink><![CDATA[<?php echo $picture['caturl'];?>]]></categorylink>
<?php } ?>
<pubDate><?php echo $picture['adddate'];?></pubDate>
</item>
<?php } ?>

</channel>
</rss>