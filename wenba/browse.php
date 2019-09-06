<?php 
require_once './include/common.inc.php';

$catid = isset($catid) ? intval($catid) : 0;
$CATEGORY = cache_read('categorys_'.$mod.'.php');
$questions = array('all'=>'全部问题','solve'=>'已解决问题','nosolve'=>'待解决问题','vote'=>'投票中的问题','highscore'=>'高分问题');
if(!isset($option) || !isset($questions[$option])) $option = 'all';
$ques = $questions[$option];
if($catid)
{
	$CAT = cache_read('category_'.$catid.'.php');
	@extract($CAT);
	if($child==1)	$arrchild = subcat($mod, $catid);
	$position = catpos($catid);
}
else
{
	$linkurl = $MOD['linkurl'].'browse.php?all';
}
include template('wenba','browse');
?>