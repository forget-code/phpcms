<?php 
/*
*######################################
* PHPCMS v3.0.0 - Advanced Content Manage System.
* Copyright (c) 2004-2005 phpcms.cn
*
* For further information go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*######################################
*/
defined('IN_PHPCMS') or exit('Access Denied');

$channelid = intval($channelid);
if(!$channelid) showmessage('非法参数！请返回！',$referer);

$referer	=	$referer ? $referer : $_SERVER["HTTP_REFERER"];
$action		=	$action ? $action : 'manage';

$menus=array(
	array("<font color='red'>添加下载</font>", "?mod=".$mod."&file=".$file."&action=add&channelid=".$channelid.'&catid='.$catid.'&specialid='.$specialid),
	array("审核下载", "?mod=".$mod."&file=".$file."&action=check&channelid=".$channelid.'&catid='.$catid.'&specialid='.$specialid),
	array("<font color='red'>管理下载</font>", "?mod=".$mod."&file=".$file."&action=manage&channelid=".$channelid.'&catid='.$catid.'&specialid='.$specialid),
	array("我添加的下载", "?mod=".$mod."&file=".$file."&action=myitem&channelid=".$channelid.'&catid='.$catid.'&specialid='.$specialid),
	array('<font color="red">管理专题下载</font>','?mod='.$mod.'&file='.$file.'&action=special&channelid='.$channelid.'&catid='.$catid.'&specialid='.$specialid),
	array("批量移动下载", "?mod=".$mod."&file=".$file."&action=move&channelid=".$channelid.'&catid='.$catid.'&specialid='.$specialid),
	array("回收站", "?mod=".$mod."&file=".$file."&action=recycle&channelid=".$channelid.'&catid='.$catid.'&specialid='.$specialid)
);

$downmenu = adminmenu('下载管理',$menus);

$tree		=	new tree;

$script="onchange=\"if(this.options[this.selectedIndex].value!=''){location='?mod=".$mod."&file=".$mod."&action=".$action."&catid=".$catid."&channelid=".$channelid."&catid='+this.options[this.selectedIndex].value;}\"";
$cat_jump	=	cat_select('catid','请选择栏目进行管理',$catid,$script);
$cat_pos	=	cat_pos($catid);
$cats_num = count($_CAT);
$condition = " and channelid='$channelid' ";
$cat_serach	=	cat_select('catid','请选择栏目',$catid);

if($ontop==1)
{		   
	$condition.=" and ontop=1 ";
	$iftop=0;
	$topinfo='取消置顶';
}
elseif($ontop==0)
{
	$iftop=1;
	$topinfo='置顶';
}

$topurl = changeurl("ontop",$iftop);
$topcheckded = ($ontop==1) ? ' checked="checked" ' : '';

if($elite==1)
{
	$condition.=" and elite=1 ";
	$ifelite=0;
	$eliteinfo="取消推荐";
}
elseif($elite==0)
{
	$ifelite=1;		
	$eliteinfo="推荐";
}
$eliteurl = changeurl("elite",$ifelite);
$elitecheckded=($elite==1) ? ' checked="checked" ' : '';
//======================================== 推荐
$fieldtypes=array('title','introduce','username','checker','editor');
$ordertypes=array('addtime desc','addtime asc','edittime desc','edittime asc','hits desc','hits asc');

switch($action)
{	
	//添加下载
	case 'add':
		if(!is_array($_CAT)) showmessage("请先添加栏目！","?mod=phpcms&file=category&action=add&channelid=".$channelid);
		
		if($submit)
		{
			if($_grade==4 && $status==3) showmessage("您没有权限！");

			$ontop=$elite=$recycle=$error=$errortimes=0;
			$groupview	=is_array($groupid_box) ? implode(',',$groupid_box) : $groupid_box;
			//提交字段判断
			if(!$catid)	showmessage('请选择栏目！请返回！');
			if($_CAT[$catid][child] && !$_CAT[$catid][enableadd]) showmessage('指定栏目不允许添加下载！请返回！');
			if(!$title)	showmessage('请填写标题！请返回！');
			if(!$linkurl && !$introduce)	showmessage('请填写内容！请返回！');
			if(!$linkurl && !$downurls) showmessage('下载地址不能为空！请返回！');
			//更新关键字
			if($addkeywords && !empty($keywords))
			{
				$keywords_input = explode(",", $keywords);
				foreach($keywords_input as $keyword)
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
			$db->query("insert into ".TABLE_DOWN."(channelid,catid,specialid,title,titlefontcolor,titlefonttype,keywords,author,copyfromname,copyfromurl,linkurl,username,addtime,checker,checktime,editor,edittime,introduce,status,thumb,filesize,downurls,skinid,templateid,ontop,elite,stars,readpoint,groupview) values('$channelid','$catid','$specialid','$title','$titlefontcolor','$titlefonttype','$keywords','$author','$copyfromname','$copyfromurl','$linkurl','$_username','$timestamp','','','','$timestamp','$introduce','$status','$thumb','$filesize','$downurls','$skinid','$templateid','$ontop','$elite','$stars','$readpoint','$groupview')");
			$downid = $db->insert_id();
		    field_update($channelid,"downid=$downid");
			if($status==3)
			{
				credit_add($_username,$_CAT[$catid]['creditget']);
				tohtml("down");
                include PHPCMS_ROOT."/include/updatewithinfo.php";
			}
			showmessage('操作成功！',$referer);
		}
		else
		{
			$headtitle='添加'.$_CHA['channelname'];

			foreach( $_CAT as $key=>$val)
			{
				$cats.="arr[".$key."]=".$val['defaultpoint'].";\n";
			}
			//关键字，作者，来源
			$keyword_select		= keyword_select($channelid);
			$author_select		= author_select($channelid,'author_sel','onchange="author.value=this.value;"');
			$copyfrom_select	= copyfrom_select($channelid);
			$cat_select = cat_select('catid','请选择栏目',$catid,"onchange=\"setff(this.value)\"");
			$special_select = special_select($channelid,'specialid','不属于任何专题',$specialid);
			$skin_select	= showskin('skinid',$skinid);
			$tpl_select		= showtpl($mod,'content','templateid',$templateid);
			$fontcolor_select=color_select('titlefontcolor','颜色',$titlefontcolor);
			$fonttype_select	=fonttype_select('titlefonttype','字形',$titlefonttype);
			$fields = field_input($channelid,"tablerow");
			$upfile_size=	intval($_CHA['maxfilesize']/1024);
			$group_box=showgroup('checkbox','groupid_box[]');

			include admintpl('down_add');
		}
    break;

	 //编辑下载
	case 'edit':
		$headtitle='编辑'.$_CHA['channelname'];
		if($submit)
		{
			if($_grade==4 && $status==3) showmessage("您没有权限！");
			$groupview	=is_array($groupid_box) ? implode(',',$groupid_box) : $groupid_box;
			
			//提交字段判断
			if(!$catid)	showmessage('请选择栏目！请返回！');
			if($_CAT[$catid][child] && !$_CAT[$catid][enableadd]) showmessage('指定栏目不允许添加下载！请返回！');
			if(!$title)	showmessage('请填写标题！请返回！');
			if(!$linkurl && !$introduce)	showmessage('请填写内容！请返回！');
			if(!$linkurl && !$downurls) showmessage('下载地址不能为空！请返回！');
			//更新关键字
			if($addkeywords && !empty($keywords))
			{
				$keywords_input = explode(",", $keywords);
				foreach($keywords_input as $keyword)
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
			$db->query("update ".TABLE_DOWN." set catid='$catid',specialid='$specialid',title='$title',titlefontcolor='$titlefontcolor',titlefonttype='$titlefonttype',keywords='$keywords',author='$author',copyfromname='$copyfromname',copyfromurl='$copyfromurl',linkurl='$linkurl',editor='$_username',edittime='$timestamp',introduce='$introduce',status='$status',thumb='$thumb',filesize='$filesize',downurls='$downurls',skinid='$skinid',templateid='$templateid',ontop='$ontop',elite='$elite',stars='$stars',readpoint='$readpoint',groupview='$groupview' where downid='$downid' limit 1");
			field_update($channelid,"downid=$downid");
			if($status==3)
			{
				tohtml("down");
                include PHPCMS_ROOT."/include/updatewithinfo.php";
			}
			showmessage('操作成功！',$referer);
		}
		else
		{
			if($_grade>3 && $status==3) showmessage("您没有权限！");
			if(!$downid) showmessage("参数错误！");
			$upfile_size=	intval($_CHA['maxfilesize']/1024);
			$r = $db->get_one("select * from  ".TABLE_DOWN." where downid='$downid'");
			if(!$r['downid']) showmessage("参数错误！");

		    @extract(dhtmlspecialchars($r));

			//实现自动添加点数
			foreach( $_CAT as $key=>$val)
			{
				$cats.="arr[".$key."]=".$val['defaultpoint'].";\n";
			}
			$cat_select		= cat_select('catid','请选择栏目',$catid,"onchange=\"setff(this.value)\"");
			$special_select = special_select($channelid,'specialid','不属于任何专题',$specialid);
			$skin_select	= showskin('skinid',$skinid);
			$tpl_select		= showtpl($mod,'content','templateid',$templateid);
			$fontcolor_select=color_select('titlefontcolor','颜色',$titlefontcolor);
			$fonttype_select=fonttype_select('titlefonttype','字形',$titlefonttype);
			$group_box = showgroup('checkbox','groupid_box[]',$groupview);
			//关键字，作者，来源
			$keyword_select		= keyword_select($channelid);
			$author_select		= author_select($channelid,'author_sel','onchange="author.value=this.value;"');
			$copyfrom_select	= copyfrom_select($channelid);
    		$fields = field_input($channelid,"tablerow");
			$downurls = explode("\n",$downurls);
			$downurls = array_map("trim",$downurls);
			include admintpl('down_edit');
		}
	break;

	case 'checktitle':
		if(empty($title)) $error_msg='标题不能为空！请返回！';
		$result=$db->query("SELECT downid,catid,title,addtime FROM ".TABLE_DOWN." WHERE status=3 AND recycle=0 AND channelid=$channelid AND title LIKE '%$title%' ORDER BY downid");
		while($r=$db->fetch_array($result))
		{
		    $p->set_catid($r[catid]);
			$r[url] = $p->get_itemurl($r[downid],$r[addtime]);
			$r[adddate]=date("m-d",$r[addtime]);
			$downs[]=$r;
		}
		include admintpl('down_checktitle');
	break;

	//从数据库删除
	case 'delete':
		if(empty($downid)) showmessage('非法参数！请返回！');
		$downids = is_array($downid) ? implode(',',$downid) : $downid;
		$result = $db->query("SELECT downid,catid,addtime,thumb,downurls FROM ".TABLE_DOWN." WHERE downid IN ($downids) AND channelid='$channelid'");
		while($r = $db->fetch_array($result))
		{
		    if($r[thumb] && !preg_match("|://|",$r[thumb])) @$f->unlink($r[thumb]);
			attach_del($r[downurls]);
			if($_CHA['htmlcreatetype'])
			{
				$p->set_type("path");
			    $p->set_catid($r[catid]);
				$filename = $p->get_itemurl($r[downid],$r[addtime]);
				@$f->unlink($filename);
			}
		}
		$db->query("DELETE FROM ".TABLE_DOWN." WHERE downid IN ($downids) AND channelid='$channelid'");
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

	//清空回收站
	case 'deleteall':
		$result = $db->query("SELECT downid,catid,addtime,thumb,downurls FROM ".TABLE_DOWN." WHERE recycle='1' AND channelid='$channelid'");
		while($r = $db->fetch_array($result))
		{
		    if($r[thumb] && !preg_match("|://|",$r[thumb])) @$f->unlink($r[thumb]);
			attach_del($r[downurls]);
			if($_CHA['htmlcreatetype'])
			{
				$p->set_type("path");
			    $p->set_catid($r[catid]);
				$filename = $p->get_itemurl($r[downid],$r[addtime]);
				@$f->unlink($filename);
			}
		}
		$db->query("delete from ".TABLE_DOWN." where recycle='1' and channelid='$channelid'");
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

	//置顶
	case 'ontop':
		$value=$value?intval($value):0;
		$downids=is_array($downid) ? implode(",",$downid) : $downid;
		if(empty($downids))
		{
			showmessage('请选择要操作的项目！');
		}
		if(!ereg('^[0-1]+$',$value))
		{
			showmessage('非法参数，请返回！');
		}
		$db->query("update ".TABLE_DOWN." set ontop='$value' where downid in ($downids)");
		$msg = $value==1 ? '置顶操作成功！' : '取消置顶操作成功！';
		if($db->affected_rows()>0)
		{
			showmessage($msg,$referer);
		}
		else
		{
			showmessage('操作失败，请返回！');
		}
	break;

	//推荐
	case 'elite':
		$value=$value?intval($value):0;
		$downids=is_array($downid) ? implode(",",$downid) : $downid;
		if(empty($downids))
		{
			showmessage('请选择要操作的项目！');
		}
		if(!ereg('^[0-1]+$',$value))
		{
			showmessage('非法参数，请返回！');
		}
		$sql="update ".TABLE_DOWN." set elite='$value' where downid in ($downids)";
		$query=$db->query($sql);
		$msg=($value==1) ? '推荐操作成功！' : '取消推荐操作成功！';
		if($query)
		{
			showmessage($msg,$referer);
		}
		else
		{
			showmessage('操作失败，请返回！');
		}
	break;

	case 'pass':

		if(empty($downid)) showmessage('非法参数！请返回！');

		$downids = is_array($downid) ? implode(',',$downid) : $downid;
		$result = $db->query("SELECT downid,catid,specialid,status,username FROM ".TABLE_DOWN." WHERE downid IN ($downids) AND channelid='$channelid'");
		while($r = $db->fetch_array($result))
		{
		    $info[$r[downid]] = $r;
			if($r['status']<3) credit_add($r['username'],$_CAT[$r['catid']]['creditget']);
		}
		$db->query("UPDATE ".TABLE_DOWN." SET checker='$_username',checktime='$timestamp',status=3 WHERE downid IN ($downids) AND channelid='$channelid'");
		if($db->affected_rows()>0)
		{
			if(is_array($downid))
			{
				$arrdownid = $downid;
				foreach($arrdownid as $downid)
				{
					tohtml("down");
                    @extract($info[$downid]);
                    include PHPCMS_ROOT."/include/updatewithinfo.php";
				}
			}
			else
			{
				tohtml("down");
                @extract($info[$downid]);
                include PHPCMS_ROOT."/include/updatewithinfo.php";
			}
			showmessage('操作成功！',$referer);
		}
		else
		{
			showmessage('操作失败！请返回！');
		}
	break;

	case 'specialout':

		if(empty($downid)) showmessage('非法参数！请返回！');

		$downids=is_array($downid) ? implode(',',$downid) : $downid;
		$db->query("UPDATE ".TABLE_DOWN." SET specialid=0 WHERE downid IN ($downids) AND channelid='$channelid'");
		if($db->affected_rows()>0)
		{
			showmessage('操作成功！',$referer);
		}
		else
		{
			showmessage('操作失败！请返回！');
		}
	break;

	//投稿
	case 'send':
		if(empty($downid))
		{
			showmessage('非法参数，请返回！');
		}
		$db->query("update ".TABLE_DOWN." set status='1' where downid='$downid' and (status='0' or status='2') and channelid='$channelid'");
		if($db->affected_rows()>0)
			showmessage('投稿成功！',$referer);
		else
			showmessage('信息不存在，请返回！',$referer);
	break;

	//退稿
	case 'sendback':
		$headtitle=$_CHA['channelname']."退稿";
		if($submit)
		{
			if(empty($downid))
			{
				showmessage('请选择要操作的项目！');
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
			$sql="update ".TABLE_DOWN." set status='2',elite=0,ontop=0 where downid='$downid' and channelid='$channelid'";
			$query=$db->query($sql);
			if($query)
			{
				showmessage('退稿成功！',$referer);
			}
			else
			{
				showmessage('操作失败，请返回！');
			}
		}
		else
		{
			if(empty($downid))
			{
				showmessage('非法参数！请返回！');
			}
			$result=$db->query("select title,catid,username,status from ".TABLE_DOWN." where downid='$downid' and status='1' and channelid='$channelid'");
			if($db->num_rows($result)>0)
			{
				$down=$db->fetch_array($result);
			}
			else
			{
				showmessage('信息不存在！请返回！');
			}
			include admintpl('down_sendback');
		}
	break;
	
	//删除或者还原到回收站
	case 'torecycle':
		if(empty($downid)) showmessage('非法参数！请返回！');
		if(!ereg('^[0-1]+$',$value)) showmessage('非法参数！请返回！');

		if($_grade==4) $condition = " AND username='$_username' AND status<3";
		if($_grade==5) $condition = " AND status<3";
		$downids=is_array($downid) ? implode(',',$downid) : $downid;
		$result = $db->query("SELECT catid,recycle,username FROM ".TABLE_DOWN." WHERE downid IN ($downids) AND channelid='$channelid'");
		while($r = $db->fetch_array($result))
		{
			$credit = $r['recycle'] < $value ? -$_CAT[$r['catid']]['creditget'] : ($r['recycle'] > $value ? $_CAT[$r['catid']]['creditget'] : 0);
			if($credit!=0) credit_add($r['username'],$credit);
		}
	    $db->query("update ".TABLE_DOWN." set recycle='$value' where downid in ($downids) and channelid='$channelid'");
		if($db->affected_rows()>0)
		{
			tohtml("index");
			tohtml("index",PHPCMS_ROOT);
			showmessage('操作成功！',$referer);
		}
		else
		{
			showmessage('操作失败，请返回！');
		}
	break;

	//还原所有
	case 'restoreall':
		if(empty($downid)) showmessage('非法参数！请返回！');
		if(!ereg('^[0-1]+$',$value)) showmessage('非法参数！请返回！');

		if($_grade==4) $condition = " AND username='$_username' AND status<3";
		if($_grade==5) $condition = " AND status<3";
		$downids=is_array($downid) ? implode(',',$downid) : $downid;
		$result = $db->query("SELECT catid,recycle,username FROM ".TABLE_DOWN." WHERE downid IN ($downids) AND channelid='$channelid'");
		while($r = $db->fetch_array($result))
		{
			$credit = $r['recycle'] < $value ? -$_CAT[$r['catid']]['creditget'] : ($r['recycle'] > $value ? $_CAT[$r['catid']]['creditget'] : 0);
			if($credit!=0) credit_add($r['username'],$credit);
		}
		$db->query("update ".TABLE_DOWN." set recycle='0' where recycle='1' and channelid='$channelid'");
		if($db->affected_rows()>0)
		{
			tohtml("index");
			tohtml("index",PHPCMS_ROOT);
			showmessage('操作成功！',$referer);
		}
		else
		{
			showmessage('操作失败，请返回！');
		}
	break;
		
	//回收站
	case 'recycle':
		$condition.=" and recycle='1' ";
		$headtitle=$_CHA['channelname'].'回收站管理';
		$noinfo="恭喜您，回收站没有任何垃圾信息。";
		
		if(ereg('^[013]+$',$value))
		{
			$condition.=" and status='$value'";
		}
		@extract($db->get_one("select count(downid) as num_0 from ".TABLE_DOWN." where status=0 ". $condition));
		@extract($db->get_one("select count(downid) as num_1 from ".TABLE_DOWN." where status=1 ". $condition));
		@extract($db->get_one("select count(downid) as num_2 from ".TABLE_DOWN." where status=2 ". $condition));
		@extract($db->get_one("select count(downid) as num_3 from ".TABLE_DOWN." where status=3 ". $condition));

		//分页
		$pagesize=$_PHPCMS['down_admin_pagesize']>1?$_PHPCMS['down_admin_pagesize']:10;
		if(!$page)
		{
			$page=1;
			$offset=0;
		}
		else
		{
			$offset=($page-1)*$pagesize;
		}	
		
		//查询条件
		if($catid) $condition.=" and catid='$catid' ";
		if(in_array($field,$fieldtypes) && $keywords)  $condition.=" and $field like '%$keywords%'";
		
		if(!isset($order))
		{
			$condition.=" order by addtime desc ";
		}else
		{		
			if($order && in_array($order,$ordertypes)) $condition.=" order by $order ";
		}

		$r = $db->get_one("select count(downid) as num from ".TABLE_DOWN." where 1 $condition ");
		$pages=phppages($r["num"],$page,$pagesize);

		$query = $db->query("select * from  ".TABLE_DOWN." where 1 ".$condition." limit $offset,$pagesize ");
		if($db->num_rows($query))
		{
			$i=0;
			$p->set_type("url");
			while($r=$db->fetch_array($query))
			{
				//生成页面路径对象
				$p->set_catid($r[catid]);
		        $r[url] = $r[linkurl] ? $r[linkurl] : $p->get_itemurl($r[downid],$r[addtime]);
				$r['addtime']=date("Y-m-d",$r['addtime']);
				$r['username']=$r['username']	?$r['username']:'[未知]';
				$r['property']=$r['ontop'] ? '<font color="red">顶</font> ':'';
				$r['property'].=$r['elite'] ? '<font color="red">荐</font>':'';
				$r['caturl'] = $p->get_listurl(0);
				$r['catname']=$_CAT[$r['catid']]['catname'];
				$r['atitle']=$r['title'];
				$r['title'] = titleformat($r['title'],$r['titlefontcolor'],$r['titlefonttype'],$r['includepic']);
				if($r['thumb'])	$r['title']='<font color="red">[图]</font> '.$r['title'];
				$i++;
				$downs[]=$r;
			}
		}
		include admintpl('down_recycle');
	
	break;

	//审核下载
	case 'check':

		$condition .= " and status='1' and recycle='0'";
		$headtitle = $_CHA['channelname']."审核管理";
		$noinfo = "无待审核信息！";
		//分页
		$pagesize = $_PHPCMS['pagesize'] ? $_PHPCMS['pagesize'] : 20;
		if(!$page)
		{
			$page=1;
			$offset=0;
		}
		else
		{
			$offset=($page-1)*$pagesize;
		}
				
		//查询条件
		if($catid) $condition .= " and catid='$catid' ";
		if(in_array($field,$fieldtypes) && $keywords)  $condition.=" and $field like '%$keywords%'";
		
		if(!isset($order))
		{
			$condition.=" order by addtime desc ";
		}else
		{		
			if($order && in_array($order,$ordertypes)) $condition.=" order by $order ";
		}

		$r = $db->get_one("select count(downid) as num from ".TABLE_DOWN." where 1 $condition");
		$pages = phppages($r["num"],$page,$pagesize);

		$query = $db->query("select * from  ".TABLE_DOWN." where 1 ".$condition." limit $offset,$pagesize ");
		if($db->num_rows($query))
		{
			$p->set_type("url");
			while($r=$db->fetch_array($query))
			{
				//生成页面路径对象
				$p->set_catid($r[catid]);
				$p->htmlcreatetype = 0;
		        $r[url] = $r[linkurl] ? $r[linkurl] : $p->get_itemurl($r[downid],$r[addtime]);
				$r['addtime']=date("Y-m-d",$r['addtime']);
				$r['username']=$r['username'] ? $r['username']:'[未知]';
				$r['property']=$r['ontop'] ? '<font color="red">顶</font> ':'';
				$r['property'].=$r['elite'] ? '<font color="blue">荐</font>':'';
				$r['caturl'] = $p->get_listurl(0);
				$r['catname']=$_CAT[$r['catid']]['catname'];
				$r['atitle']=$r['title'];
				$r['title'] = titleformat($r['title'],$r['titlefontcolor'],$r['titlefonttype'],$r['includepic']);
				if($r['thumb'])	$r['title']='<font color="red">[图]</font> '.$r['title'];
				$downs[]=$r;
			}
		}

		include admintpl('down_check');
	break;

	case 'special':
		$referer = urlencode("?".$PHP_QUERYSTRING);
		//分页
		$pagesize = $_PHPCMS['down_admin_pagesize']>1 ? $_PHPCMS['down_admin_pagesize'] : 20;
		if(!$page)
		{
			$page=1;
			$offset=0;
		}
		else
		{
			$offset=($page-1)*$pagesize;
		}
				
		//查询条件
		if($catid) $condition.=" and catid='$catid' ";
		$condition .= $specialid ? " and specialid=$specialid " : "";
		if(in_array($field,$fieldtypes) && $keywords)  $condition.=" and $field like '%$keywords%'";
		
		if(!isset($order))
		{
			$condition.=" order by addtime desc ";
		}else
		{		
			if($order && in_array($order,$ordertypes) )
				$condition.=" order by $order ";
		}

		$r = $db->get_one("SELECT COUNT(*) AS num FROM ".TABLE_DOWN." WHERE status=3 AND recycle=0 AND specialid>0 $condition");
		$pages = phppages($r["num"],$page,$pagesize);

		$result = $db->query("SELECT * FROM ".TABLE_DOWN." WHERE status=3 AND recycle=0 AND specialid>0 $condition LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result))
		{
			$s = $db->get_one("SELECT specialid,specialname,addtime FROM ".TABLE_SPECIAL." WHERE specialid=$r[specialid]");
			$p->set_catid($r[catid]);
		    $r[url] = $r[linkurl] ? $r[linkurl] : $p->get_itemurl($r[downid],$r[addtime]);
			$r[specialname] = wordscut($s[specialname],24,1);
			$r[specialurl] = $p->get_specialitemurl($s[specialid],$s[addtime]);
			$r[title] = titleformat($r[title],$r[titlefontcolor],$r[titlefonttype],$r[includepic]);
			$r[adddate]=date("Y-m-d",$r[addtime]);
			$downs[]=$r;
		}
		$special_list = special_select($channelid,'specialid','请选择专题',$specialid);
		$special_select = special_select($channelid,'jump','请选择专题进行管理',$specialid,'onchange="if(this.options[this.selectedIndex].value!=\'\'){location=\'?mod='.$mod.'&file='.$file.'&action=special&channelid='.$channelid.'&specialid=\'+this.options[this.selectedIndex].value;}"');
		include admintpl('down_special');
	break;

	case 'myitem':
		$condition .= " and username='$_username' and recycle='0' ";

		$headtitle = "我添加的".$_CHA['channelname'];
		$noinfo = "您还没有添加任何".$_CHA['channelname']."信息。";

		@extract($db->get_one("select count(downid) as mydown_0 from ".TABLE_DOWN." where status='0' ". $condition));
		@extract($db->get_one("select count(downid) as mydown_1 from ".TABLE_DOWN." where status='1' ". $condition));
		@extract($db->get_one("select count(downid) as mydown_2 from ".TABLE_DOWN." where status='2' ". $condition));
		@extract($db->get_one("select count(downid) as mydown_3 from ".TABLE_DOWN." where status='3' ". $condition));
		
		if(!isset($value)) $value=3;
		if(ereg('^[0123]+$',$value))
		{
			$condition .= " and status='$value' ";
		}
		//分页
		$pagesize = $_PHPCMS['down_admin_pagesize']>1 ? $_PHPCMS['down_admin_pagesize'] : 10;
		if(!$page)
		{
			$page=1;
			$offset=0;
		}
		else
		{
			$offset=($page-1)*$pagesize;
		}

		if($catid) $condition.=" and catid='$catid' ";
		if(in_array($field,$fieldtypes) && $keywords)  $condition.=" and $field like '%$keywords%'";
		
		if(!isset($order))
		{
			$condition.=" order by addtime desc ";
		}else
		{		
			if($order && in_array($order,$ordertypes)) $condition.=" order by $order ";
		}

		$r = $db->get_one("select count(downid) as num from ".TABLE_DOWN." where 1 $condition ");
		$pages = phppages($r["num"],$page,$pagesize);

		$query = $db->query("select * from  ".TABLE_DOWN." where 1 ".$condition." limit $offset,$pagesize ");
		if($db->num_rows($query))
		{
			$p->set_type("url");
			while($r=$db->fetch_array($query))
			{
				//生成页面路径对象
				$p->set_catid($r[catid]);
		        $r[url] = $r[linkurl] ? $r[linkurl] : $p->get_itemurl($r[downid],$r[addtime]);
				$r['addtime']=date("Y-m-d",$r['addtime']);
				$r['username']=$r['username'] ? $r['username']:'[未知]';
				$r['property']=$r['ontop'] ? '<font color="red">顶</font> ':'';
				$r['property'].=$r['elite'] ? '<font color="blue">荐</font>':'';
				$r['caturl'] = $p->get_listurl(0);
				$r['catname']=$_CAT[$r['catid']]['catname'];
				$r['atitle']=$r['title'];
		        $r['title'] = titleformat($r['title'],$r['titlefontcolor'],$r['titlefonttype'],$r['includepic']);
				if($r['thumb'])	$r['title']='<font color="red">[图]</font> '.$r['title'];
				$downs[]=$r;
			}
		}

		include admintpl('down_myitem');

	break;
	
	//管理下载
	case 'manage':
		$headtitle = $_CHA['channelname']."管理";
		$noinfo = "没有任何".$_CHA['channelname']."信息。";
		
		//分页
		$pagesize = $_PHPCMS['down_admin_pagesize']>1 ? $_PHPCMS['down_admin_pagesize'] : 20;
		if(!$page)
		{
			$page=1;
			$offset=0;
		}
		else
		{
			$offset=($page-1)*$pagesize;
		}
				
		//查询条件
		if($catid) $condition.=" and catid='$catid' ";
		if(in_array($field,$fieldtypes) && $keywords)  $condition.=" and $field like '%$keywords%'";
		
		if(!isset($order))
		{
			$condition.=" order by addtime desc ";
		}else
		{		
			if($order && in_array($order,$ordertypes) )
				$condition.=" order by $order ";
		}

		$r = $db->get_one("select count(downid) as num from ".TABLE_DOWN." where status='3' and recycle='0' $condition ");
		$pages = phppages($r["num"],$page,$pagesize);

		$query = $db->query("select * from  ".TABLE_DOWN." where status='3' and recycle='0' ".$condition." limit $offset,$pagesize ");
		if($db->num_rows($query))
		{
			$p->set_type("url");
			while($r=$db->fetch_array($query))
			{
				$r['username']=$r['username'] ? $r['username']:'[未知]';
				$r['property']=$r['ontop'] ? '<font color="red">顶</font> ':'';
				$r['property'].=$r['elite'] ? '<font color="blue">荐</font>':'';
				$p->set_catid($r[catid]);
				$r['caturl'] = $p->get_listurl(0);
				$r['catname']=$_CAT[$r['catid']]['catname'];
				$r['atitle']=$r['title'];
		        $r['title'] = titleformat($r['title'],$r['titlefontcolor'],$r['titlefonttype'],$r['includepic']);
				if($r['thumb'])	$r['title']='<font color="red">[图]</font> '.$r['title'];
		        $r[url] = $r[linkurl] ? $r[linkurl] : $p->get_itemurl($r[downid],$r[addtime]);
				$r['addtime']=date("Y-m-d",$r['addtime']);
				$downs[]=$r;
			}
		}
		include admintpl('down_manage');
    break;
	
	//批量移动下载
	case 'move':
		$headtitle="批量移动".$_CHA['channelname'];
		$noinfo="没有任何".$_CHA['channelname']."批量移动信息。";

		if($submit)
		{
			$specialid = intval($specialid);
			$targetcatid = intval($targetcatid);
			if(!$specialid && !$targetcatid) showmessage('非法参数！请返回！');
			if($targetcatid && $_CAT[$targetcatid]['child'] && !$_CAT[$targetcatid]['enableadd']) showmessage('指定栏目不允许添加下载！请返回！');

			if($movetype==1)
			{
				if(empty($downid)) showmessage('非法参数！请返回！');
				$downids=is_array($downid) ? implode(',',$downid) : $downid;
				if($specialid) $db->query("UPDATE ".TABLE_DOWN." SET specialid='$specialid' WHERE downid IN ($downids) AND status=3 AND channelid='$channelid' ");
				if($targetcatid) $db->query("UPDATE ".TABLE_DOWN." SET catid='$targetcatid' WHERE downid IN ($downids) AND status=3 AND channelid='$channelid' ");
			}
			else
			{
				if(empty($batchcatid)) showmessage('非法参数！请返回！');
				$batchcatids=implode(",",$batchcatid);
				if($specialid) $db->query("UPDATE ".TABLE_DOWN." SET specialid='$specialid' WHERE catid IN ($batchcatids) AND status=3 AND channelid='$channelid' ");
				if($targetcatid) $db->query("UPDATE ".TABLE_DOWN." SET catid='$targetcatid' WHERE catid IN ($batchcatids) AND status=3 AND channelid='$channelid' ");
			}
			showmessage('操作成功！',$referer);
		}
		else
		{
			$referer=urlencode('?mod='.$mod.'&file='.$file.'&action=move&channelid='.$channelid);
			$downid=is_array($downid) ? implode(',',$downid) : $downid;
			$special_select = special_select($channelid,'specialid','请选择专题',$specialid);
            $cat_option = cat_option($catid);
			include admintpl('down_move');
		}
    break;
}
?>