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

if($_grade>1) showmessage("您没有权限！");

$submenu=array
(
	array('栏目标签','?mod='.$mod.'&file='.$file.'&action=manage&func=catlist&channelid='.$channelid),
	array('专题标签','?mod='.$mod.'&file='.$file.'&action=manage&func=speciallist&channelid='.$channelid),
	array('专题幻灯片标签','?mod='.$mod.'&file='.$file.'&action=manage&func=slidespecial&channelid='.$channelid),
	array('公告标签','?mod='.$mod.'&file='.$file.'&action=manage&func=announcelist&channelid='.$channelid),
	array('友情链接标签','?mod='.$mod.'&file='.$file.'&action=manage&func=linklist&channelid='.$channelid),
	array('评论标签','?mod='.$mod.'&file='.$file.'&action=manage&func=commentlist&channelid='.$channelid),
);
$menu = adminmenu("公共标签调用管理",$submenu);

$funcs = array('catlist'=>'栏目目录列表调用标签','speciallist'=>'专题列表调用标签','slidespecial'=>'幻灯片专题图片调用标签','announcelist'=>'公告列表调用标签','linklist'=>'友情链接调用标签','commentlist'=>'评论调用标签');

$ms = array('catlist'=>'phpcms','speciallist'=>'phpcms','slidespecial'=>'phpcms','announcelist'=>'announce','linklist'=>'link','commentlist'=>'comment');

require_once PHPCMS_ROOT.'/include/admin_setting.php';

$tree = new tree;
$cat_option = cat_option($catid);

$func = $func ? $func : "catlist";
$module = $ms[$func];

$action = $action ? $action : "manage";

$referer = $referer ? $referer : $PHP_REFERER;
$pagesize = $_PHPCMS[pagesize];

switch($action)
{
	case 'set':
		if($tagid)
	    {
			$r = $db->get_one("SELECT * FROM ".TABLE_TAG." WHERE tagid=$tagid");
			@extract($r);
            if(!@include_once PHPCMS_CACHEDIR."tag/".$tagid.".php")
			{
				cache_tag($tagid);
				include_once PHPCMS_CACHEDIR."tag/".$tagid.".php";
			}
			$data = $_TAG[$tagid];
			$data[channelid] = $data[channelid] ? $data[channelid] : ($channelid ? $channelid : 0);
	    }
		else
	    {
			switch($func)
			{
				case 'catlist':
					$data[catid] = 0 ;
					$data[child] = 0 ;
					$data[showtype] = 0;
					$data[open] = 0;
					break;
				case 'speciallist':
					$data[specialid] = 0 ;
					$data[page] = 0 ;
					$data[specialnum] = 1;
					$data[specialnamelen] = 50;
					$data[descriptionlen] = 100;
					$data[iselite] = 0;
					$data[datenum] = 0;
					$data[showtype] = 1;
					$data[imgwidth] = 150;
					$data[imgheight] = 150;
					$data[cols] = 1 ;
					$special_select = special_select($channelid,'selectspecialid','请选择专题',$data[specialid],'onchange="javascript:ChangeInput(this,document.myform.specialid)"');
		            break;
				case 'slidespecial':
					$data[specialid] = 0 ;
					$data[specialnum] = 5;
					$data[specialnamelen] = 50;
					$data[iselite] = 0;
					$data[datenum] = 0;
					$data[imgwidth] = 150;
					$data[imgheight] = 150;
					$data[timeout] = 5000;
					$data[effectid] = -1;
		            $special_select = special_select($channelid,'selectspecialid','请选择专题',$data[specialid],'onchange="javascript:ChangeInput(this,document.myform.specialid)"');
				    break;
				case 'commentlist':
					$module = 'comment';
					$data[item] = $channelid ? $_CHA['module']."id" : "" ;
					$data[itemid] = $channelid ? "\$".$_CHA['module']."id" : "";
					$data[commentnum] = 10;
					$data[ordertype] = 0;
				    break;
				case 'linklist':
					$module = 'link';
					$data[linktype] = 0;
					$data[page] = 0 ;
					$data[sitenum] = 10;
					$data[cols] = 1;
				    break;
				case 'announcelist':
					$module = 'announce';
					$data[page] = 0;
					$data[announcenum] = 10;
					$data[titlelen] = 50;
					$data[datetype] = 1;
					$data[height] = 100;
					$data[width] = 180;
					$data[showauthor] = 0;
					$data[target] = 1 ;
				    break;
			}
			$data[channelid] = $channelid ? $channelid : 0;
		}
		$showtpl = showtpl($module,'tag_'.$func,'newdata[templateid]',$data[templateid],"id='templateid'");
		if(!$tagid) $my = "my_";
		include admintpl('tag_'.$func);
		break;

	case 'tag_exists':
		if(!preg_match("/^[0-9a-z_]+$/i",$tag)) showmessage("<font color='red'>配置名称只能由字母、数字和下划线组成！</font>");
		
		$r = $db->get_one("SELECT * FROM ".TABLE_TAG." WHERE tag='$tag'");
		if($r[tagid])
		{
			showmessage("<font color='red'>该配置名称已经存在！</font>");
		}
		else
		{
			showmessage("该配置名称不存在！");
		}
		break;

	case 'preview':
		if($func && is_array($newdata))
	    {
		    @extract($newdata);
	    }
		else
	    {
		    if(!@include_once PHPCMS_CACHEDIR."tag/".$tagid.".php")
			{
				cache_tag($tagid);
				include_once PHPCMS_CACHEDIR."tag/".$tagid.".php";
			}
			@extract($_TAG[$tagid]);
		}

		if($page=="\$page") $page = 1;
		$page = intval($page);
		$channelid = intval($channelid);
		$catid = intval($catid);
		$specialid = intval($specialid);

		echo "<html>
			  <head>
			  <title>标签预览</title>
			  <link href='".$skindir."/style.css' rel='stylesheet' type='text/css'>
			  <script language='JavaScript' src='".PHPCMS_PATH."include/js/common.js'></script>
			  </head>
			  <body>";

		switch($func)
		{
			case 'catlist':
				echo $func($templateid,$channelid,$catid,$child,$showtype,$open);
			    break;
			case 'speciallist':
			    echo $func($templateid,$channelid,$specialid,$page,$specialnum,$specialnamelen,$descriptionlen,$iselite,$datenum,$showtype,$imgwidth,$imgheight,$cols);
			    break;
			case 'slidespecial':
			    echo $func($templateid,$channelid,$specialid,$specialnum,$specialnamelen,$iselite,$datenum,$imgwidth,$imgheight,$timeout,$effectid);
			    break;
			case 'commentlist':
				echo $func($templateid,$item,$itemid,$page,$commentnum,$ordertype);
			    break;
			case 'linklist':
			    echo $func($templateid,$channelid,$linktype,$page,$sitenum,$cols);
			    break;
			case 'announcelist':
			    echo $func($templateid,$channelid,$page,$announcenum,$titlelen,$datetype,$showauthor,$target,$width,$height);
			    break;
		}

		echo "</body></html>";
		break;

	case 'save':
		$tagid = intval($tagid);
		if(!$tagid)
	    {
			if(!preg_match("/^my_[0-9a-z_]+$/i",$tag)) showmessage('自定义配置名称必须以 my_ 为前缀<br/>且只能由字母、数字和下划线组成！请返回！');
			$r = $db->get_one("SELECT * FROM ".TABLE_TAG." WHERE tag='$tag'");
			if($r[tagid]) showmessage("已经存在同名标签！请更换标签名！",$PHP_REFERER);
		}
		if(empty($tagname)) showmessage('配置说明不能为空！请返回！');
	    if(!preg_match('/^[a-z0-9_]+$/i',$func)) showmessage('配置类型不对！请返回！');
		if(!is_array($newdata)) showmessage('参数错误！请返回！');

		$module = $mod; 
		$thechannelid = intval($channelid);
		@extract($newdata);
		switch($func)
		{
			case 'catlist':
				$child = $child ? $child : 0;
				$open = $open ? $open : 0;
				$tagcode = $func."('".$templateid."',".$channelid.",".setpar($catid).",".$child.",".$showtype.",".$open.")";
			    break;
			case 'speciallist':
			    $tagcode = $func."('".$templateid."',".$channelid.",".setpar($specialid).",".$page.",".$specialnum.",".$specialnamelen.",".$descriptionlen.",".$iselite.",".$datenum.",".$showtype.",".$imgwidth.",".$imgheight.",".$cols.")";
			    break;
			case 'slidespecial':
			    $tagcode = $func."('".$templateid."',".$channelid.",".setpar($specialid).",".$specialnum.",".$specialnamelen.",".$iselite.",".$datenum.",".$imgwidth.",".$imgheight.",".$timeout.",".$effectid.")";
			    break;
			case 'commentlist':
				$module = 'comment';
				$tagcode = $func."('".$templateid."','".$item."',".$itemid.",".$page.",".$commentnum.",".$ordertype.")";
			    break;
			case 'linklist':
				$module = 'link';
			    $tagcode = $func."('".$templateid."',".$channelid.",".$linktype.",".$page.",".$sitenum.",".$cols.")";
			    break;
			case 'announcelist':
				$module = 'announce';
			    $tagcode = $func."('".$templateid."',".$channelid.",".$page.",".$announcenum.",".$titlelen.",".$datetype.",".$showauthor.",".$target.",".$width.",".$height.")";
			    break;

		}
		$parameters = addslashes(var_export($newdata, TRUE));
		$tagcode = addslashes($tagcode);
		if($tagid)
	    {
		    $db->query("UPDATE ".TABLE_TAG." SET tagname='$tagname',parameters='$parameters',tagcode='$tagcode',username='$_username',edittime='$timestamp' WHERE tagid='$tagid'");
		}
		else
	    {
		    $db->query("INSERT INTO ".TABLE_TAG."(tag,module,channelid,func,tagname,parameters,tagcode,username,edittime) VALUES('$tag','$module','$thechannelid','$func','$tagname','$parameters','$tagcode','$_username','$timestamp')");
			$tagid = $db->insert_id();
		}
		cache_tag($tagid);
        require_once PHPCMS_ROOT."/include/template.php";
        require_once PHPCMS_CACHEDIR."tag.php";
		template_cache();
		showmessage("标签配置保存成功！",$referer);
		break;

	case 'manage':
		$tags = array();
		$module = $module ? $module : $mod;
		$query = $db->query("SELECT * FROM ".TABLE_TAG." WHERE module='$module' AND channelid=$channelid AND func='$func' ORDER BY type DESC");
		while($r=$db->fetch_array($query))
		{
			$alt = $r[type] ? "标签类型：系统标签" : "标签类型：自定义标签";
			$alt .= "&#13最后修改人：".$r[username];
			$alt .= "&#13最后修改时间：".date("Y-m-d H:i:s",$r[edittime]);
			$r[alt] = $alt;
			$jsquery = strpos($r[tagcode],"\$channelid") ? "&channelid={\$channelid}" : "";
			$jsquery .= strpos($r[tagcode],"\$catid") ? "&catid={\$catid}" : "";
			$jsquery .= strpos($r[tagcode],"\$specialid") ? "&specialid={\$specialid}" : "";
			$jsquery .= strpos($r[tagcode],"\$page") ? "&page={\$page}" : "";
			$r[jsquery] = $jsquery;
			$tags[] = $r;
		}
		switch($func)
		{
			case 'catlist':
			$tag_function='catlist(templateid,channelid,catid,child,showtype,open)';
			break;
			case 'speciallist':
			$tag_function='speciallist(templateid,channelid,specialid,page,specialnum,specialnamelen,descriptionlen,iselite,datenum,showtype,imgwidth,imgheight,cols)';
			break;
			case 'slidespecial':
			$tag_function='slidespecial(templateid,channelid,specialid,specialnum,specialnamelen,iselite,datenum,imgwidth,imgheight,timeout,effectid)';
			break;
			case 'commentlist':
			$tag_function='commentlist(templateid,item,itemid,page,commentnum,ordertype)';
			break;
			case 'linklist':
			$tag_function='linklist(templateid,channelid,linktype,page,sitenum,cols)';
			break;
			case 'announcelist':
			$tag_function='announcelist(templateid,channelid,page,announcenum,titlelen,datetype,showauthor,target,width,height)';
			break;
		}
		include admintpl('tag_manage');
		break;

	case 'delete':
	    $db->query("DELETE FROM ".TABLE_TAG." WHERE tagid='$tagid' ");
		@$f->unlink(PHPCMS_CACHEDIR."tag/".$tagid.".php");
		showmessage('操作成功！',$referer);
	    break;

	case 'cache':
		cache_tag(0," module='$mod' AND channelid=$channelid ");
		showmessage('操作成功！',$PHP_REFERER);
	    break;
}
?>