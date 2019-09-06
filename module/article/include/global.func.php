<?php 
defined('IN_PHPCMS') or exit('Access Denied');
function articlepage($catid, $ishtml, $urlruleid, $htmldir = '', $prefix = '', $itemid, $addtime, $pagenumber = 1, $page = 1)
{	$pages = '';
	for($i=1; $i<=$pagenumber; $i++)
	{
		$pages .= $page==$i ? '<strong>['.$i.']</strong> ' : '[<a href="'.linkurl(item_url('url', $catid, $ishtml, $urlruleid, $htmldir, $prefix, $itemid, $addtime, $i)).'">'.$i.'</a>] ';        
	}
	$prepageurl = $page<=1 ? linkurl(item_url('url', $catid, $ishtml, $urlruleid, $htmldir, $prefix, $itemid, $addtime, 1)) : linkurl(item_url('url', $catid, $ishtml, $urlruleid, $htmldir, $prefix, $itemid, $addtime, $page-1));
	$nextpageurl = $page>=$pagenumber ? linkurl(item_url('url', $catid, $ishtml, $urlruleid, $htmldir, $prefix, $itemid, $addtime, $pagenumber)) : linkurl(item_url('url', $catid, $ishtml, $urlruleid, $htmldir, $prefix, $itemid, $addtime, $page+1));
	return "<a href=\"".$prepageurl."\"><img src=\"".PHPCMS_PATH."images/page_pre.gif\" align=\"absmiddle\" border=\"0\" /></a> ".$pages." <a href=\"".$nextpageurl."\"><img src=\"".PHPCMS_PATH."images/page_next.gif\" align=\"absmiddle\" border=\"0\" /></a>";
}

function get_substr($string,$start=0,$length='')
{
	$start = (int)$start;
	$length = (int)$length;
	$i = 0;
	if(!$string) return false;
	if($start>=0)
	{
		while($i<$start)
		{
			if(ord($string[$i])>127)
			{
				$i = $i+2;
			}
			else
			{
				$i++;
			}
		}
		$start = $i;
		if($length=='')
		{
			return substr($string,$start);
		}        
		elseif($length>0)
		{
			$end = $start+$length;
			while($i<$end && $i<strlen($string))
			{
				if(ord($string[$i])>127)
				{
					$i = $i+2;
				}
				else
				{
					$i++;
				}
			}
			if($end != $i-1)
			{
				$end = $i;
			}
			else
			{
				$end--;
			}
			$length = $end-$start;
			return substr($string,$start,$length);
		}
		elseif($length==0)
		{
			return;
		}
		else
		{
			$length = strlen($string)-abs($length)-$start;
			return get_substr($string,$start,$length);
		}
	}
	else
	{
		$start = strlen($string)-abs($start);
		return get_substr($string,$start,$length);
	}        
}

function update_article_url($articleid)
{
	global $db, $channelid;
	$articleid = intval($articleid);
	$channelid = intval($channelid);
	if(!$articleid || !$channelid) return FALSE;
	$article = $db->get_one("select * from ".channel_table('article', $channelid)." where articleid=$articleid ");
	if(empty($article))  return FALSE;
	$linkurl = item_url('url', $article['catid'], $article['ishtml'], $article['urlruleid'], $article['htmldir'], $article['prefix'], $articleid, $article['addtime'], 0);
	$db->query("update ".channel_table('article', $channelid)." set linkurl='$linkurl' where articleid=$articleid ");
	return TRUE;
}

?>