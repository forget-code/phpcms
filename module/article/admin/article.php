<?php
/*
*######################################
* PHPCMS v3.00 - Advanced Content Manage System.
* Copyright (c) 2004-2005 phpcms.cn
*
* For further information go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*######################################
*/
defined('IN_PHPCMS') or exit('Access Denied');

$channelid = intval($channelid);
if(!$channelid) showmessage('非法参数！请返回！',$referer);

$pagesize=$_PHPCMS[pagesize];
$tree = new tree;
$cat_option = cat_option($catid);
$cat_pos = cat_pos($catid);

$submenu=array(
	array('<font color="red">添加文章</font>','?mod='.$mod.'&file='.$file.'&action=add&channelid='.$channelid.'&catid='.$catid.'&specialid='.$specialid),
	array('审核文章','?mod='.$mod.'&file='.$file.'&action=check&channelid='.$channelid.'&catid='.$catid.'&specialid='.$specialid),
	array('<font color="red">管理文章</font>','?mod='.$mod.'&file='.$file.'&action=manage&channelid='.$channelid.'&catid='.$catid.'&specialid='.$specialid),
	array('我添加的文章','?mod='.$mod.'&file='.$file.'&action=myitem&channelid='.$channelid.'&catid='.$catid.'&specialid='.$specialid),
	array('<font color="red">管理专题文章</font>','?mod='.$mod.'&file='.$file.'&action=special&channelid='.$channelid.'&catid='.$catid.'&specialid='.$specialid),
	array('批量移动文章','?mod='.$mod.'&file='.$file.'&action=move&channelid='.$channelid.'&catid='.$catid.'&specialid='.$specialid),
	array('回收站管理','?mod='.$mod.'&file='.$file.'&action=recycle&channelid='.$channelid.'&catid='.$catid.'&specialid='.$specialid)
);

$menu=adminmenu('文章管理',$submenu);

$referer=$referer ? $referer : urlencode($PHP_REFERER);
$action=$action ? $action : 'add';

purview_category($catid,$action); 

switch($action){

case 'add':
	if(!is_array($_CAT)) showmessage("请先添加栏目！","?mod=phpcms&file=category&action=add&channelid=".$channelid);
	if($submit)
	{
	    if($_grade==4 && $status==3) showmessage("您没有权限！");

		if(!$catid)
		{
			showmessage('对不起，请选择所属栏目！请返回！');
		}
		if($_CAT[$catid][child] && !$_CAT[$catid][enableadd])
		{
			showmessage('指定栏目不允许添加文章！请返回！');
		}
		if(empty($title))
		{
			showmessage('对不起，简短标题不能为空！请返回！');
		}
		if($linkurl=="" && empty($content))
		{
			showmessage('对不起，文章内容不能为空！请返回！');
		}
		$groupview=is_array($groupview) ? implode(',',$groupview) : $groupview;
		$addtime=preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/i', $addtime) ? strtotime($addtime.' '.date('H:i:s',$timestamp)) : $timestamp;
		if($addkeywords && !empty($keywords))
		{
			$keyword = explode(",", $keywords);
			foreach($keyword as $key)
			{
				update_keyword($key,$channelid);
			}
		}
		if($addauthors && !empty($author))
		{
			update_author($author,$channelid,0);
		}
		if($addcopyfroms && !empty($copyfromname))
		{
			update_copyfrom($copyfromname,$copyfromurl,$channelid);
		}
		if($is_saveremotefiles)
		{
			@set_time_limit(120);
			include_once PHPCMS_ROOT."/include/saveremotefiles.php";
            $content = save_remotefiles($content,$PHP_DOMAIN,"gif|jpg|jpeg|bmp|png");
		}
		$db->query("INSERT INTO ".TABLE_ARTICLE."(channelid,catid,specialid,title,titleintact,subheading,includepic,titlefontcolor,titlefonttype,showcommentlink,description,keywords,author,copyfromname,copyfromurl,content,paginationtype,maxcharperpage,thumb,savepathfilename,ontop,elite,stars,status,linkurl,readpoint,groupview,username,addtime,editor,edittime,checker,checktime,templateid,skinid) VALUES('$channelid','$catid','$specialid','$title','$titleintact','$subheading','$includepic','$titlefontcolor','$titlefonttype','$showcommentlink','$description','$keywords','$author','$copyfromname','$copyfromurl','$content','$paginationtype','$maxcharperpage','$thumb','$savepathfilename','$ontop','$elite','$stars','$status','$linkurl','$readpoint','$groupview','$_username','$timestamp','$_username','$addtime','$_username','$addtime','$templateid','$skinid')");
		$articleid = $db->insert_id();
		field_update($channelid,"articleid=$articleid");
		if($status==3)
		{
            credit_add($_username,$_CAT[$catid]['creditget']);
			tohtml("article");
            include PHPCMS_ROOT."/include/updatewithinfo.php";
		}
		showmessage('操作成功！',$referer);
	}
	else
	{
		$referer=urlencode('?mod='.$mod.'&file='.$file.'&action=add&channelid='.$channelid.'&catid='.$catid);
		//实现自动添加点数
		foreach( $_CAT as $key=>$val)
		{
			$cats.="arr[".$key."]=".$val['defaultpoint'].";\n";
		}
		$cat_select = cat_select('catid','请选择栏目',$catid,"onchange='setff(this.value)'");
		$special_select = special_select($channelid,'specialid','不属于任何专题',$specialid);
		$showskin = showskin('skinid',$skinid);
		$showtpl = showtpl($mod,'content','templateid',$templateid);
		$showgroup = showgroup('checkbox','groupview[]');
		$color_select = color_select('titlefontcolor','颜色',$colorcode);
		$fonttype_select = fonttype_select('titlefonttype','字形',$defaultfont);
		$keyword_select = keyword_select($channelid);
		$author_select = author_select($channelid);
		$copyfrom_select = copyfrom_select($channelid);
		$fields = field_input($channelid,"tablerow");
		$today=date('Y-m-d',time());
		include admintpl('article_add');
	}
break;

case 'edit':

	if($submit)
	{
        if($_grade==4 && $status==3) showmessage("您没有权限！");

		if(empty($articleid))
		{
			showmessage('非法参数！请返回！');
		}
		if(!$catid)
		{
			showmessage('对不起，请选择所属栏目！请返回！');
		}
		if(empty($title))
		{
			showmessage('对不起，标题不能为空！请返回！');
		}
		if(!$linkurl && empty($content))
		{
			showmessage('对不起，文章内容不能为空！请返回！');
		}
		$groupview=is_array($groupview) ? implode(',',$groupview) : $groupview;
		$addtime=preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/i', $addtime) ? strtotime($addtime.' '.date('H:i:s',$timestamp)) : $timestamp;
		if($addkeywords && !empty($keywords))
		{
			$keyword = explode(",", $keywords);
			foreach($keyword as $key)
			{
				update_keyword($key,$channelid);
			}
		}
		if($addauthors && !empty($author))
		{
			update_author($author,$channelid,0);
		}
		if($addcopyfroms && !empty($copyfromname))
		{
			update_copyfrom($copyfromname,$copyfromurl,$channelid);
		}
		if($is_saveremotefiles)
		{
			@set_time_limit(120);
			include_once PHPCMS_ROOT."/include/saveremotefiles.php";
            $content = save_remotefiles($content,$PHP_DOMAIN,"gif|jpg|jpeg|bmp|png");
		}
		$db->query("UPDATE ".TABLE_ARTICLE." SET catid='$catid',specialid='$specialid',title='$title',titleintact='$titleintact',subheading='$subheading',includepic='$includepic',titlefontcolor='$titlefontcolor',titlefonttype='$titlefonttype',showcommentlink='$showcommentlink',description='$description',keywords='$keywords',author='$author',copyfromname='$copyfromname',copyfromurl='$copyfromurl',content='$content',paginationtype='$paginationtype',maxcharperpage='$maxcharperpage',thumb='$thumb',savepathfilename='$savepathfilename',ontop='$ontop',stars='$stars',status='$status',linkurl='$linkurl',editor='$_username',edittime='$timestamp',addtime='$addtime',readpoint='$readpoint',groupview='$groupview',templateid='$templateid',skinid='$skinid' WHERE articleid='$articleid' AND channelid='$channelid'");
		field_update($channelid,"articleid=$articleid");
		if($status==3)
		{
			tohtml("article");
            include PHPCMS_ROOT."/include/updatewithinfo.php";
		}
		showmessage('操作成功！',$referer);
	}
	else
	{
		if(empty($articleid))
		{
			showmessage('非法参数！请返回！');
		}
		$r=$db->get_one("SELECT * FROM ".TABLE_ARTICLE." WHERE articleid='$articleid' AND channelid='$channelid'");
		if(!$r['articleid']) showmessage("参数错误！");

		@extract(dhtmlspecialchars($r));

        if($_grade>3 && $status==3) showmessage("您没有权限！");

		$addtime=date("Y-m-d",$addtime);
		//实现自动添加点数
		foreach( $_CAT as $key=>$val)
		{
			$cats.="arr[".$key."]=".$val['defaultpoint'].";\n";
		}
		$cat_select = cat_select('catid','请选择栏目',$catid);
		$special_select = special_select($channelid,'specialid','不属于任何专题',$specialid);
		$showskin = showskin('skinid',$skinid);
		$showtpl = showtpl($mod,'content','templateid',$templateid);
		$showgroup = showgroup('checkbox','groupview[]',$groupview);
		$color_select = color_select('titlefontcolor','颜色',$titlefontcolor);
		$fonttype_select = fonttype_select('titlefonttype','字形',$titlefonttype);
		$keyword_select = keyword_select($channelid);
		$author_select = author_select($channelid);
		$copyfrom_select = copyfrom_select($channelid);
		$fields = field_input($channelid,"tablerow");
		include admintpl('article_edit');
	}
break;

case 'checktitle':
	if(empty($title)) $error_msg='标题不能为空！请返回！';
	$result=$db->query("SELECT articleid,catid,title,addtime FROM ".TABLE_ARTICLE." WHERE status=3 AND recycle=0 AND channelid=$channelid AND title LIKE '%$title%' ORDER BY articleid");
	while($r=$db->fetch_array($result))
	{
		$p->set_catid($r[catid]);
		$r[url] = $p->get_itemurl($r[articleid],$r[addtime]);
		$r[adddate]=date("m-d",$r[addtime]);
		$articles[]=$r;
	}
	include admintpl('article_checktitle');
break;


case 'manage':
	$referer=urlencode('?mod='.$mod.'&file='.$file.'&action=manage&channelid='.$channelid.'&catid='.$catid.'&srchtype='.$srchtype.'&keyword='.$keyword.'&ontop='.$ontop.'&elite='.$elite.'&ordertype='.$ordertype.'&page='.$page);
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
	if($time) $addquery .= sql_time($time);

	$r = $db->get_one("SELECT COUNT(*) AS num FROM ".TABLE_ARTICLE." WHERE status=3 AND recycle=0 AND channelid='$channelid' $addquery");
	$number=$r["num"];
	$url="?mod=".$mod."&file=".$file."&action=manage&channelid=".$channelid."&catid=".$catid."&srchtype=".$srchtype."&keyword=".$keyword."&ontop=".$ontop."&elite=".$elite."&ordertype=".$ordertype."&page=".$page;
	$pages=phppages($number,$page,$pagesize,$url);
	$result=$db->query("SELECT articleid,channelid,catid,title,includepic,titlefontcolor,titlefonttype,showcommentlink,linkurl,hits,username,addtime,editor,edittime,checker,checktime,ontop,elite,stars,recycle,status FROM ".TABLE_ARTICLE." WHERE status=3 AND recycle=0 AND channelid='$channelid' $addquery ORDER BY $dordertype LIMIT $offset,$pagesize");
	while($r=$db->fetch_array($result))
	{
		$p->set_catid($r[catid]);
		$r[url] = $r[linkurl] ? $r[linkurl] : $p->get_itemurl($r[articleid],$r[addtime]);
		$r[catdir] = $p->get_listurl(0);
		$r[title] = titleformat($r[title],$r[titlefontcolor],$r[titlefonttype],$r[includepic]);
		$r[adddate]=date("Y-m-d",$r[addtime]);
		$articles[]=$r;
	}
	include admintpl('article_manage');
break;

case 'special':
	$referer=urlencode('?mod='.$mod.'&file='.$file.'&action=special&channelid='.$channelid.'&specialid='.$specialid.'&srchtype='.$srchtype.'&keyword='.$keyword.'&ontop='.$ontop.'&elite='.$elite.'&ordertype='.$ordertype.'&page='.$page);
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

	$addquery .= $specialid ? " AND specialid=$specialid " : "";
	$addquery .= $elite ? " AND elite=1 " : "";
	$addquery .= $ontop ? " AND ontop=1 " : "";
	$addquery .= $time ? sql_time($time) : "";
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

	$r = $db->get_one("SELECT COUNT(*) AS num FROM ".TABLE_ARTICLE." a WHERE status=3 AND recycle=0 AND specialid>0 AND channelid='$channelid' $addquery");
	$number=$r["num"];
	$url="?mod=".$mod."&file=".$file."&action=special&channelid=".$channelid."&catid=".$catid."&specialid=".$specialid."&srchtype=".$srchtype."&keyword=".$keyword."&ontop=".$ontop."&elite=".$elite."&ordertype=".$ordertype."&page=".$page;
	$pages=phppages($number,$page,$pagesize,$url);
	$result=$db->query("SELECT articleid,specialid,catid,title,includepic,titlefontcolor,titlefonttype,showcommentlink,linkurl,hits,username,addtime,editor,edittime,checker,checktime,ontop,elite,stars FROM ".TABLE_ARTICLE." WHERE status=3 AND recycle=0 AND specialid>0 AND channelid='$channelid' $addquery ORDER BY $dordertype LIMIT $offset,$pagesize");
	while($r=$db->fetch_array($result))
	{
	    $s = $db->get_one("SELECT specialid,specialname,addtime FROM ".TABLE_SPECIAL." a WHERE specialid=$r[specialid]");
		$p->set_catid($r[catid]);
		$r[url] = $r[linkurl] ? $r[linkurl] : $p->get_itemurl($r[articleid],$r[addtime]);
		$r[specialname] = wordscut($s[specialname],24,1);
		$r[specialurl] = $p->get_specialitemurl($s[specialid],$s[addtime]);
		$r[title] = titleformat($r[title],$r[titlefontcolor],$r[titlefonttype],$r[includepic]);
		$r[adddate]=date("Y-m-d",$r[addtime]);
		$articles[]=$r;
	}
	$special_list = special_select($channelid,'specialid','请选择专题',$specialid);
	$special_select = special_select($channelid,'jump','请选择专题进行管理',$specialid,'onchange="if(this.options[this.selectedIndex].value!=\'\'){location=\'?mod='.$mod.'&file='.$file.'&action=special&channelid='.$channelid.'&specialid=\'+this.options[this.selectedIndex].value;}"');
	include admintpl('article_special');
break;

case 'myitem':

	$status=isset($status) ? $status : 3;
	$referer=urlencode('?mod='.$mod.'&file='.$file.'&action=myitem&channelid='.$channelid.'&catid='.$catid.'&status='.$status.'&srchtype='.$srchtype.'&keyword='.$keyword.'&ontop='.$ontop.'&elite='.$elite.'&ordertype='.$ordertype.'&page='.$page);
	@extract($db->get_one("SELECT COUNT(*) AS num_3 FROM ".TABLE_ARTICLE." WHERE status=3 AND username='$_username' AND recycle=0 AND channelid='$channelid'","CACHE"));
	@extract($db->get_one("SELECT COUNT(*) AS num_1 FROM ".TABLE_ARTICLE." WHERE status=1 AND username='$_username' AND recycle=0 AND channelid='$channelid'","CACHE"));
	@extract($db->get_one("SELECT COUNT(*) AS num_0 FROM ".TABLE_ARTICLE." WHERE status=0 AND username='$_username' AND recycle=0 AND channelid='$channelid'","CACHE"));
	@extract($db->get_one("SELECT COUNT(*) AS num_2 FROM ".TABLE_ARTICLE." WHERE status=2 AND username='$_username' AND recycle=0 AND channelid='$channelid'","CACHE"));
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
	$url="?mod=".$mod."&file=".$file."&action=myitem&channelid=".$channelid."&catid=".$catid."&status=".$status."&srchtype=".$srchtype."&keyword=".$keyword."&ontop=".$ontop."&elite=".$elite."&ordertype=".$ordertype."&page=".$page;
	$pages=phppages($number,$page,$pagesize,$url);
	$query="SELECT articleid,channelid,catid,title,includepic,titlefontcolor,titlefonttype,showcommentlink,linkurl,hits,username,addtime,editor,edittime,checker,checktime,ontop,elite,stars,recycle,status FROM ".TABLE_ARTICLE." WHERE status='$status' AND username='$_username' AND recycle=0 AND channelid='$channelid' $addquery ORDER BY $dordertype LIMIT $offset,$pagesize ";
	$result=$db->query($query);
	while($r=$db->fetch_array($result))
	{
		$p->set_catid($r[catid]);
		$r[url] = $r[linkurl] ? $r[linkurl] : $p->get_itemurl($r[articleid],$r[addtime]);
		$r[catdir] = $p->get_caturl();
		$r[title] = titleformat($r[title],$r[titlefontcolor],$r[titlefonttype],$r[includepic]);
		$r[adddate]=date("Y-m-d",$r[addtime]);
		
		$articles[]=$r;
	}
	
	include admintpl('article_myitem');
break;


case 'check':
	$referer=urlencode("?mod=".$mod."&file=".$file."&action=check&channelid=".$channelid."&catid=".$catid."&srchtype=".$srchtype."&keywords=".$keywords."&ordertype=".$ordertype."&page=".$page);
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
		$addquery.=" AND catid=$catid ";
	}
	elseif($_grade==5)
	{
		$catids = is_array($_purview_category) ? implode(",",$_purview_category) : "";
		$addquery .= $catids ? " AND catid IN($catids) " : "";
	}

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
	$r = $db->get_one("SELECT COUNT(*) AS num FROM ".TABLE_ARTICLE." WHERE status=1 AND recycle=0 AND channelid='$channelid' $addquery");
	$number=$r["num"];
	$url="?mod=".$mod."&file=".$file."&action=check&channelid=".$channelid."&catid=".$catid."&srchtype=".$srchtype."&keyword=".$keyword."&ordertype=".$ordertype."&page=".$page;
	$pages=phppages($number,$page,$pagesize,$url);
	$result=$db->query("SELECT articleid,channelid,catid,title,includepic,titlefontcolor,titlefonttype,showcommentlink,linkurl,hits,username,addtime,editor,edittime,checker,checktime,ontop,elite,stars,recycle,status FROM ".TABLE_ARTICLE." WHERE status=1 AND recycle=0 AND channelid='$channelid' $addquery ORDER BY $dordertype LIMIT $offset,$pagesize");
	while($r=$db->fetch_array($result))
	{
		$p->set_catid($r[catid]);
		$r[catdir] = $p->get_listurl(0);
		$r[title] = titleformat($r[title],$r[titlefontcolor],$r[titlefonttype],$r[includepic]);
		$r[adddate]=date("Y-m-d",$r[addtime]);
		
		$articles[]=$r;
	}
	include admintpl('article_check');
break;

case 'sendback':

	if($submit)
	{
		if(empty($articleid))
		{
			showmessage('非法参数！请返回！');
		}
		if($ifpm)
		{
			if(empty($title))
			{
				showmessage('对不起，标题不能为空！请返回！');
			}
			if(empty($content))
			{
				showmessage('对不起，内容不能为空！请返回！');
			}
			sendpm($username,$title,$content);
		}
		if($ifemail)
		{
			sendusermail($username,$title,$content);
		}
		$db->query("UPDATE ".TABLE_ARTICLE." SET status=2,elite=0,ontop=0 WHERE articleid='$articleid' AND channelid='$channelid'");
		showmessage('操作成功！',$referer);

	}
	else
	{
		if(empty($articleid))
		{
			showmessage('非法参数！请返回！');
		}
		$article=$db->get_one("SELECT title,catid,username,status FROM ".TABLE_ARTICLE." WHERE articleid='$articleid' AND channelid='$channelid'");
		if($article['title'])
		{
			$article[status] == 1 or showmessage('无法进行此操作！请返回！');
		}
		else
		{
			showmessage('文章不存在！请返回！');
		}
		$referer=urlencode('?mod='.$mod.'&file='.$file.'&action=check&channelid='.$channelid);
		include admintpl('article_sendback');
	}
break;

case 'send':

	if(empty($articleid))
	{
		showmessage('非法参数！请返回！');
	}
	
	$r=$db->get_one("SELECT status FROM ".TABLE_ARTICLE." WHERE articleid='$articleid' AND channelid='$channelid'");
	$status = $r['status'];

	if($_grade==4 && $status==3) showmessage("您没有权限！");

	$db->query("UPDATE ".TABLE_ARTICLE." SET status=1 WHERE articleid='$articleid' AND channelid='$channelid'");
	showmessage('操作成功！',$referer);

break;

case 'move':

	if($submit)
	{
		$specialid = intval($specialid);
		$targetcatid = intval($targetcatid);
		if(!$specialid && !$targetcatid) showmessage('非法参数！请返回！');
		if($targetcatid && $_CAT[$targetcatid]['child'] && !$_CAT[$targetcatid]['enableadd']) showmessage('指定栏目不允许添加文章！请返回！');

		if($movetype==1)
		{
			if(empty($articleid)) showmessage('非法参数！请返回！');
			$articleids=is_array($articleid) ? implode(',',$articleid) : $articleid;
			if($specialid) $db->query("UPDATE ".TABLE_ARTICLE." SET specialid='$specialid' WHERE articleid IN ($articleids) AND status=3 AND channelid='$channelid' ");
			if($targetcatid) $db->query("UPDATE ".TABLE_ARTICLE." SET catid='$targetcatid' WHERE articleid IN ($articleids) AND status=3 AND channelid='$channelid' ");
		}
		else
		{
			if(empty($batchcatid)) showmessage('非法参数！请返回！');
			$batchcatids=implode(",",$batchcatid);
			if($specialid) $db->query("UPDATE ".TABLE_ARTICLE." SET specialid='$specialid' WHERE catid IN ($batchcatids) AND status=3 AND channelid='$channelid' ");
			if($targetcatid) $db->query("UPDATE ".TABLE_ARTICLE." SET catid='$targetcatid' WHERE catid IN ($batchcatids) AND status=3 AND channelid='$channelid' ");
		}
		showmessage('操作成功！',$referer);
	}
	else
	{
		$referer=urlencode('?mod='.$mod.'&file='.$file.'&action=move&channelid='.$channelid);
		$articleid=is_array($articleid) ? implode(',',$articleid) : $articleid;
		$special_select = special_select($channelid,'specialid','请选择专题',$specialid);
		include admintpl('article_move');
	}
break;

case 'recycle':

	$status=isset($status) ? $status : 3;
	$referer=urlencode("?mod=".$mod."&file=".$file."&action=recycle&channelid=".$channelid."&catid=".$catid."&status=".$status."&page=".$page);
	
	@extract($db->get_one("SELECT COUNT(*) AS num_3 FROM ".TABLE_ARTICLE." WHERE status=3 AND username='$_username' AND recycle=1 AND channelid='$channelid'","CACHE"));
	@extract($db->get_one("SELECT COUNT(*) AS num_1 FROM ".TABLE_ARTICLE." WHERE status=1 AND username='$_username' AND recycle=1 AND channelid='$channelid'","CACHE"));
	@extract($db->get_one("SELECT COUNT(*) AS num_0 FROM ".TABLE_ARTICLE." WHERE status=0 AND username='$_username' AND recycle=1 AND channelid='$channelid'","CACHE"));
	@extract($db->get_one("SELECT COUNT(*) AS num_2 FROM ".TABLE_ARTICLE." WHERE status=2 AND username='$_username' AND recycle=1 AND channelid='$channelid'","CACHE"));
	
	if(!$page)
	{
		$page=1;
		$offset=0;
	}
	else
	{
		$offset=($page-1)*$pagesize;
	}
	if($catid)
	{
		$arrchildid = $_CAT[$catid][child] ? $catid.$_CAT[$catid][arrchildid] : $catid;
		$addquery = " AND catid IN($arrchildid) ";
	}
	$r = $db->get_one("SELECT COUNT(*) as num FROM ".TABLE_ARTICLE." WHERE recycle=1 AND status='$status' $addquery");
	$number=$r["num"];
	$url="?mod=".$mod."&file=".$file."&action=recycle&channelid=".$channelid."&catid=".$catid."&status=".$status."&page=".$page;
	$pages=phppages($number,$page,$pagesize,$url);

	$result=$db->query("SELECT articleid,channelid,catid,title,includepic,titlefontcolor,titlefonttype,showcommentlink,linkurl,hits,username,addtime,editor,edittime,checker,checktime,ontop,elite,stars,recycle,status FROM ".TABLE_ARTICLE." WHERE recycle=1 AND status='$status' $addquery ORDER BY articleid DESC ");
	while($r=$db->fetch_array($result))
	{
		$p->set_catid($r[catid]);
		$r[catdir] = $p->get_caturl();
		$r[title] = titleformat($r[title],$r[titlefontcolor],$r[titlefonttype],$r[includepic]);
		$r[adddate]=date("Y-m-d",$r[addtime]);
		$articles[]=$r;
	}
	include admintpl('article_recycle');
break;

case 'preview':
	
	if(!ereg('^[0-9]+$',$articleid)) showmessage('非法参数！请返回！');

	@extract($db->get_one("SELECT * FROM ".TABLE_ARTICLE." WHERE articleid=$articleid"));
	$url = $p->get_itemurl($articleid,$addtime);
	$adddate=date('Y-m-d',$addtime);
	include admintpl('article_preview');

break;

case 'specialout':

	if(empty($articleid)) showmessage('非法参数！请返回！');

	$articleids=is_array($articleid) ? implode(',',$articleid) : $articleid;
	$db->query("UPDATE ".TABLE_ARTICLE." SET specialid=0 WHERE articleid IN ($articleids) AND channelid='$channelid'");
	if($db->affected_rows()>0)
	{
		showmessage('操作成功！',$referer);
	}
	else
	{
		showmessage('操作失败！请返回！');
	}
break;

case 'elite':

	if(empty($articleid)) showmessage('非法参数！请返回！');
	if(!ereg('^[0-1]+$',$value)) showmessage('非法参数！请返回！');

	$articleids = is_array($articleid) ? implode(',',$articleid) : $articleid;
	$result = $db->query("SELECT catid,elite,username FROM ".TABLE_ARTICLE." WHERE articleid IN ($articleids)");
	while($r = $db->fetch_array($result))
	{
		$credit = $r['elite'] < $value ? $_CAT[$r['catid']]['creditget'] : ($r['elite'] > $value ? -$_CAT[$r['catid']]['creditget'] : 0);
		if($credit!=0) credit_add($r['username'],$credit);
	}
	$db->query("UPDATE ".TABLE_ARTICLE." SET elite='$value' WHERE articleid IN ($articleids) AND channelid='$channelid'");
	if($db->affected_rows()>0)
	{
		showmessage('操作成功！',$referer);
	}
	else
	{
		showmessage('操作失败！请返回！');
	}
break;

case 'ontop':

	if(empty($articleid)) showmessage('非法参数！请返回！');
	if(!ereg('^[0-1]+$',$value)) showmessage('非法参数！请返回！');

	$articleids=is_array($articleid) ? implode(',',$articleid) : $articleid;
	$db->query("UPDATE ".TABLE_ARTICLE." SET ontop='$value' WHERE articleid IN ($articleids) AND channelid='$channelid'");
	if($db->affected_rows()>0)
	{
		showmessage('操作成功！',$referer);
	}
	else
	{
		showmessage('操作失败！请返回！');
	}
break;

case 'torecycle':

	if(empty($articleid)) showmessage('非法参数！请返回！');
	if(!ereg('^[0-1]+$',$value)) showmessage('非法参数！请返回！');

	if($_grade==4) $condition = " AND username='$_username' AND status<3";
	if($_grade==5) $condition = " AND status<3";
	$articleids=is_array($articleid) ? implode(',',$articleid) : $articleid;
	$result = $db->query("SELECT catid,recycle,username FROM ".TABLE_ARTICLE." WHERE articleid IN ($articleids) AND channelid='$channelid'");
	while($r = $db->fetch_array($result))
	{
		$credit = $r['recycle'] < $value ? -$_CAT[$r['catid']]['creditget'] : ($r['recycle'] > $value ? $_CAT[$r['catid']]['creditget'] : 0);
		if($credit!=0) credit_add($r['username'],$credit);
	}
	$db->query("UPDATE ".TABLE_ARTICLE." SET recycle='$value' WHERE articleid IN ($articleids) AND channelid='$channelid' $condition");
	if($db->affected_rows()>0)
	{
		tohtml("index");
        tohtml("index",PHPCMS_ROOT);
		showmessage('操作成功！',$referer);
	}
	else
	{
		showmessage('操作失败！请返回！');
	}
break;

case 'pass':

    if(empty($articleid)) showmessage('非法参数！请返回！');

	$articleids = is_array($articleid) ? implode(',',$articleid) : $articleid;
	$result = $db->query("SELECT articleid,catid,specialid,status,username FROM ".TABLE_ARTICLE." WHERE articleid IN ($articleids) AND channelid='$channelid'");
	while($r = $db->fetch_array($result))
	{
		$info[$r[articleid]] = $r;
		if($r['status']<3) credit_add($r['username'],$_CAT[$r['catid']]['creditget']);
	}
	$db->query("UPDATE ".TABLE_ARTICLE." SET checker='$_username',checktime='$timestamp',status=3 WHERE articleid IN ($articleids) AND channelid='$channelid'");
	if($db->affected_rows()>0)
	{
		if(is_array($articleid))
		{
			$arrarticleid = $articleid;
			foreach($arrarticleid as $articleid)
			{
				tohtml("article");
                @extract($info[$articleid]);
                include PHPCMS_ROOT."/include/updatewithinfo.php";
			}
		}
		else
		{
			tohtml("article");
            @extract($info[$articleid]);
            include PHPCMS_ROOT."/include/updatewithinfo.php";
		}
		showmessage('操作成功！',$referer);
	}
	else
	{
		showmessage('操作失败！请返回！');
	}
break;

case 'restoreall'://还原所有

	$result = $db->query("SELECT catid,status,username FROM ".TABLE_ARTICLE." WHERE recycle=1 AND channelid='$channelid'");
	while($r = $db->fetch_array($result))
	{
		if($r['status']==3) credit_add($r['username'],$_CAT[$r['catid']]['creditget']);
	}
	$db->query("UPDATE ".TABLE_ARTICLE." SET recycle=0 WHERE recycle=1 AND channelid='$channelid'");
	if($db->affected_rows()>0)
	{
		tohtml("index");
        tohtml("index",PHPCMS_ROOT);
		showmessage('操作成功！',$referer);
	}
	else
	{
		showmessage('操作失败！请返回！');
	}
break;

case 'delete':
	if(empty($articleid)) showmessage('非法参数！请返回！');
	$articleids=is_array($articleid) ? implode(',',$articleid) : $articleid;
	$result=$db->query("SELECT articleid,catid,addtime,thumb FROM ".TABLE_ARTICLE." WHERE articleid IN ($articleids) AND channelid='$channelid'");
	while($r=$db->fetch_array($result))
	{
		if($r[thumb] && !preg_match("|://|",$r[thumb])) @$f->unlink($r[thumb]);
		if($_CHA['htmlcreatetype'])
		{
			$p->set_type("path");
			$p->set_catid($r[catid]);
			$filename = $p->get_itemurl($r[articleid],$r[addtime]);
			@$f->unlink($filename);
		}
	}
	$db->query("DELETE FROM ".TABLE_ARTICLE." WHERE articleid IN ($articleids) AND channelid='$channelid'");
	if($db->affected_rows()>0)
	{
		tohtml("index");
        tohtml("index",PHPCMS_ROOT);
		showmessage('操作成功！',$referer);
	}
	else
	{
		showmessage('操作失败！请返回！');
	}
break;

case 'deleteall':
	$result=$db->query("SELECT articleid,catid,addtime,thumb FROM ".TABLE_ARTICLE." WHERE recycle=1 AND channelid='$channelid'");
	while($r=$db->fetch_array($result))
	{
		if($r[thumb] && !preg_match("|://|",$r[thumb])) @$f->unlink($r[thumb]);
		if($_CHA['htmlcreatetype'])
		{
			$p->set_type("path");
			$p->set_catid($r[catid]);
			$filename=$p->get_itemurl($r[articleid],$r[addtime]);
			@$f->unlink($filename);
		}
	}
	$db->query("DELETE FROM ".TABLE_ARTICLE." WHERE recycle=1 AND channelid='$channelid'");
	if($db->affected_rows()>0)
	{
		tohtml("index");
        tohtml("index",PHPCMS_ROOT);
		showmessage('操作成功！',$referer);
	}
	else
	{
		showmessage('操作失败！请返回！');
	}
break;
}
?>