<?php
defined('IN_PHPCMS') or exit('Access Denied');

if($dosubmit)
{
	$targetcatid = isset($targetcatid) ? intval($targetcatid) : 0;
	$targetcatid or showmessage($LANG['distinct_category_not_null'],'goback');
	$CAT = cache_read("category_$targetcatid.php");
	if($CAT['child'] && !$CAT['enableadd']) showmessage($LANG['not_allowed_to_add_in_this_category'],'goback');

	if($movetype==1)
	{
		!empty($productids) or showmessage($LANG['illegal_parameters'],'goback');
		$productids=is_array($productids) ? implode(',',$productids) : $productids;
		if($targetcatid) $db->query("UPDATE ".TABLE_PRODUCT." SET catid='$targetcatid' WHERE productid IN ($productids) ");
	}
	else
	{
		!empty($batchcatid) or showmessage($LANG['source_category_not_null'],'goback');
		$batchcatids = is_array($batchcatid) ? implode(",",$batchcatid) : $batchcatid;
		if($targetcatid) $db->query("UPDATE ".TABLE_PRODUCT." SET catid='$targetcatid' WHERE catid IN ($batchcatids) ");
	}
	showmessage($LANG['move_success'],$referer);
}
else
{
	$referer = isset($referer) ? $referer : "?mod=$mod&file=$file&action=move";
	$productids = (isset($productids) ? $productids : '') ;
	$productids = is_array($productids) ? implode(',',$productids) : $productids;
	$category_select = str_replace("<select name='catid' ><option value='0'></option>",'',category_select('catid'));
	include admintpl('product_move');
}
?>