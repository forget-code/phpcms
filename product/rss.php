<?php 
require './include/common.inc.php';

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
$title = $description = $catid ? $CATEGORY[$catid]['catname'] : $mod;
$link = $catid ? linkurl($CATEGORY[$catid]['linkurl'],1) : linkurl($MOD['linkurl'],1);
$products = array();

$query = "select productid,pdt_name,addtime,pdt_description,introduce,linkurl,catid from ".TABLE_PRODUCT." where disabled=0 $sql order by productid desc limit 0,$num";
$result = $db->query($query);
while($r = $db->fetch_array($result))
{
	$r['adddate'] = date('Y-m-d H:i:s', $r['addtime']);
	$r['linkurl'] = linkurl($r['linkurl'], 1);
	$r['introduce'] = $MOD['rss_mode'] ? strip_tags($r['introduce']) : strip_tags($r['pdt_description']);
	if($MOD['rss_length']) $r['introduce'] = str_cut($r['introduce'], $MOD['rss_length'], '...');
	$r['catname'] = $CATEGORY[$r['catid']]['catname'];
	$r['caturl'] = linkurl($CATEGORY[$r['catid']]['linkurl'], 1);
	$products[] = $r;
}
header("Content-type:application/xml");
print('<?xml version="1.0" encoding="'.$CONFIG['charset'].'"?>');
?>

<rss version="2.0">
<product>
<title><?php echo $title;?></title>
<link><?php echo $link;?></link>
<description><?php echo $description;?></description>

<?php
foreach($products as $product)
{
?>
<item id="<?php echo $product['productid'];?>">
<title><![CDATA[<?php echo $product['pdt_name'];?>]]></title>
<link><![CDATA[<?php echo $product['linkurl'];?>]]></link>
<description><![CDATA[<?php echo $product['introduce'];?>]]></description>
<?php if(!$catid) { ?>
<categoryname><![CDATA[<?php echo $product['catname'];?>]]></categoryname>
<categorylink><![CDATA[<?php echo $product['caturl'];?>]]></categorylink>
<?php } ?>
<pubDate><?php echo $product['adddate'];?></pubDate>
</item>
<?php } ?>

</product>
</rss>