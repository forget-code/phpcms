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

$submenu=array(
	array('<font color="red">添加图片</font>','?mod='.$mod.'&file='.$file.'&action=add&channelid='.$channelid),
	array('审核图片','?mod='.$mod.'&file='.$file.'&action=check&status=1&channelid='.$channelid),
	array('<font color="red">管理图片</font>','?mod='.$mod.'&file='.$file.'&action=manage&channelid='.$channelid),
	array('我添加的图片','?mod='.$mod.'&file='.$file.'&action=myitem&channelid='.$channelid),
	array('<font color="red">管理专题图片</font>','?mod='.$mod.'&file='.$file.'&action=special&channelid='.$channelid),
	array('批量移动图片','?mod='.$mod.'&file='.$file.'&action=move&channelid='.$channelid),
	array('回收站管理','?mod='.$mod.'&file='.$file.'&action=recycle&channelid='.$channelid)
);
$menu=adminmenu('图片管理',$submenu);

$referer = $referer ? $referer : $PHP_REFERER;

$pagesize=$_PHPCMS['pagesize'];

$tree = new tree;

$cat_option = cat_option($catid);

$script="onchange=\"if(this.options[this.selectedIndex].value!=''){location='?mod=".$mod."&file=".$mod."&action=".
$action."&value=".$value."&channelid=".$channelid."&catid='+this.options[this.selectedIndex].value;}\"";
$cat_jump = cat_select('catid','请选择栏目进行管理',$catid,$script);

$cat_pos = cat_pos($catid);

$referer=$referer ? $referer : $PHP_REFERER;

$action=$action ? $action : 'manage';

//搜索
if(!empty($keywords))
{
	$keyword=str_replace(' ','%',$keywords);
	$keyword=str_replace('*','%',$keyword);
	switch($srchtype)
	{
		case '0':
			$addquery=" AND title LIKE '%$keyword%' ";
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
			$addquery=" AND title LIKE '%$keyword%' ";
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

$addquery .= $elite ? " AND elite=1 " : "";
$addquery .= $ontop ? " AND ontop=1 " : "";
switch($ordertype)
{
	case 1:
		$dordertype=" pictureid DESC ";
break;
	case 2:
		$dordertype=" pictureid ";
break;
	case 3:
		$dordertype=" hits DESC ";
break;
	case 4:
		$dordertype=" hits ";
break;
	default :
		$dordertype=" pictureid DESC ";
}

purview_category($catid,$action);

switch($action){

case 'add':
	if(!is_array($_CAT)) showmessage("请先添加栏目！","?mod=phpcms&file=category&action=add&channelid=".$channelid);

	if($submit)
	{
		if($_grade==4 && $status==3) showmessage("您没有权限！");

		if(!$catid)	showmessage('对不起，请选择所属栏目！请返回！');
		if($_CAT[$catid][child] && !$_CAT[$catid][enableadd]) showmessage('指定栏目不允许添加图片！请返回！');
		if(empty($title)) showmessage('对不起，标题不能为空！请返回！');
		if(!$linkurl && !$pictureurls) showmessage('图片地址不能为空！请返回！');

		$groupview = is_array($groupview) ? implode(',',$groupview) : $groupview;

		$addtime = preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/i', $addtime) ? strtotime($addtime.' '.date('H:i:s',$timestamp)) : $timestamp;

		if($addkeywords && !empty($keywords))
		{
			$keywords_in = explode(",", $keywords);
			foreach($keywords_in as $keyword)
			{
				update_keyword($keyword,$channelid);
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
	
		$db->query("INSERT INTO ".TABLE_PICTURE."(channelid,catid,specialid,title,thumb,titlefontcolor,titlefonttype,author,copyfromname,copyfromurl,linkurl,username,addtime,keywords,content,pictureurls,ontop,elite,status,checker,checktime,stars,skinid,templateid,readpoint,groupview) VALUES('$channelid','$catid','$specialid','$title','$thumb','$titlefontcolor','$titlefonttype','$author','$copyfromname','$copyfromurl','$linkurl','$_username','$addtime','$keywords','$content','$pictureurls','$ontop','$elite','$status','$_username','$addtime','$stars','$skinid','$templateid','$readpoint','$groupview')");
		$pictureid=$db->insert_id();
		field_update($channelid,"pictureid=$pictureid");
		if($status==3)
		{
            credit_add($_username,$_CAT[$catid]['creditget']);
			tohtml("picture");
            include PHPCMS_ROOT."/include/updatewithinfo.php";
		}
	    $referer="?mod=picture&file=picture&action=".$action."&channelid=".$channelid."&catid=".$catid."&status=".$status;
		showmessage('操作成功！',$referer); 
	}
	else
	{
		//实现自动添加点数
		foreach( $_CAT as $key=>$val)
		{
			$cats.="arr[".$key."]=".$val['defaultpoint'].";\n";
		}
		$cat_select = cat_select('catid','请选择栏目',$catid,"onchange='setff(this.value)'");
		//自定义字段
		$fields = field_input($channelid,"tablerow");
		$special_select = special_select($channelid,'specialid','不属于任何专题',$specialid);
		$titlefontcolor=color_select('titlefontcolor','颜色',$colorcode);
		$fonttype=fonttype_select('titlefonttype','字形',$defaultfont);
		$showskin = showskin($name='skinid',$skinid);
		$showtpl = showtpl($module='picture',$typename='content',$name='templateid',$templateid);
		$keyword_select = keyword_select($channelid);
		$author_select = author_select($channelid);
		$copyfrom_select = copyfrom_select($channelid);
		$showgroup = showgroup('checkbox','groupview[]');

		$today=date("Y-m-d",$timestamp);
		include admintpl('picture_add');
	}

break;

case 'edit':
	if(!$pictureid) showmessage('非法参数！请返回！');

	if($submit)
	{
		if($_grade==4 && $status==3) showmessage("您没有权限！");

		if(!$catid)	showmessage('对不起，请选择所属栏目！请返回！');
		if($_CAT[$catid][child] && !$_CAT[$catid][enableadd]) showmessage('指定栏目不允许添加图片！请返回！');
		if(empty($title)) showmessage('对不起，标题不能为空！请返回！');
		if(!$linkurl && !$pictureurls) showmessage('图片地址不能为空！请返回！');

		$groupview = is_array($groupview) ? implode(',',$groupview) : $groupview;

		if($addkeywords && !empty($keywords))
		{
			$keywords_in = explode(",", $keywords);
			foreach($keywords_in as $keyword)
			{
				update_keyword($keyword,$channelid);
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

		$db->query("UPDATE ".TABLE_PICTURE." SET catid='$catid',specialid='$specialid',title='$title',thumb='$thumb',titlefontcolor='$titlefontcolor',titlefonttype='$titlefonttype',author='$author',copyfromname='$copyfromname',copyfromurl='$copyfromurl',linkurl='$linkurl',keywords='$keywords',content='$content',pictureurls='$pictureurls',ontop='$ontop',elite='$elite',status='$status',editor='$_username',edittime='$timestamp',stars='$stars',skinid='$skinid',templateid='$templateid',readpoint='$readpoint',groupview='$groupview' WHERE pictureid='$pictureid' AND channelid='$channelid'");
		if ($db->affected_rows()>0)
		{
		    field_update($channelid,"pictureid=$pictureid");
			if($status==3)
			{
				tohtml("picture");
                include PHPCMS_ROOT."/include/updatewithinfo.php";
			}
			showmessage('操作成功！',$referer);
		}
		else
		{
			showmessage('操作失败！');
		}
	}
	else
	{
		$picture = $db->get_one("SELECT * FROM ".TABLE_PICTURE." WHERE pictureid='$pictureid' AND channelid='$channelid'");
		
		$picture = dhtmlspecialchars($picture);

		if($_grade>3 && $picture[status]==3) showmessage("您没有权限！");

		$picture[addtime]=date("Y-m-d",$picture[addtime]);
		//实现自动添加点数
		foreach( $_CAT as $key=>$val)
		{
			$cats.="arr[".$key."]=".$val['defaultpoint'].";\n";
		}
        $titlefontcolor = color_select('titlefontcolor','颜色',$picture[titlefontcolor]);
        $fonttype = fonttype_select('titlefonttype','字形',$picture[titlefonttype]);
		$cat_select = cat_select('catid','请选择栏目',$catid);
		$special_select = special_select($channelid,'specialid','不属于任何专题',$specialid);
		$keyword_select = keyword_select($channelid);
		$author_select = author_select($channelid);
		$copyfrom_select = copyfrom_select($channelid);
		$today=date("Y-m-d",$timestamp);
		$showskin = showskin('skinid',$picture[skinid]);
		$showtpl = showtpl('picture','content','templateid',$picture[templateid]);
		$showgroup = showgroup('checkbox','groupview[]',$picture[groupview]);

        $pictureurls = trim($picture[pictureurls]);
		$pictureurls = explode("\n",$pictureurls);
		$pictureurls = array_map("trim",$pictureurls);

		$referer=urlencode('?mod=picture&file=picture&action=manage&channelid='.$channelid);
		include admintpl('picture_edit');
	}
break;

//检查图片名称是否相同
case 'checktitle':
	if(empty($title)) $error_msg='图片名称不能为空！请返回！';
	$query="SELECT pictureid,catid,title,addtime FROM ".TABLE_PICTURE." WHERE status<>2 AND recycle=0 AND channelid='$channelid' AND title LIKE '%$title%' ORDER BY pictureid DESC";
	$result=$db->query($query);
	while($r=$db->fetch_array($result))
	{
		$p->set_catid($r[catid]);
		$r[url] = $p->get_itemurl($r[pictureid],$r[addtime]);
		$r[adddate]=date("m-d",$r[addtime]);
		$pictures[]=$r;
	}
	include admintpl('picture_checktitle');
break;

//管理图片
case 'manage':

	$status=isset($status) ? $status : 3;
	$referer=urlencode("?mod=picture&file=picture&action=manage&channelid=".$channelid."&catid=".$catid."&status=".$status."&keyword=".$keyword."&ontop=".$ontop."&elite=".$elite."&ordertype=".$ordertype."&srchtype=".$srchtype."&page=".$page);
	
	if(!$page)
	{
		$page=1;
		$offset=0;
	}
	else
	{
		$offset=($page-1)*$pagesize;
	}

	$query="SELECT COUNT(*) AS num FROM ".TABLE_PICTURE." WHERE status='$status' AND recycle=0 AND channelid='$channelid' $addquery";
	$result=$db->query($query);
	$r=$db->fetch_array($result);
	$number=$r["num"];
	$url="?mod=picture&file=picture&action=manage&channelid=".$channelid."&catid=".$catid."&status=".$status."&keyword=".$keyword."&ontop=".$ontop."&elite=".$elite."&ordertype=".$ordertype."&srchtype=".$srchtype."&page=".$page."&submit=1";
	$pages=phppages($number,$page,$pagesize,$url);
	$query="SELECT * FROM ".TABLE_PICTURE." WHERE status='$status' AND recycle=0 AND channelid='$channelid' $addquery ORDER BY $dordertype LIMIT $offset,$pagesize";
	$result=$db->query($query);
	if($db->num_rows($result)>0)
	{
		while($r=$db->fetch_array($result))
		{
			$p->set_catid($r[catid]);
			$r[url] = $r[linkurl] ? $r[linkurl] : $p->get_itemurl($r[pictureid],$r[addtime]);
			$r[caturl] = $p->get_listurl(0);
	        $r[thumb] = $r[thumb] ? (preg_match("/^http:\/\//i",$r[thumb]) ? $r[thumb] : PHPCMS_PATH.$r[thumb]) : PHPCMS_PATH."images/nopic.gif";
			$r[title] = titleformat($r[title],$r[titlefontcolor],$r[titlefonttype],'');
			$r[adddate]=date("Y-m-d",$r[addtime]);
			$r[addtime]=date("Y/md",$r[addtime]);
			$pictures[]=$r;
		}
	}	include admintpl('picture_manage');
break;

//我添加的图片
case 'myitem':

	@extract($db->get_one("SELECT COUNT(*) AS num_3 FROM ".TABLE_PICTURE." WHERE status=3 AND username='$_username' AND recycle=0 AND channelid='$channelid'"));
	@extract($db->get_one("SELECT COUNT(*) AS num_1 FROM ".TABLE_PICTURE." WHERE status=1 AND username='$_username' AND recycle=0 AND channelid='$channelid'"));
	@extract($db->get_one("SELECT COUNT(*) AS num_0 FROM ".TABLE_PICTURE." WHERE status=0 AND username='$_username' AND recycle=0 AND channelid='$channelid'"));
	@extract($db->get_one("SELECT COUNT(*) AS num_2 FROM ".TABLE_PICTURE." WHERE status=2 AND username='$_username' AND recycle=0 AND channelid='$channelid'"));

    $status = isset($status) ? $status : 3;
	$referer=urlencode("?mod=picture&file=picture&action=myitem&channelid=".$channelid."&catid=".$catid."&status=".$status."&keyword=".$keyword."&ontop=".$ontop."&elite=".$elite."&ordertype=".$ordertype."&srchtype=".$srchtype."&page=".$page."&username=".$_username);
	$catid=$catid ? $catid : 0;
	$thecatid=$catid;
	if(!$page)
	{
		$page=1;
		$offset=0;
	}
	else
	{
		$offset=($page-1)*$pagesize;
	}

	$query="SELECT COUNT(*) as num FROM ".TABLE_PICTURE." WHERE username='$_username' and status='$status' AND recycle=0 AND channelid='$channelid' $addquery";
	$result=$db->query($query);
	$r=$db->fetch_array($result);
	$number=$r["num"];
	$url="?mod=picture&file=picture&action=myitem&channelid=".$channelid."&catid=".$catid."&status=".$status."&keyword=".$keyword."&ontop=".$ontop."&elite=".$elite."&ordertype=".$ordertype."&srchtype=".$srchtype."&page=".$page."&username=".$_username;
	$pages=phppages($number,$page,$pagesize,$url);
	$query="SELECT * FROM ".TABLE_PICTURE." WHERE username='$_username' and status='$status' AND recycle=0 AND channelid='$channelid' $addquery ORDER BY $dordertype LIMIT $offset,$pagesize";
	$result=$db->query($query);
	if($db->num_rows($result)>0)
	{
		while($r=$db->fetch_array($result))
		{
			$p->set_catid($r[catid]);
			$r[url] = $r[linkurl] ? $r[linkurl] : $p->get_itemurl($r[pictureid],$r[addtime]);
			$r[caturl] = $p->get_listurl(0);
	        $r[thumb] = get_imgurl($r[thumb]);
			$r[title] = titleformat($r[title],$r[titlefontcolor],$r[titlefonttype],'');
			$r[adddate]=date("Y-m-d",$r[addtime]);
			$r[addtime]=date("Y/md",$r[addtime]);
			$pictures[]=$r;
		}
	}
	include admintpl('picture_myitem');

break;

//图片审核管理
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

	$query="SELECT COUNT(*) AS num FROM ".TABLE_PICTURE." WHERE status=1 AND recycle=0 AND channelid='$channelid' $addquery";
	$result=$db->query($query);
	$r=$db->fetch_array($result);
	$number=$r["num"];
	$url="?mod=".$mod."&file=".$file."&action=check&channelid=".$channelid."&catid=".$catid."&srchtype=".$srchtype."&keyword=".$keyword."&ordertype=".$ordertype."&page=".$page;
	$pages=phppages($number,$page,$pagesize,$url);
	$query="SELECT * FROM ".TABLE_PICTURE." WHERE status=1 AND recycle=0 AND channelid='$channelid' $addquery ORDER BY $dordertype LIMIT $offset,$pagesize";
	$result=$db->query($query);
	if($db->num_rows($result)>0)
	{
		while($r=$db->fetch_array($result))
		{
			$p->set_catid($r[catid]);
			$r[url] = $r[linkurl] ? $r[linkurl] : $p->get_itemurl($r[pictureid],$r[addtime]);
			$r[caturl] = $p->get_listurl(0);
	        $r[thumb] = $r[thumb] ? (preg_match("/^http:\/\//i",$r[thumb]) ? $r[thumb] : PHPCMS_PATH.$r[thumb]) : PHPCMS_PATH."images/nopic.gif";
			$r[title] = titleformat($r[title],$r[titlefontcolor],$r[titlefonttype],'');
			$r[adddate]=date("Y-m-d",$r[addtime]);
			$r[addtime]=date("Y/md",$r[addtime]);
			$pictures[]=$r;
		}
	}	include admintpl('picture_check');

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
				$addquery=" AND title LIKE '%$keyword%' ";
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
			$dordertype=" pictureid DESC ";
		break;
		case 2:
			$dordertype=" pictureid ";
		break;
		case 3:
			$dordertype=" hits DESC ";
		break;
		case 4:
			$dordertype=" hits ";
		break;
		default :
			$dordertype=" pictureid DESC ";
	}
	$r = $db->get_one("SELECT COUNT(*) AS num FROM ".TABLE_PICTURE." a WHERE status=3 AND recycle=0 AND specialid>0 AND channelid='$channelid' $addquery");
	$number=$r["num"];
	$url="?mod=".$mod."&file=".$file."&action=special&channelid=".$channelid."&catid=".$catid."&specialid=".$specialid."&srchtype=".$srchtype."&keyword=".$keyword."&ontop=".$ontop."&elite=".$elite."&ordertype=".$ordertype."&page=".$page;
	$pages=phppages($number,$page,$pagesize,$url);
	$result=$db->query("SELECT * FROM ".TABLE_PICTURE." WHERE status=3 AND recycle=0 AND specialid>0 AND channelid='$channelid' $addquery ORDER BY $dordertype LIMIT $offset,$pagesize");
	while($r=$db->fetch_array($result))
	{
	    $s = $db->get_one("SELECT specialid,specialname,addtime FROM ".TABLE_SPECIAL." a WHERE specialid=$r[specialid]");
		$p->set_catid($r[catid]);
		$r[url] = $r[linkurl] ? $r[linkurl] : $p->get_itemurl($r[pictureid],$r[addtime]);
		$r[specialname] = wordscut($s[specialname],24,1);
		$r[specialurl] = $p->get_specialitemurl($s[specialid],$s[addtime]);
		$r[title] = titleformat($r[title],$r[titlefontcolor],$r[titlefonttype],$r[includepic]);
		$r[adddate]=date("Y-m-d",$r[addtime]);
		$pictures[]=$r;
	}
	$special_list = special_select($channelid,'specialid','请选择专题',$specialid);
	$special_select = special_select($channelid,'jump','请选择专题进行管理',$specialid,'onchange="if(this.options[this.selectedIndex].value!=\'\'){location=\'?mod='.$mod.'&file='.$file.'&action=special&channelid='.$channelid.'&specialid=\'+this.options[this.selectedIndex].value;}"');
	include admintpl('picture_special');
break;

case 'sendback':

	if($submit)
	{
		if(empty($pictureid))
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
		$db->query("UPDATE ".TABLE_PICTURE." SET status=2,elite=0,ontop=0 WHERE pictureid='$pictureid' AND channelid='$channelid'");
		showmessage('操作成功！',$referer);

	}
	else
	{
		if(empty($pictureid))
		{
			showmessage('非法参数！请返回！');
		}
		$result=$db->query("SELECT title,catid,username,status FROM ".TABLE_PICTURE." WHERE pictureid='$pictureid' AND channelid='$channelid'");
		if($db->num_rows($result)>0)
		{
			$picture=$db->fetch_array($result);
			if($picture[status]!=1)
			{
				showmessage('无法进行此操作！请返回！');
			}
		}
		else
		{
			showmessage('图片不存在！请返回！');
		}
		include admintpl('picture_sendback');
	}
break;

case 'send':

	if(empty($pictureid))
	{
		showmessage('非法参数！请返回！');
	}
	
	$result=$db->query("SELECT status FROM ".TABLE_PICTURE." WHERE pictureid='$pictureid' AND channelid='$channelid'");
	if($db->num_rows($result)>0)
	{
		$picture=$db->fetch_array($result);
		if(($picture[status]!=2) && ($picture[status]!=0))
		{
			showmessage('无法进行此操作！请返回！');
		}
		else
		{
			$db->query("UPDATE ".TABLE_PICTURE." SET status=1 WHERE pictureid='$pictureid' AND channelid='$channelid'");
			showmessage('操作成功！',$referer);
		}
	}
	else
	{
		showmessage('图片不存在！请返回！',$referer);
	}
break;

//移动图片
case 'move':
	if($submit)
	{
		$specialid = intval($specialid);
		$targetcatid = intval($targetcatid);
		if(!$specialid && !$targetcatid) showmessage('非法参数！请返回！');
		if($targetcatid && $_CAT[$targetcatid]['child'] && !$_CAT[$targetcatid]['enableadd']) showmessage('指定栏目不允许添加文章！请返回！');

		if($movetype==1)
		{
			if(empty($pictureid)) showmessage('非法参数！请返回！');
			$pictureids=is_array($pictureid) ? implode(',',$pictureid) : $pictureid;
			if($specialid) $db->query("UPDATE ".TABLE_PICTURE." SET specialid='$specialid' WHERE pictureid IN ($pictureids) AND status=3 AND channelid='$channelid' ");
			if($targetcatid) $db->query("UPDATE ".TABLE_PICTURE." SET catid='$targetcatid' WHERE pictureid IN ($pictureids) AND status=3 AND channelid='$channelid' ");
		}
		else
		{
			if(empty($batchcatid)) showmessage('非法参数！请返回！');
			$batchcatids=implode(",",$batchcatid);
			if($specialid) $db->query("UPDATE ".TABLE_PICTURE." SET specialid='$specialid' WHERE catid IN ($batchcatids) AND status=3 AND channelid='$channelid' ");
			if($targetcatid) $db->query("UPDATE ".TABLE_PICTURE." SET catid='$targetcatid' WHERE catid IN ($batchcatids) AND status=3 AND channelid='$channelid' ");
		}
		showmessage('操作成功！',$referer);
	}
	else
	{
		$referer=urlencode('?mod='.$mod.'&file='.$file.'&action=move&channelid='.$channelid);
		$pictureid=is_array($pictureid) ? implode(',',$pictureid) : $pictureid;
		$special_select = special_select($channelid,'specialid','请选择专题',$specialid);
		include admintpl('picture_move');
	}
break;

//回收站管理
case 'recycle':

	@extract($db->get_one("SELECT COUNT(*) AS num_3 FROM ".TABLE_PICTURE." WHERE status=3 AND username='$_username' AND recycle=1 AND channelid='$channelid'"));
	@extract($db->get_one("SELECT COUNT(*) AS num_1 FROM ".TABLE_PICTURE." WHERE status=1 AND username='$_username' AND recycle=1 AND channelid='$channelid'"));
	@extract($db->get_one("SELECT COUNT(*) AS num_0 FROM ".TABLE_PICTURE." WHERE status=0 AND username='$_username' AND recycle=1 AND channelid='$channelid'"));
	@extract($db->get_one("SELECT COUNT(*) AS num_2 FROM ".TABLE_PICTURE." WHERE status=2 AND username='$_username' AND recycle=1 AND channelid='$channelid'"));

	$referer=urlencode("?mod=picture&file=picture&action=recycle&channelid=".$channelid."&catid=".$catid."&status=".$status."&page=".$page);
	$catid=$catid ? $catid : 0;
    if(isset($status)) $status = intval($status);
	$sqlstatus = isset($status) ? " AND status=$status " : "";
	$thecatid=$catid;
	if(!$page)
	{
		$page=1;
		$offset=0;
	}
	else
	{
		$offset=($page-1)*$pagesize;
	}
	$query="SELECT COUNT(*) as num FROM ".TABLE_PICTURE." WHERE recycle=1 AND channelid='$channelid' $sqlstatus $addquery";
	$result=$db->query($query);
	$r=$db->fetch_array($result);
	$number=$r["num"];	$url="?mod=picture&file=picture&action=recycle&channelid=".$channelid."&catid=".$catid."&status=".$status."&keyword=".$keyword."&ontop=".$ontop."&elite=".$elite."&ordertype=".$ordertype."&srchtype=".$srchtype."&page=".$page."&submit=1";
	$pages=phppages($number,$page,$pagesize,$url);
	$query="SELECT * FROM ".TABLE_PICTURE." WHERE recycle=1 AND channelid='$channelid' $sqlstatus $addquery ORDER BY $dordertype LIMIT $offset,$pagesize";
	$result=$db->query($query);
	if($db->num_rows($result)>0)
	{
		while($r=$db->fetch_array($result))
		{
			$p->set_catid($r[catid]);
			$r[url] = $r[linkurl] ? $r[linkurl] : $p->get_itemurl($r[pictureid],$r[addtime]);
			$r[caturl] = $p->get_listurl(0);
	        $r[thumb] = $r[thumb] ? (preg_match("/^http:\/\//i",$r[thumb]) ? $r[thumb] : PHPCMS_PATH.$r[thumb]) : PHPCMS_PATH."images/nopic.gif";
			$r[title] = titleformat($r[title],$r[titlefontcolor],$r[titlefonttype],'');
			$r[adddate]=date("Y-m-d",$r[addtime]);
			$r[addtime]=date("Y/md",$r[addtime]);
			$pictures[]=$r;
		}
	}
	include admintpl('picture_recycle');

break;

//浏览图片
case 'preview':
	if(!ereg('^[0-9]+$',$pictureid))
	{
		showmessage('非法参数！请返回！'); 
	}
	$result=$db->query("SELECT * FROM ".TABLE_PICTURE." WHERE pictureid=$pictureid");
	if($db->num_rows($result)==0)
	{
		showmessage('对不起，该图片不存在！请返回！'); 
	}
	$picture=$db->fetch_array($result);
	$picture[title] = titleformat($picture[title],$picture[titlefontcolor],$picture[titlefonttype],'');
	$picture[adddate] = date('Y-m-d',$picture[addtime]);
	$picture[addtime] = date('Y/md',$picture[addtime]);
	$picture[thumb] = get_imgurl($picture[thumb]);
	$picture[url] = $picture[linkurl] ? $picture[linkurl] : $p->get_itemurl($picture[pictureid],$picture[addtime]);
	$p->set_catid($picture[catid]);
	$picture[catdir] = $p->get_listurl(0);
    $pictureurls = trim($picture[pictureurls]);  
	$urls = explode("\n",$pictureurls);
	$urls = array_map("trim",$urls);
	$pictureurls = array();
	foreach($urls as $k=>$v)
	{
		$pictureurl = explode("|",$v);
		$pictureurl['name'] = $pictureurl[0];
		$pictureurl['url'] = get_imgurl($pictureurl[1]);
		$pictureurls[] = $pictureurl;
	}
	include admintpl('picture_preview');
break;

case 'specialout':

	if(empty($pictureid)) showmessage('非法参数！请返回！');

	$pictureids=is_array($pictureid) ? implode(',',$pictureid) : $pictureid;
	$db->query("UPDATE ".TABLE_PICTURE." SET specialid=0 WHERE pictureid IN ($pictureids) AND channelid='$channelid'");
	if($db->affected_rows()>0)
	{
		showmessage('操作成功！',$referer);
	}
	else
	{
		showmessage('操作失败！请返回！');
	}
break;

//推举图片
case 'elite':

	if(empty($pictureid))
	{
		showmessage('非法参数！请返回！');
	}
	if(!ereg('^[0-1]+$',$value))
	{
		showmessage('非法参数！请返回！');
	}
	$pictureids=is_array($pictureid) ? implode(',',$pictureid) : $pictureid;
	$db->query("UPDATE ".TABLE_PICTURE." SET elite='$value' WHERE pictureid IN ($pictureids) AND channelid='$channelid'");
	if($db->affected_rows()>0)
	{
		showmessage('操作成功！',$referer);
	}
	else
	{
		showmessage('操作失败！请返回！');
	}
break;

//至顶图片
case 'ontop':

	if(empty($pictureid))
	{
		showmessage('非法参数！请返回！');
	}
	if(!ereg('^[0-1]+$',$value))
	{
		showmessage('非法参数！请返回！');
	}
	$pictureids=is_array($pictureid) ? implode(',',$pictureid) : $pictureid;
	$db->query("UPDATE ".TABLE_PICTURE." SET ontop='$value' WHERE pictureid IN ($pictureids) AND channelid='$channelid'");
	if($db->affected_rows()>0)
	{
		showmessage('操作成功！',$referer);
	}
	else
	{
		showmessage('操作失败！请返回！');
	}
break;

//放入回收箱
case 'torecycle':

	if(empty($pictureid)) showmessage('非法参数！请返回！');
	if(!ereg('^[0-1]+$',$value)) showmessage('非法参数！请返回！');

	if($_grade==4) $condition = " AND username='$_username' AND status<3";
	if($_grade==5) $condition = " AND status<3";
	$pictureids=is_array($pictureid) ? implode(',',$pictureid) : $pictureid;
	$result = $db->query("SELECT catid,recycle,username FROM ".TABLE_PICTURE." WHERE pictureid IN ($pictureids) AND channelid='$channelid'");
	while($r = $db->fetch_array($result))
	{
		$credit = $r['recycle'] < $value ? -$_CAT[$r['catid']]['creditget'] : ($r['recycle'] > $value ? $_CAT[$r['catid']]['creditget'] : 0);
		if($credit!=0) credit_add($r['username'],$credit);
	}
	$db->query("UPDATE ".TABLE_PICTURE." SET recycle='$value' WHERE pictureid IN ($pictureids) AND channelid='$channelid' $condition ");
	if($db->affected_rows()>0)
	{
		tohtml("index");
        tohtml("index",PHPCMS_ROOT);
		if($view==1){
			$referer="?mod=".$mod."&file=".$file."&action=check&channelid=".$channelid."&catid=".$catid."&srchtype=".$srchtype."&keywords=".$keywords."&ordertype=".$ordertype."&page=".$page;
		}
		showmessage('操作成功！',$referer);
	}
	else
	{
		showmessage('操作失败！请返回！');
	}
break;

//通过文章
case 'pass':

    if(empty($pictureid)) showmessage('非法参数！请返回！');

	$pictureids = is_array($pictureid) ? implode(',',$pictureid) : $pictureid;
	$result = $db->query("SELECT pictureid,catid,specialid,status,username FROM ".TABLE_PICTURE." WHERE pictureid IN ($pictureids) AND channelid='$channelid'");
	while($r = $db->fetch_array($result))
	{
		$info[$r[pictureid]] = $r;
		if($r['status']<3) credit_add($r['username'],$_CAT[$r['catid']]['creditget']);
	}
	$db->query("UPDATE ".TABLE_PICTURE." SET checker='$_username',checktime='$timestamp',status=3 WHERE pictureid IN ($pictureids) AND channelid='$channelid'");
	if($db->affected_rows()>0)
	{
		if(is_array($pictureid))
		{
			$arrpictureid = $pictureid;
			foreach($arrpictureid as $pictureid)
			{
				tohtml("picture");
                @extract($info[$pictureid]);
                include PHPCMS_ROOT."/include/updatewithinfo.php";
			}
		}
		else
		{
			tohtml("picture");
            @extract($info[$pictureid]);
            include PHPCMS_ROOT."/include/updatewithinfo.php";
		}
		showmessage('操作成功！',$referer);
	}
	else
	{
		showmessage('操作失败！请返回！');
	}
break;

//从回收箱，还原所有
case 'restoreall':

	if(empty($pictureid)) showmessage('非法参数！请返回！');
	if(!ereg('^[0-1]+$',$value)) showmessage('非法参数！请返回！');

	if($_grade==4) $condition = " AND username='$_username' AND status<3";
	if($_grade==5) $condition = " AND status<3";
	$pictureids=is_array($pictureid) ? implode(',',$pictureid) : $pictureid;
	$result = $db->query("SELECT catid,recycle,username FROM ".TABLE_PICTURE." WHERE pictureid IN ($pictureids) AND channelid='$channelid'");
	while($r = $db->fetch_array($result))
	{
		$credit = $r['recycle'] < $value ? -$_CAT[$r['catid']]['creditget'] : ($r['recycle'] > $value ? $_CAT[$r['catid']]['creditget'] : 0);
		if($credit!=0) credit_add($r['username'],$credit);
	}
	$query="UPDATE ".TABLE_PICTURE." SET recycle=0 WHERE recycle=1 AND channelid='$channelid'";
	$db->query($query);
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

//彻底删除，按ID
case 'delete':
	if(empty($pictureid)) showmessage('非法参数！请返回！');
	$pictureids = is_array($pictureid) ? implode(',',$pictureid) : $pictureid;
	$result = $db->query("SELECT pictureid,catid,addtime,thumb,pictureurls FROM ".TABLE_PICTURE." WHERE pictureid IN ($pictureids) AND channelid='$channelid'");
	while($r = $db->fetch_array($result))
	{
		if($r[thumb] && !preg_match("|://|",$r[thumb])) @$f->unlink($r[thumb]);
		attach_del($r[pictureurls]);
		if($_CHA['htmlcreatetype'])
		{
			$p->set_type("path");
			$p->set_catid($r[catid]);
			$filename = $p->get_itemurl($r[pictureid],$r[addtime]);
			@$f->unlink($filename);
		}
	}
	$db->query("DELETE FROM ".TABLE_PICTURE." WHERE pictureid IN ($pictureids) AND channelid='$channelid'");
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

//彻底删除，删除所有
case 'deleteall':
	$result = $db->query("SELECT pictureid,catid,addtime,thumb,pictureurls FROM ".TABLE_PICTURE." WHERE recycle='1' AND channelid='$channelid'");
	while($r = $db->fetch_array($result))
	{
		if($r[thumb] && !preg_match("|://|",$r[thumb])) @$f->unlink($r[thumb]);
		attach_del($r[pictureurls]);
		if($_CHA['htmlcreatetype'])
		{
			$p->set_type("path");
			$p->set_catid($r[catid]);
			$filename = $p->get_itemurl($r[pictureid],$r[addtime]);
			@$f->unlink($filename);
		}
	}
	$db->query("delete from ".TABLE_PICTURE." where recycle='1' and channelid='$channelid'");
	if($db->affected_rows()>0)
	{
		tohtml("index");
		tohtml("index",PHPCMS_ROOT);
		showmessage('清空回收站操作成功！',$referer);
	}
	else
	{
		showmessage('操作失败，请返回！');
	}
break;
}

?>