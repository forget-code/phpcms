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

require_once(PHPCMS_ROOT."/include/admin_functions.php");

$pictureid = intval($pictureid);
$catid = intval($catid);
$specialid = intval($specialid);

$pagesize = $_PHPCMS['pagesize'] ? $_PHPCMS['pagesize'] : 20;

$titlelen = 40;
$referer = $referer ? $referer : $PHP_REFERER;
$action = $action ? $action : 'manage';

switch($action){

case 'add':

    if(!$_CHA['enablecontribute']) message("本频道不允许投稿！","goback");

	if($submit)
	{
		if(!$catid)	message('对不起，请选择所属栏目！','goback');
		if(!check_purview($_CAT[$catid]['arrgroupid_add'])) message("您没有当前栏目的投稿权限！","goback");
		if($_CAT[$catid][child] && !$_CAT[$catid][enableadd]) message('指定栏目不允许添加图片！','goback');
		if(empty($title)) message('对不起，简短标题不能为空！','goback');
		if(empty($content))	message('对不起，介绍不能为空！','goback');
		if(!$pictureurls) message('图片地址不能为空！','goback');

		$inputstring=dhtmlspecialchars(array('title'=>$title,'keywords'=>$keywords,'author'=>$author,'copyfromname'=>$copyfromname,'copyfromurl'=>$copyfromurl,'pictureurls'=>$pictureurls,'thumb'=>$thumb));
		extract($inputstring,EXTR_OVERWRITE);
		$content = str_safe($content);

		if($_CHA['enablecheck'] && !$_GROUP['enableaddalways']) $status = $status > 2 ? 1 : $status ;

		$db->query("INSERT INTO ".TABLE_PICTURE."(channelid,catid,specialid,title,thumb,keywords,author,copyfromname,copyfromurl,username,addtime,content,pictureurls,status) VALUES('$channelid','$catid','$specialid','$title','$thumb','$keywords','$author','$copyfromname','$copyfromurl','$_username','$timestamp','$content','$pictureurls','$status')");
		$pictureid = $db->insert_id();
		field_update($channelid,"pictureid=$pictureid");
		if($status==3)
		{
			credit_add($_username,$_CAT[$catid]['creditget']);
			if($_CHA['htmlcreatetype']) 
			{
				include_once PHPCMS_ROOT."/include/cmd.php";
				cmd_send(PHPCMS_PATH.$_CHA['channeldir']."/cmd.php","picture2html",$referer,"pictureid=".$pictureid."&enablemessage=1");
			}
		}
		message('操作成功！',$referer); 
	}
	else
	{
		$tree = new tree;
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
		if(!$pictureid) message('非法参数！请返回！');
		if(!$catid)	message('对不起，请选择所属栏目！','goback');
		if(!check_purview($_CAT[$catid]['arrgroupid_add'])) message("您没有当前栏目的投稿权限！","goback");
		if($_CAT[$catid][child] && !$_CAT[$catid][enableadd]) message('指定栏目不允许添加图片！','goback');
		if(empty($title)) message('对不起，简短标题不能为空！','goback');
		if(empty($content))	message('对不起，介绍不能为空！','goback');
		if(!$pictureurls) message('图片地址不能为空！','goback');

		$inputstring=dhtmlspecialchars(array('title'=>$title,'keywords'=>$keywords,'author'=>$author,'copyfromname'=>$copyfromname,'copyfromurl'=>$copyfromurl,'pictureurls'=>$pictureurls,'thumb'=>$thumb));
		extract($inputstring,EXTR_OVERWRITE);
		$content = str_safe($content);

        $status = intval($status);
		if($_CHA['enablecheck'] && !$_GROUP['enableaddalways']) $status = $status > 2 ? 1 : $status ;

		$db->query("UPDATE ".TABLE_PICTURE." SET catid='$catid',specialid='$specialid',title='$title',thumb='$thumb',author='$author',copyfromname='$copyfromname',copyfromurl='$copyfromurl',keywords='$keywords',content='$content',pictureurls='$pictureurls',status='$status',editor='$_username',edittime='$timestamp' WHERE pictureid='$pictureid' AND channelid='$channelid' and username='$_username' AND status!=3");
		field_update($channelid,"downid=$downid");
		if($status==3)
		{
			if($_CHA['htmlcreatetype']) 
			{
				include_once PHPCMS_ROOT."/include/cmd.php";
				cmd_send(PHPCMS_PATH.$_CHA['channeldir']."/cmd.php","picture2html",$referer,"pictureid=".$pictureid."&enablemessage=1");
			}
		}
        message('操作成功！',$referer);
	}
	else
	{
        $r = $db->get_one("SELECT * FROM ".TABLE_PICTURE." WHERE pictureid='$pictureid' AND channelid='$channelid' AND username='$_username' AND status!=3");
		if(!$r[pictureid]) message("参数错误！");

		@extract(dhtmlspecialchars($r));

        $tree = new tree;
		$cat_select = cat_select('catid','请选择栏目',$catid);
		$special_select = special_select($channelid,'specialid',$specialid);
		$fields = field_input($channelid,"tablerow");
        $pictureurls = trim($pictureurls);
		$pictureurls = explode("\n",$pictureurls);
		$pictureurls = array_map("trim",$pictureurls);
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
			$note = $note ? $note : "图片地址'+(parent.document.myform.PictureUrl.length+1)+'";
			$message = "上传成功！
						<SCRIPT language='javascript'>
						var url='".$note."|".$upload->saveto."'; 
						parent.document.myform.PictureUrl.options[parent.document.myform.PictureUrl.length]=new Option(url,url);
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

case 'preview':
	
	if(!ereg('^[0-9]+$',$pictureid))
	{
		message('非法参数！请返回！'); 
	}
	@extract($db->get_one("SELECT * FROM ".TABLE_PICTURE." WHERE pictureid=$pictureid AND username='$_username' AND channelid='$channelid' AND status!=3 "));
	$url = $p->get_itemurl($pictureid,$addtime);
	$adddate=date('Y-m-d',$addtime);

    $pictureurls = trim($pictureurls);  
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

break;

case 'send'://投稿

	if(empty($pictureid))
	{
		message('非法参数！请返回！');
	}
	
	$db->query("UPDATE ".TABLE_PICTURE." SET status=1 WHERE pictureid='$pictureid' AND username='$_username' AND channelid='$channelid' AND status!=3");
	message('操作成功！',$referer);

break;

//彻底删除，按ID
case 'delete':

	if(empty($pictureid))
	{
		message('非法参数！请返回！');
	}

	$pictureids=is_array($pictureid) ? implode(',',$pictureid) : $pictureid;

	$db->query("DELETE FROM ".TABLE_PICTURE." WHERE pictureid IN ($pictureids) AND channelid='$channelid' AND username='$_username' AND status!=3 ");
	if($db->affected_rows()>0)
	{
		message('操作成功！',$referer);
	}
	else
	{
		message('操作失败！请返回！');
	}
break;


//管理图片
case 'manage':
	$tree = new tree;
    $cat_select = cat_select('catid','请选择栏目',$catid);

    $status = isset($status) ? $status : 3;
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

	$query="SELECT COUNT(*) as num FROM ".TABLE_PICTURE." WHERE username='$_username' and status='$status' AND recycle=0 AND channelid='$channelid' $addquery";
	$result=$db->query($query);
	$r=$db->fetch_array($result);
	$number=$r["num"];
	$url="?module=".$module."&channelid=".$channelid."&action=manage&&status=".$status."catid=".$catid."&srchtype=".$srchtype."&keyword=".$keyword."&ontop=".$ontop."&elite=".$elite."&ordertype=".$ordertype;

	$pages=phppages($number,$page,$pagesize,$url);

	$query="SELECT * FROM ".TABLE_PICTURE." WHERE username='$_username' and status='$status' AND recycle=0 AND channelid='$channelid' $addquery ORDER BY $dordertype LIMIT $offset,$pagesize";
	$result=$db->query($query);
	if($db->num_rows($result)>0)
	{
		while($r=$db->fetch_array($result))
		{
			$r[url] = $p->get_itemurl($r[pictureid],$r[addtime]);
			$p->set_catid($r[catid]);
			$r[catdir] = $p->get_listurl(1);
			$r[title] = titleformat($r[title],$r[titlefontcolor],$r[titlefonttype],'');
			$r[adddate]=date("Y-m-d",$r[addtime]);
			$r[addtime]=date("Y/md",$r[addtime]);
			$pictures[]=$r;
		}
	}
	

break;

}

@extract($db->get_one("SELECT COUNT(*) AS num_3 FROM ".TABLE_PICTURE." WHERE status=3 AND username='$_username' AND recycle=0 AND channelid='$channelid'","CACHE"));
@extract($db->get_one("SELECT COUNT(*) AS num_1 FROM ".TABLE_PICTURE." WHERE status=1 AND username='$_username' AND recycle=0 AND channelid='$channelid'","CACHE"));
@extract($db->get_one("SELECT COUNT(*) AS num_0 FROM ".TABLE_PICTURE." WHERE status=0 AND username='$_username' AND recycle=0 AND channelid='$channelid'","CACHE"));
@extract($db->get_one("SELECT COUNT(*) AS num_2 FROM ".TABLE_PICTURE." WHERE status=2 AND username='$_username' AND recycle=0 AND channelid='$channelid'","CACHE"));

include template('picture','myitem');

?>