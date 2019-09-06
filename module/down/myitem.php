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

$pagesize = $_PHPCMS['pagesize'] ? $_PHPCMS['pagesize'] : 20;
$titlelen = 50;//标题截取长度
$referer=$referer ? $referer : $PHP_REFERER;
$action=$action ? $action : 'manage';

$downid = intval($downid);
$catid = intval($catid);
$specialid = intval($specialid);

switch($action){

case 'add':

    if(!$_CHA['enablecontribute']) message("本频道不允许投稿！","goback");

	if($submit)
	{
		if(!$catid) message('请选择栏目！','goback');
		if(!check_purview($_CAT[$catid]['arrgroupid_add'])) message("您没有当前栏目的投稿权限！","goback");
		if($_CAT[$catid]['child'] && !$_CAT[$catid]['enableadd']) message('指定栏目不允许添加下载！','goback');
		if(!trim($title)) message('请填写标题！','goback');
		if(!trim($introduce)) message('请填写内容！','goback');
		if(!$downurls) message('下载地址不能为空！','goback');

		$inputstring=dhtmlspecialchars(array('title'=>$title,'keywords'=>$keywords,'author'=>$author,'copyfromname'=>$copyfromname,'copyfromurl'=>$copyfromurl,'thumb'=>$thumb));
		extract($inputstring,EXTR_OVERWRITE);
		$introduce = str_safe($introduce);

		if($_CHA['enablecheck'] && !$_GROUP['enableaddalways']) $status = $status > 2 ? 1 : $status ;

		$db->query("insert into ".TABLE_DOWN."(channelid,catid,specialid,title,titlefontcolor,titlefonttype,keywords,author,copyfromname,copyfromurl,username,addtime,checker,checktime,editor,edittime,introduce,status,thumb,filesize,downurls) values('$channelid','$catid','$specialid','$title','$titlefontcolor','$titlefonttype','$keywords','$author','$copyfromname','$copyfromurl','$_username','$timestamp','','','','$timestamp','$introduce','$status','$thumb','$filesize','$downurls')");
		$downid = $db->insert_id();
		field_update($channelid,"downid=$downid");
		if($status==3)
		{
			credit_add($_username,$_CAT[$catid]['creditget']);
			if($_CHA['htmlcreatetype']) 
			{
				include_once PHPCMS_ROOT."/include/cmd.php";
				cmd_send(PHPCMS_PATH.$_CHA['channeldir']."/cmd.php","down2html",$referer,"downid=".$downid."&enablemessage=1");
			}
		}
		message('添加成功！',"?module=".$module."&channelid=".$channelid."&action=manage");
	}
	else
	{
		$tree=new tree;
		$cat_select = cat_select('catid','请选择栏目',$catid);
		$special_select = special_select($channelid,'specialid','不属于任何专题',$specialid);
		$fields = field_input($channelid,"tablerow");
		$author = $_username;
		$disabled = (($_isadmin && $_grade==0) || $_GROUP['enableaddalways']==1) ? 0 : 1;
        $status = $disabled ? 0 : 3;
	}
break;

case 'edit':
	if($submit)
	{
		if(!trim($catid)) message('请选择栏目！','goback');
		if($_CAT[$catid][child] && !$_CAT[$catid]['enableadd'])	message('指定栏目不允许添加下载！','goback');
		if(!trim($title)) message('请填写标题！','goback');
		if(!trim($introduce)) message('请填写内容！','goback');
		if(!$downurls) message('下载地址不能为空！','goback');

		$inputstring=dhtmlspecialchars(array('title'=>$title,'keywords'=>$keywords,'author'=>$author,'copyfromname'=>$copyfromname,'copyfromurl'=>$copyfromurl,'thumb'=>$thumb));
		extract($inputstring,EXTR_OVERWRITE);
		$introduce = str_safe($introduce);

        $status = intval($status);
		if($_CHA['enablecheck'] && !$_GROUP['enableaddalways']) $status = $status > 2 ? 1 : $status ;

		$db->query("update ".TABLE_DOWN." set catid='$catid',specialid='$specialid',title='$title',titlefontcolor='$titlefontcolor',titlefonttype='$titlefonttype',keywords='$keywords',author='$author',copyfromname='$copyfromname',copyfromurl='$copyfromurl',editor='$_username',edittime='$timestamp',introduce='$introduce',status='$status',thumb='$thumb',filesize='$filesize',downurls='$downurls',readpoint='$readpoint',groupview='$groupview' where downid='$downid' limit 1");
		field_update($channelid,"downid=$downid");
		if($status==3)
		{
			if($_CHA['htmlcreatetype']) 
			{
				include_once PHPCMS_ROOT."/include/cmd.php";
				cmd_send(PHPCMS_PATH.$_CHA['channeldir']."/cmd.php","down2html",$referer,"downid=".$downid."&enablemessage=1");
			}
		}
        message('操作成功！',$referer);
	}
	else
	{
		$upfile_size = intval($_CHA['maxfilesize']/1024);

		$r = $db->get_one("select * from  ".TABLE_DOWN." where downid='$downid'");
        if(!$r[downid]) message("参数错误！");

		@extract(dhtmlspecialchars($r));

		$tree=new tree;
		$cat_select		= cat_select('catid','请选择栏目',$catid,"onchange=\"setff(this.value)\"");
		$special_select = special_select($channelid,'specialid','不属于任何专题',$specialid);
		$fields = field_input($channelid,"tablerow");
        $downurls = trim($downurls);
		$downurls = explode("\n",$downurls);
		$downurls = array_map("trim",$downurls);
		$disabled = (($_isadmin && $_grade==0) || $_GROUP['enableaddalways']==1) ? 0 : 1;
	}
break;

case 'uploadfile':

	@extract($_CHA);
    if(!$enableupload) message("本频道不允许上传文件！","goback");

	if($save)
	{
		require_once PHPCMS_ROOT."/class/upload.php";

		$fileArr = array('file'=>$uploadfile,'name'=>$uploadfile_name,'size'=>$uploadfile_size,'type'=>$uploadfile_type);
		$savepath = $channeldir."/".$uploaddir."/".date("Ym")."/";
		$f->create(PHPCMS_ROOT."/".$savepath);
		$upload = new upload($fileArr,'',$savepath,$uploadfiletype,1,$maxfilesize);
		if($upload->up())
		{
			$note = $note ? $note : "下载地址'+(parent.document.myform.DownloadUrl.length+1)+'";
			$filesize = round($uploadfile_size/1000);
			$message = "上传成功！
						<SCRIPT language='javascript'>
						parent.document.myform.filesize.value='".$filesize."';
						var url='".$note."|".$upload->saveto."'; 
						parent.document.myform.DownloadUrl.options[parent.document.myform.DownloadUrl.length]=new Option(url,url);
						setTimeout(\"window.location='".$PHP_REFERER."';\", 1250);
						</script>";
			message($message);
		}
		else
		{
			message($upload->errmsg());
		}
	}
	else
	{
		  echo "<head>
				<meta http-equiv='Content-Type' content='text/html; charset=".$charset."' />
				<title>文件上传</title>
				<link href='".$skindir."/style.css' rel='stylesheet' type='text/css'>
				</head>
				<body style='margin:0px;0px;0px 0px;'>
				<table cellpadding='0' cellspacing='0' width='100%'>
				<form name='upload' method='post' action='?module=".$module."&channelid=".$channelid."&action=uploadfile' enctype='multipart/form-data'>
				  <tr>
					 <td class='tablerow' height='50'>
						 <input type='hidden' name='save' value='1'>
						 说明：<input type='text' name='note' size='20'>
							 <input type='file' name='uploadfile' size='15'>
							 <input type='hidden' name='MAX_FILE_SIZE' value='".$maxfilesize."'> 
							 <input type='submit' name='submit' value=' 上传 '>
				   </td>
				   </tr>
				</form>
				</table>
				</body>
				</html>";
		exit;
	}

break;

case 'send'://投稿

	if(empty($downid))
	{
		message('非法参数！请返回！');
	}
	
	$db->query("UPDATE ".TABLE_DOWN." SET status=1 WHERE downid='$downid' AND username='$_username' AND channelid='$channelid' AND status!=3");
	message('操作成功！',$referer);

break;

case 'preview':
	
	if(!ereg('^[0-9]+$',$downid))
	{
		message('非法参数！请返回！'); 
	}
	@extract($db->get_one("SELECT * FROM ".TABLE_DOWN." WHERE downid=$downid AND username='$_username' AND channelid='$channelid' AND status!=3 "));
	$url = $p->get_itemurl($downid,$addtime);
	$adddate=date('Y-m-d',$addtime);

	$urls = explode("\n",$downurls);
	$urls = array_map("trim",$urls);
	$downurls = array();
	foreach($urls as $k=>$v)
	{
		$downurl = explode("|",$v);
		$downurl['id'] = $k;
		$downurl['name'] = $downurl[0];
		$downurl['type'] = preg_match("/^(http|ftp):\/\//i",$downurl[1]) ? "" : "（本地下载）";
		$downurl['url'] = $downurl[1];
		$downurls[] = $downurl;
	}
break;

case 'delete':

	if(empty($downid))
	{
		message('非法参数！请返回！');
	}

	$downids=is_array($downid) ? implode(',',$downid) : $downid;

	$db->query("DELETE FROM ".TABLE_DOWN." WHERE downid IN ($downids) AND username='$_username' AND status!=3 AND channelid='$channelid'");
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
			$dordertype=" downs DESC ";
		break;
		case 4:
			$dordertype=" downs ";
		break;
		default :
			$dordertype=" downid DESC ";
	}

	$r = $db->get_one("SELECT COUNT(*) as num FROM ".TABLE_DOWN." WHERE status='$status' AND username='$_username' AND recycle=0 AND channelid='$channelid' $addquery ");
	$number=$r["num"];
	$url="?module=".$module."&channelid=".$channelid."&action=manage&&status=".$status."catid=".$catid."&srchtype=".$srchtype."&keyword=".$keyword."&ontop=".$ontop."&elite=".$elite."&ordertype=".$ordertype;
	$pages=phppages($number,$page,$pagesize,$url);

	$result=$db->query("SELECT downid,channelid,catid,title,titlefontcolor,titlefonttype,downs,username,addtime,editor,edittime,checker,checktime,ontop,elite,stars,recycle,status FROM ".TABLE_DOWN." WHERE status='$status' AND username='$_username' AND recycle=0 AND channelid='$channelid' $addquery ORDER BY $dordertype LIMIT $offset,$pagesize ");
	while($r=$db->fetch_array($result))
	{
		$p->set_catid($r[catid]);
		$r[url] = $p->get_itemurl($r[downid],$r[addtime]);
		$r[catdir] = $p->get_listurl(0);
		$r[title] = wordscut($r[title],$titlelen,1);
		$r[title] = titleformat($r[title],$r[titlefontcolor],$r[titlefonttype],$r[includepic]);
		$r[adddate]=date("Y-m-d",$r[addtime]);
		$r[addtime]=date("Y/md",$r[addtime]);
		$downs[]=$r;
	}
break;
}

@extract($db->get_one("SELECT COUNT(*) AS num_3 FROM ".TABLE_DOWN." WHERE status=3 AND username='$_username' AND recycle=0 AND channelid='$channelid'","CACHE"));
@extract($db->get_one("SELECT COUNT(*) AS num_1 FROM ".TABLE_DOWN." WHERE status=1 AND username='$_username' AND recycle=0 AND channelid='$channelid'","CACHE"));
@extract($db->get_one("SELECT COUNT(*) AS num_0 FROM ".TABLE_DOWN." WHERE status=0 AND username='$_username' AND recycle=0 AND channelid='$channelid'","CACHE"));
@extract($db->get_one("SELECT COUNT(*) AS num_2 FROM ".TABLE_DOWN." WHERE status=2 AND username='$_username' AND recycle=0 AND channelid='$channelid'","CACHE"));
include template('down','myitem');
?>