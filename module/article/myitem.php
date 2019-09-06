<?php
/*
*####################################################
* PHPCMS v3.0.0 - Advanced Content Manage System.
* Copyright (c) 2005-2006 phpcms.cn
*
* For further information go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*####################################################
*/
defined('IN_PHPCMS') or exit('Access Denied');

require_once PHPCMS_ROOT."/include/admin_functions.php";

$articleid = intval($articleid);
$catid = intval($catid);
$specialid = intval($specialid);

$pagesize = $_PHPCMS['pagesize'] ? $_PHPCMS['pagesize'] : 20;
$titlelen = 50;  //标题截取长度
$referer=$referer ? $referer : $PHP_REFERER;

$action=$action ? $action : 'manage';

switch($action){

case 'add':

    if(!$_CHA['enablecontribute']) message("本频道不允许投稿！","goback");

	if($submit)
	{
		if(!$catid)	message('对不起，请选择所属栏目！请返回！');
		if(!check_purview($_CAT[$catid]['arrgroupid_add'])) message("您没有当前栏目的投稿权限！","goback");
		if($_CAT[$catid][child] && !$_CAT[$catid][enableadd]) message('指定栏目不允许添加文章！请返回！');
		if(empty($title)) message('对不起，简短标题不能为空！请返回！');
		if(empty($content))	message('对不起，文章内容不能为空！请返回！');

		$inputstring=dhtmlspecialchars(array('title'=>$title,'keywords'=>$keywords,'author'=>$author,'copyfromname'=>$copyfromname,'copyfromurl'=>$copyfromurl,'description'=>$description,'thumb'=>$thumb));
		extract($inputstring,EXTR_OVERWRITE);
		$content = str_safe($content);

		if($_CHA['enablecheck'] && !$_GROUP['enableaddalways'] && $_grade>2) $status = $status > 2 ? 1 : $status ;

		$db->query("INSERT INTO ".TABLE_ARTICLE."(channelid,catid,specialid,title,description,author,copyfromname,copyfromurl,content,thumb,savepathfilename,status,username,addtime,editor,edittime) VALUES('$channelid','$catid','$specialid','$title','$description','$author','$copyfromname','$copyfromurl','$content','$thumb','$savepathfilename','$status','$_username','$timestamp','$_username','$addtime')");
		$articleid = $db->insert_id();
		field_update($channelid,"articleid=$articleid");
		if($status==3)
		{
            credit_add($_username,$_CAT[$catid]['creditget']);
			if($_CHA['htmlcreatetype']) 
			{
				include_once PHPCMS_ROOT."/include/cmd.php";
				cmd_send(PHPCMS_PATH.$_CHA['channeldir']."/cmd.php","article2html",$referer,"articleid=".$articleid."&enablemessage=1");
			}
		}
		message('操作成功！',$referer);
	}
	else
	{
		$tree=new tree;
        $cat_select = cat_select('catid','请选择栏目',$catid);
		$special_select = special_select($channelid,'specialid','不属于任何专题',$specialid);
		$today = date('Y-m-d');
		$author = $_username;
		$fields = field_input($channelid,"tablerow");
		$disabled = (($_isadmin && $_grade==0) || $_GROUP['enableaddalways']==1) ? 0 : 1;
        $status = $disabled ? 0 : 3;
	}
break;

case 'edit':

    if($submit)
	{
		if(empty($articleid))
		{
			message('非法参数！请返回！');
		}
		if(!$catid)
		{
			message('对不起，请选择所属栏目！请返回！');
		}
		if($_CAT[$catid][child] && !$_CAT[$catid][enableadd])
		{
			message('指定栏目不允许添加文章！请返回！');
		}
		if(empty($title))
		{
			message('对不起，标题不能为空！请返回！');
		}
		if(empty($content))
		{
			message('对不起，文章内容不能为空！请返回！');
		}
		$inputstring=dhtmlspecialchars(array('title'=>$title,'keywords'=>$keywords,'author'=>$author,'copyfromname'=>$copyfromname,'copyfromurl'=>$copyfromurl,'thumb'=>$thumb));
		extract($inputstring,EXTR_OVERWRITE);
		$content = str_safe($content);

        $status = intval($status);
		if($_CHA['enablecheck'] && !$_GROUP['enableaddalways']) $status = $status > 2 ? 1 : $status ;

		$db->query("UPDATE ".TABLE_ARTICLE." SET catid='$catid',specialid='$specialid',title='$title',description='$description',keywords='$keywords',author='$author',copyfromname='$copyfromname',copyfromurl='$copyfromurl',content='$content',thumb='$thumb',savepathfilename='$savepathfilename',status='$status',editor='$_username',edittime='$timestamp' WHERE articleid='$articleid' AND channelid='$channelid' AND username='$_username' AND status!=3 ");
		field_update($channelid,"articleid=$articleid");
		if($status==3)
		{
			if($_CHA['htmlcreatetype']) 
			{
				include_once PHPCMS_ROOT."/include/cmd.php";
				cmd_send(PHPCMS_PATH.$_CHA['channeldir']."/cmd.php","article2html",$referer,"articleid=".$articleid."&enablemessage=1");
			}
		}
		message('操作成功！',$referer);
	}
	else
	{
		$r=$db->get_one("SELECT * FROM ".TABLE_ARTICLE." WHERE articleid='$articleid' AND channelid='$channelid' and username='$_username' and status!=3");
		if(!$r['articleid']) message("参数错误！");

		@extract(dhtmlspecialchars($r));

		$tree=new tree;
        $cat_select = cat_select('catid','请选择栏目',$catid);
		$special_select = special_select($channelid,'specialid','不属于任何专题',$specialid);
		$fields = field_input($channelid,"tablerow");
		$disabled = (($_isadmin && $_grade==0) || $_GROUP['enableaddalways']==1) ? 0 : 1;
	}
break;


case 'send'://投稿

	if(empty($articleid))
	{
		message('非法参数！请返回！');
	}
	
	$db->query("UPDATE ".TABLE_ARTICLE." SET status=1 WHERE articleid='$articleid' AND username='$_username' AND channelid='$channelid' AND status!=3");
	message('操作成功！',$referer);

break;

case 'preview':
	
	if(!ereg('^[0-9]+$',$articleid))
	{
		message('非法参数！请返回！'); 
	}
	@extract($db->get_one("SELECT * FROM ".TABLE_ARTICLE." WHERE articleid=$articleid AND username='$_username' AND channelid='$channelid' AND status!=3 "));
	$url = $p->get_itemurl($articleid,$addtime);
	$adddate=date('Y-m-d',$addtime);

break;

case 'delete':

	if(empty($articleid))
	{
		message('非法参数！请返回！');
	}

	$articleids=is_array($articleid) ? implode(',',$articleid) : $articleid;

	$db->query("DELETE FROM ".TABLE_ARTICLE." WHERE articleid IN ($articleids) AND username='$_username' AND status!=3 AND channelid='$channelid'");
	if($db->affected_rows()>0)
	{
		message('操作成功！',$referer);
	}
	else
	{
		message('操作失败！请返回！');
	}
break;

case 'manage':
	$tree=new tree;
	$cat_select = cat_select('catid','请选择栏目',$catid);

	$status=isset($status) ? $status : 3;
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
			$dordertype=" articleid DESC ";
		break;
		case 2:
			$dordertype=" articleid ";
		break;
		case 3:
			$dordertype=" hits DESC ";
		break;
		case 4:
			$dordertype=" hits ";
		break;
		default :
			$dordertype=" articleid DESC ";
	}

	$query="SELECT COUNT(*) as num FROM ".TABLE_ARTICLE." WHERE status='$status' AND username='$_username' AND recycle=0 AND channelid='$channelid' $addquery ";
	$result=$db->query($query);
	$r=$db->fetch_array($result);
	$number=$r["num"];
	$url="?module=".$module."&channelid=".$channelid."&action=manage&&status=".$status."catid=".$catid."&srchtype=".$srchtype."&keyword=".$keyword."&ontop=".$ontop."&elite=".$elite."&ordertype=".$ordertype;
	$pages=phppages($number,$page,$pagesize,$url);
	$query="SELECT articleid,channelid,catid,title,includepic,titlefontcolor,titlefonttype,showcommentlink,hits,username,addtime,editor,edittime,checker,checktime,ontop,elite,stars,recycle,status FROM ".TABLE_ARTICLE." WHERE status='$status' AND username='$_username' AND recycle=0 AND channelid='$channelid' $addquery ORDER BY $dordertype LIMIT $offset,$pagesize ";
	$result=$db->query($query);
	if($db->num_rows($result)>0)
	{
		while($r=$db->fetch_array($result))
		{
			$r[url] = $p->get_itemurl($r[articleid],$r[addtime]);
			$p->set_catid($r[catid]);
			$r[catdir] = $p->get_listurl(1);
			$titlelen = $r[includepic] ? $titlelen-6 : $titlelen;
			$r[title] = wordscut($r[title],$titlelen,1);
			$r[title] = titleformat($r[title],$r[titlefontcolor],$r[titlefonttype],$r[includepic]);
			$r[adddate]=date("Y-m-d",$r[addtime]);
			$r[addtime]=date("Y/md",$r[addtime]);
			$articles[]=$r;
		}
	}
break;
}

@extract($db->get_one("SELECT COUNT(*) AS num_3 FROM ".TABLE_ARTICLE." WHERE status=3 AND username='$_username' AND recycle=0 AND channelid='$channelid'","CACHE"));
@extract($db->get_one("SELECT COUNT(*) AS num_1 FROM ".TABLE_ARTICLE." WHERE status=1 AND username='$_username' AND recycle=0 AND channelid='$channelid'","CACHE"));
@extract($db->get_one("SELECT COUNT(*) AS num_0 FROM ".TABLE_ARTICLE." WHERE status=0 AND username='$_username' AND recycle=0 AND channelid='$channelid'","CACHE"));
@extract($db->get_one("SELECT COUNT(*) AS num_2 FROM ".TABLE_ARTICLE." WHERE status=2 AND username='$_username' AND recycle=0 AND channelid='$channelid'","CACHE"));

include template('article','myitem');
?>