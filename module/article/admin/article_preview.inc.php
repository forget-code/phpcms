<?php
defined('IN_PHPCMS') or exit('Access Denied');
$articleid = intval($articleid);
$articleid or showmessage($LANG['empty_article_id'],$referer);
@extract($art->get_one());
$linkurl = linkurl($linkurl);
$adddate=date('Y-m-d H:i:s', $addtime);
$thumb = imgurl($thumb);
$CAT = cache_read('category_'.$catid.'.php');
$catname = $CAT['catname'];
$myfields = cache_read('phpcms_'.$mod.'_'.$channelid.'_fields.php');
$fields = array();
if(is_array($myfields))
{
	foreach($myfields as $k=>$v)
	{
		$myfield = $v['name'];
		$fields[] = array('title'=>$v['title'],'value'=>$$myfield);
	}
}
include admintpl($mod.'_preview');
?>