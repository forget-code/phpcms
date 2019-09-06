<?php 
function comment_list($templateid, $keyid, $itemid, $page = 0, $commentnum = 10, $ordertype = 1,$title='', $info = 0)
{
	global $db,$SMILIES,$MOD,$_userid;
	$itemid = intval($itemid);
	$page = is_numeric($page) ? intval($page) : 1;
	$offset = $page ? ($page-1)*$commentnum : 0;
	$limit = $commentnum ? " LIMIT $offset,$commentnum " : '';
	if($page && $commentnum)
	{
		$r = $db->get_one("SELECT count(cid) AS number FROM ".TABLE_COMMENT." WHERE keyid='$keyid' AND itemid=$itemid AND passed=1", "CACHE");
		$pages = phppages($r['number'], $page, $commentnum);
	}
	$order = $ordertype ? 'DESC' : '';
	$comments = array();
	$result = $db->query("SELECT * FROM ".TABLE_COMMENT." WHERE keyid='$keyid' AND itemid=$itemid AND passed=1 ORDER BY cid $order $limit", "CACHE");
	while($r = $db->fetch_array($result))
	{
		$r['addtime'] = date('Y-m-d H:i:s', $r['addtime']);
		$r['score'] = stars($r['score']);
		$r['ip'] = substr($r['ip'],0,strrpos($r['ip'],'.')).".*";
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
	$db->free_result($result);
	if(!$templateid) $templateid = 'tag_comment_list';
	include template('comment', $templateid);
}
?>