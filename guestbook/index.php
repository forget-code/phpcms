<?php
require_once './include/common.inc.php';
if(!$MOD['show']) showmessage($LANG['message_disable'],'goback');
$pagesize = $MOD['pagesize'];
$gid = isset($gid) ? intval($gid) : 0;
$keyid = isset($keyid) ? $keyid : 'phpcms';
$srchtype = isset($srchtype) ? $srchtype : 0;
$keyword = isset($keyword) ? $keyword : '';
$position = $keyid ? $LANG['guestbook'] : $LANG['DomainGuestbook'];
if(is_numeric($keyid) && $keyid)
{
	$channelid = $keyid;
	$CHA = cache_read('channel_'.$channelid.'.php');
	$channelurl = $CHA['channeldomain'];
}
if(!isset($page))
{
	$page=1;
	$offset=0;
}
else
{
	$offset=($page-1)*$pagesize;
}
$addquery = '';
if(isset($keywords))
{
	$keyword = str_replace(' ','%',$keywords);
	$keyword = str_replace('*','%',$keywords);
	switch($srchtype)
	{
	case '0':
		$addquery=" AND title LIKE '%$keyword%' ";
		break;
	case '1':
		$addquery=" AND content LIKE '%$keyword%' ";
		break;
	case '2':
		$addquery=" AND username LIKE '%$keyword%' ";
		break;
	default :
		$addquery=" AND title LIKE '%$keyword%' ";
	}
}
if($keyid && $keyid != 'phpcms')
$addquery .= " AND keyid='$keyid' ";
$addquery .= $gid ? " AND gid='$gid' " : "";
$addquery .= $_userid ? " OR (hidden=1 AND username='$_username') " : "";
if(!$gid)
{
	$r = $db->get_one("SELECT COUNT(*) AS num FROM ".TABLE_GUESTBOOK." WHERE passed=1 AND hidden=0 $addquery");
	$number=$r["num"];
}
$pages = !$gid ? phppages($number,$page,$pagesize) : 0;
$gbooks = array();
$result = $db->query("SELECT * FROM ".TABLE_GUESTBOOK." WHERE passed=1 AND hidden=0 $addquery ORDER BY gid DESC LIMIT $offset,$pagesize");
while($r = $db->fetch_array($result))
{
	//$r['content'] = reword($r['content']);
	$r['content'] = $r['content'];
	$r['head'] = $r['head']<10 ? "0".$r['head'] : $r['head'];
	$r['addtime'] = date("Y-m-d H:i:s",$r['addtime']);
	$r['replytime'] = date("Y-m-d H:i:s",$r['replytime']);
	$r['gender'] = $r['gender'] ? $LANG['male']: $LANG['female'];
	$gbooks[]=$r;
}
	$head['title'] = $LANG['message_head_title'];
	$head['keywords'] = $LANG['message_head_keywords'];
	$head['description'] = $LANG['message_head_description'];

include template('guestbook','index');
?>