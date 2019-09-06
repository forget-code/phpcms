<?php
/**
* 文章发布函数
* @version phpcms 3.0.0 build 20060424
* @package phpcms
* @subpackage class
* @link http://dev.phpcms.cn phpcms模块开发网站
* @license http://www.phpcms.cn/license.html phpcms版权声明
* @copyright (C) 2005 - 2006 Phpcms Group
*/
defined('IN_PHPCMS') or exit(FORBIDDEN);

function article_add($channelid,$catid,$specialid,$title,$content,$thumb='',$author='',$copyfromname='',$addtime=0,$ontop=0,$elite=0,$stars=0,$status=3,$readpoint=0,$groupview='',$paginationtype=0,$maxcharperpage=10000,$templateid=0,$skinid=0)
{
	global $db,$titleintact,$subheading,$includepic,$titlefontcolor,$titlefonttype,$showcommentlink,$description,$keywords,$copyfromurl,$savepathfilename,$uselinkurl,$linkurl,$_username,$_grade,$_CAT,$timestamp,$addtime;

	if(!$channelid)	return false;
	if(!$catid)	return false;
	if(!$_CAT[$catid]['enableadd'])	return false;
	if(empty($title)) return false;
	if($uselinkurl!=1 && empty($content)) return false;

	$groupview = is_array($groupview) ? implode(',',$groupview) : $groupview;
	$addtime = preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/i', $addtime) ? strtotime($addtime.' '.date('H:i:s',$timestamp)) : $timestamp;
	$db->query("INSERT INTO ".TABLE_ARTICLE."(channelid,catid,specialid,title,titleintact,subheading,includepic,titlefontcolor,titlefonttype,showcommentlink,description,keywords,author,copyfromname,copyfromurl,content,paginationtype,maxcharperpage,thumb,savepathfilename,ontop,elite,stars,status,linkurl,readpoint,groupview,username,addtime,editor,edittime,checker,checktime,templateid,skinid) VALUES('$channelid','$catid','$specialid','$title','$titleintact','$subheading','$includepic','$titlefontcolor','$titlefonttype','$showcommentlink','$description','$keywords','$author','$copyfromname','$copyfromurl','$content','$paginationtype','$maxcharperpage','$thumb','$savepathfilename','$ontop','$elite','$stars','$status','$linkurl','$readpoint','$groupview','$_username','$timestamp','$_username','$addtime','$_username','$addtime','$templateid','$skinid')");
	return $db->insert_id();
}
?>