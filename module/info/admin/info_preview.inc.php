<?php
defined('IN_PHPCMS') or exit('Access Denied');
$infoid = intval($infoid);
$infoid or showmessage($LANG['info_id_not_null'],$referer);
@extract($inf->get_one());
$adddate = date('Y-m-d', $addtime);
$enddate = $endtime ? date('Y-m-d', $endtime) : $LANG['no_limit'];
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