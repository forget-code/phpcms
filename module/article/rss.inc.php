<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
if(!$MOD['enable_rss'] || $MOD['rss_num']<1) showmessage($LANG['rss_unable_here']);
$catid = isset($catid) ? intval($catid) : 0;
$num = $MOD['rss_num'] ? $MOD['rss_num'] : 50;
$sql = '';
if($catid)
{
	if($CATEGORY[$catid]['arrchildid'])
	{
		$arrchildid = $CATEGORY[$catid]['arrchildid'];
		$sql .= $MOD['rss_mode'] ? " AND a.catid IN($arrchildid) " : " AND catid IN($arrchildid) ";
	}
	else
	{
		$sql .= $MOD['rss_mode'] ? " AND a.catid=$catid " : " AND catid=$catid ";
	}
}

$title = $description = $catid ? $CATEGORY[$catid]['catname'] : $CHA['channelname'];
$link = $catid ? linkurl($CATEGORY[$catid]['linkurl'], 1)  : linkurl($CHA['linkurl'], 1);
$articles = array();

$query = $MOD['rss_mode'] ? "select a.articleid,a.title,a.addtime,a.introduce,a.linkurl,a.catid,a.author,a.username,d.content from ".channel_table('article', $channelid)." a, ".channel_table('article_data', $channelid)." d where a.articleid=d.articleid and a.status=3 $sql order by a.articleid desc limit 0,$num" : "select articleid,title,addtime,introduce,linkurl,catid,author,username from ".channel_table('article', $channelid)." where status=3 $sql order by articleid desc limit 0,$num";
$result = $db->query($query);
while($r = $db->fetch_array($result))
{
	$r['adddate'] = date('Y-m-d H:i:s', $r['addtime']);
	$r['linkurl'] = linkurl($r['linkurl'], 1);
	$r['introduce'] = $MOD['rss_mode'] ? strip_tags($r['content']) : strip_tags($r['introduce']);
	if($MOD['rss_length']) $r['introduce'] = str_cut($r['introduce'], $MOD['rss_length'], '...');
	$r['author'] = $r['author'] ? $r['author'] : $r['username'];
	$r['catname'] = $CATEGORY[$r['catid']]['catname'];
	$r['caturl'] = linkurl($CATEGORY[$r['catid']]['linkurl'], 1);
	$articles[] = $r;
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
foreach($articles as $article)
{
?>
<item id="<?php echo $article['articleid'];?>">
<title><![CDATA[<?php echo $article['title'];?>]]></title>
<link><![CDATA[<?php echo $article['linkurl'];?>]]></link>
<description><![CDATA[<?php echo $article['introduce'];?>]]></description>
<author><![CDATA[<?php echo $article['author'];?>]]></author>
<?php if(!$catid) { ?>
<categoryname><![CDATA[<?php echo $article['catname'];?>]]></categoryname>
<categorylink><![CDATA[<?php echo $article['caturl'];?>]]></categorylink>
<?php } ?>
<pubDate><?php echo $article['adddate'];?></pubDate>
</item>
<?php } ?>

</channel>
</rss>