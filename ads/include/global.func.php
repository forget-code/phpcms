<?php
defined('IN_PHPCMS') or exit('Access Denied');

function get_type($type)
{
  global $LANG;
  if($type=='image') return $LANG['image'];
  elseif($type=='flash') return 'FLASH';
  elseif($type=='text') return $LANG['text'];
  elseif($type=='code') return $LANG['code'];
  else return $LANG['unkown'];
}

function ads_content($ads, $isjs = 1)
{
	if (!is_array($ads)) return "";
	@extract($ads);
	switch ($type)
	{
		case 'image':
			$content[0] = $isjs ? format_js(ads_image($adsid, $linkurl, $imageurl, $width, $height, $alt, $adsname), 1) : ads_image($adsid, $linkurl, $imageurl, $width, $height, $alt, $adsname);
			if($s_imageurl)
			{
				$content[1] = $isjs ? format_js(ads_image($adsid, $linkurl, $s_imageurl, $width, $height, $alt, $adsname), 1) : ads_image($adsid, $linkurl, $s_imageurl, $width, $height, $alt, $adsname);
			}
			$isjs = 0;
		break;

		case 'flash':
			$content = ads_flash($adsid, $flashurl, $width, $height, $wmode = 'transparent');
		break;

		case 'text':
			$content = ads_text($adsid, $text);
		break;

		case 'code':
			$content = ads_code($adsid, $code, $linkurl);
		break;
	}
	return $isjs ? format_js($content, 1) : $content;
}

function ads_image($id, $linkurl, $imageurl, $width, $height, $alt = '', $adsname = '')
{
	global $M;
	$url = $M['enableadsclick'] ? SITE_URL.'ads/clickads.php?id='.$id : $linkurl;
	if($linkurl)
	{
		$adsimg = "<a href='".$url."' target='_blank'><img src='".$imageurl."' border='0' width='".$width."' height='".$height."' alt='".$alt."'></a>";
	}
	else
	{
		$adsimg = "<div><img src='".$imageurl."' border='0' width='".$width."' height='".$height."' alt='".$alt."'></div>";
	}
	return $adsimg;
}

function ads_flash($id, $flashurl, $width, $height, $wmode = 'transparent')
{
	$adsfla = "<div><object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0' width='".$width."' height='".$height."'>
	<param name='movie' value='".$flashurl."' /><param name='quality' value='high' />
	".($wmode ? "<param name='wmode' value='transparent' />" : "") ."
	<embed src='".$flashurl."' width='".$width."' height='".$height."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash'>
	</embed>
	</object></div>";
	return $adsfla;
}

function url_absolutive($url){
	if(substr($url,0,7)!='http://' and substr($url,0,8)!='https://' and substr($url,0,1)!='/')
		$url='http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/'.$url;
	return $url;
}

function ads_text($id, $text)
{

	$adstxt = new_htmlspecialchars($text);
	return '<div>'.$adstxt.'</div>';
}

function ads_code($id, $code, $linkurl)
{
	global $M;
	$url = $M['enableadsclick'] ? SITE_URL.'ads/clickads.php?id='.$id : $linkurl;
	if($linkurl)
	{
		$adscode = '<span><a href="'.$url.'">'.new_htmlspecialchars($code).'</a></span>';
	}
	else
	{
		$adscode = new_htmlspecialchars($code);
	}
	return '<div>'.$adscode.'</div>';
}

function  fileedit($name,$value,$id='',$size=50,$class='',$ext=''){
	if(!$id) $id = $name;
	return "$value<br/><input type=\"file\" name=\"$name\" id=\"$id\" size=\"$size\" class=\"$class\" $ext/> ";
}

function select_category_multi($module = 'phpcms', $parentid = 0, $name = 'catids', $id ='', $alt = '', $catids = 0, $property = ''){
	global $tree, $CATEGORY;
	if(!is_object($tree))
	{
		require_once 'tree.class.php';
		$tree = new tree;
	}
	if(!$property)$property=" multiple='multiple' size='10' ";
	if(!$id) $id = $name;
	$data = "<select name='$name' id='$id' $property>\n";
	$data .= "<option value='0' ".($catids?'':" selected='selected' ").">".$alt."</option>\n";
	if(is_array($CATEGORY))
	{
		$categorys = array();
		foreach($CATEGORY as $id=>$cat)
		{
			if($cat['module'] == $module) $categorys[$id] = array('id'=>$id, 'parentid'=>$cat['parentid'], 'name'=>$cat['catname']);
		}
		$tree->tree($categorys);
		$data .= $tree->get_tree_multi($parentid, "<option value='\$id' \$selected>\$spacer\$name</option>\n", $catids);
	}
	$data .= '</select>';
	return $data;
}
?>