<?php
/**
* 会员作品集
* @version phpcms 3.0.0 build 20060424
* @package phpcms
* @subpackage class
* @link http://dev.phpcms.cn phpcms模块开发网站
* @license http://www.phpcms.cn/license.html phpcms版权声明
* @copyright (C) 2005 - 2006 Phpcms Group
*/
defined('IN_PHPCMS') or exit(FORBIDDEN);

$pagesize = $_PHPCMS['pagesize'] ? $_PHPCMS['pagesize'] : 20;
$titlelen = 40;//标题截取长度

if(!$page)
{
	$page=1;
	$offset=0;
}
else
{
	$offset=($page-1)*$pagesize;
}

if(!empty($keywords))
{
	$keyword=str_replace(' ','%',$keywords);
	$keyword=str_replace('*','%',$keyword);
	switch($srchtype)
	{
	case '0':
			$addquery=" AND (title LIKE '%$keyword%' or titleintact LIKE '%$keyword%' or subheading LIKE '%$keyword%') ";
	break;
	case '1':
			$addquery=" AND content LIKE '%$keyword%' ";
	break;
	case '2':
			$addquery=" AND author LIKE '%$keyword%' ";
	break;
	case '3':
			$addquery=" AND username LIKE '%$keyword%' ";
	break;
	default :
			$addquery=" AND (title LIKE '%$keyword%' or titleintact LIKE '%$keyword%' or subheading LIKE '%$keyword%') ";
	}
}
if($catid)
{
	$arrchildid=$_CAT[$catid][child] ? $_CAT[$catid][arrchildid] : $catid;
	$addquery.=" AND catid IN($arrchildid) ";
}
$addquery .= $elite ? " AND elite=1 " : "";
$addquery .= $ontop ? " AND ontop=1 " : "";
switch($ordertype)
{
	case 1:
		$dordertype=" downid DESC ";
	break;
	case 2:
		$dordertype=" downid ";
	break;
	case 3:
		$dordertype=" hits DESC ";
	break;
	case 4:
		$dordertype=" hits ";
	break;
	default :
		$dordertype=" downid DESC ";
}

$cha['channelurl'] = changeurl("channelid",$channelid);
$cha['channelname'] = $_CHA['channelname'];

$r = $db->get_one("SELECT COUNT(*) as number FROM ".TABLE_DOWN." WHERE status=3 AND username='$username' AND recycle=0 AND channelid='$channelid' $addquery ");
$number = $r["number"];
$cha['itemnumber'] = $number;

$pages=phppages($number,$page,$pagesize);

$result=$db->query("SELECT downid,channelid,catid,title,includepic,titlefontcolor,titlefonttype,hits,username,addtime,editor,edittime,ontop,elite,stars FROM ".TABLE_DOWN." WHERE status=3 AND username='$username' AND recycle=0 AND channelid=$channelid $addquery ORDER BY $dordertype LIMIT $offset,$pagesize ");
if($db->num_rows($result)>0)
{
	while($r=$db->fetch_array($result))
	{
		$p->set_catid($r[catid]);
		$r[itemurl] = $p->get_itemurl($r[downid],$r[addtime]);
		$r[catdir] = $p->get_caturl();
		$titlelen = $r[includepic] ? $titlelen-6 : $titlelen;
		$r[title] = wordscut($r[title],$titlelen,1);
		$r[title] = titleformat($r[title],$r[titlefontcolor],$r[titlefonttype],$r[includepic]);
		$r[adddate]=date("Y-m-d",$r[addtime]);
		$items[]=$r;
	}
}

$channelid = 0;

include template('down','member');
?>