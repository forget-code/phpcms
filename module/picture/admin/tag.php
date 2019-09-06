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
defined('IN_PHPCMS') or exit(FORBIDDEN);

$submenu = array(
	array('图片列表调用','?mod='.$mod.'&file='.$file.'&action=manage&func=picturelist&channelid='.$channelid),
	array('缩略图调用','?mod='.$mod.'&file='.$file.'&action=manage&func=picpicture&channelid='.$channelid),
	array('幻灯片效果调用','?mod='.$mod.'&file='.$file.'&action=manage&func=slidepicpicture&channelid='.$channelid),
	array('更新标签缓存','?mod='.$mod.'&file='.$file.'&action=cache&channelid='.$channelid),
	array('栏目标签','?mod=phpcms&file=tag&action=manage&func=catlist&channelid='.$channelid),
	array('专题标签','?mod=phpcms&file=tag&action=manage&func=speciallist&channelid='.$channelid),
	array('专题幻灯片标签','?mod=phpcms&file=tag&action=manage&func=slidespecial&channelid='.$channelid),
	array('公告标签','?mod=phpcms&file=tag&action=manage&func=announcelist&channelid='.$channelid),
	array('友情链接标签','?mod=phpcms&file=tag&action=manage&func=linklist&channelid='.$channelid),
	array('评论标签','?mod=phpcms&file=tag&action=manage&func=commentlist&channelid='.$channelid.'&item=channelid&itemid='.$channelid),
	array('自定义标签','?mod=phpcms&file=mytag&action=manage&channelid='.$channelid)
);
$menu=adminmenu('标签调用管理',$submenu);

$funcs = array('picturelist'=>'图片列表调用标签','picpicture'=>'图片调用标签','slidepicpicture'=>'幻灯片效果调用标签');

$tree = new tree;
$cat_option = cat_option($catid);

$func = $func ? $func : "picturelist";

$action = $action ? $action : "manage";

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
	    }
		else
	    {
			$data = array (
			  'channelid' => '$channelid',
			  'catid' => '0',
			  'child' => '1',
			  'specialid' => '0',
			  'page' => '0',
			  'picturenum' => '10',
			  'titlelen' => '30',
			  'descriptionlen' => '0',
			  'iselite' => '0',
			  'datenum' => '0',
			  'ordertype' => '1',
			  'datetype' => '2',
			  'showcatname' => '0',
			  'showauthor' => '0',
			  'showhits' => '0',
			  'showstars' => '0',
			  'target' => '1',
			  'showtype' => '1',
			  'showalt' => '0',
			  'imgwidth' => '150',
			  'imgheight' => '150',
			  'timeout' => '5000',
			  'cols' => '1',
			  'templateid' => '0',
			);
		}
		$special_select = special_select($channelid,'selectspecialid','请选择专题',$data[specialid],'onchange="javascript:ChangeInput(this,document.myform.specialid)"');
		$showtpl = showtpl($mod,'tag_'.$func,'newdata[templateid]',$data[templateid],"id='templateid'");
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
			case 'picturelist':
			echo picturelist($templateid,$channelid,$catid,$child,$specialid,$page,$picturenum,$titlelen,$descriptionlen,$iselite,$datenum,$ordertype,$datetype,$showcatname,$showauthor,$showhits,$target,$cols);
			break;
			case 'picpicture':
			echo picpicture($templateid,$channelid,$catid,$child,$specialid,$page,$picturenum,$titlelen,$descriptionlen,$iselite,$datenum,$ordertype,$showtype,$showalt,$imgwidth,$imgheight,$cols);
			break;
			case 'slidepicpicture':
			echo slidepicpicture($templateid,$channelid,$catid,$child,$specialid,$picturenum,$titlelen,$iselite,$datenum,$ordertype,$imgwidth,$imgheight,$timeout,$effectid);
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

		$thechannelid = intval($channelid);
		@extract($newdata);
		switch($func)
		{
			case 'picturelist':
			    $tagcode = $func."('".$templateid."',".$channelid.",".setpar($catid).",".$child.",".setpar($specialid).",".$page.",".$picturenum.",".$titlelen.",".$descriptionlen.",".$iselite.",".$datenum.",".$ordertype.",".$datetype.",".$showcatname.",".$showauthor.",".$showhits.",".$target.",".$cols.")";
			    break;
			case 'picpicture':
			    $tagcode = $func."('".$templateid."',".$channelid.",".setpar($catid).",".$child.",".setpar($specialid).",".$page.",".$picturenum.",".$titlelen.",".$descriptionlen.",".$iselite.",".$datenum.",".$ordertype.",".$showtype.",".$showalt.",".$imgwidth.",".$imgheight.",".$cols.")";
			    break;
			case 'slidepicpicture':
			    $tagcode = $func."('".$templateid."',".$channelid.",".setpar($catid).",".$child.",".setpar($specialid).",".$picturenum.",".$titlelen.",".$iselite.",".$datenum.",".$ordertype.",".$imgwidth.",".$imgheight.",".$timeout.",".$effectid.")";
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
		    $db->query("INSERT INTO ".TABLE_TAG."(tag,module,channelid,func,tagname,parameters,tagcode,username,edittime) VALUES('$tag','$mod','$thechannelid','$func','$tagname','$parameters','$tagcode','$_username','$timestamp')");
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
		$module = $mod;
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
			case 'picturelist':
			$tag_function='picturelist(templateid,channelid,catid,child,specialid,page,picturenum,titlelen,descriptionlen,iselite,datenum,ordertype,datetype,showcatname,showauthor,showhits,target,cols)';
			break;
			case 'picpicture':
			$tag_function='picpicture(templateid,channelid,catid,child,specialid,page,picturenum,titlelen,descriptionlen,iselite,datenum,ordertype,showtype,showalt,imgwidth,imgheight,cols)';
			break;
			case 'slidepicpicture':
			$tag_function='slidepicpicture(templateid,channelid,catid,child,specialid,picturenum,titlelen,iselite,datenum,ordertype,imgwidth,imgheight,timeout,effectid)';
			break;
		}
		include admintpl('tag_manage');
		break;

	case 'delete':
	    $db->query("DELETE FROM ".TABLE_TAG." WHERE module='$mod' AND channelid=$channelid AND tagid='$tagid' ");
		@$f->unlink(PHPCMS_CACHEDIR."tag/".$tagid.".php");
		showmessage('操作成功！',$referer);
	    break;

	case 'cache':
		cache_tag(0," module='$mod' AND channelid=$channelid ");
		showmessage('操作成功！',$PHP_REFERER);
	    break;
}
?>