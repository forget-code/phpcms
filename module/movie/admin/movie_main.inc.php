<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once PHPCMS_ROOT.'/include/tree.class.php';
require_once PHPCMS_ROOT.'/admin/include/category_channel.class.php';

$tree = new tree;

!empty($CATEGORY) or showmessage($LANG['logn_add_page'],"?mod=phpcms&file=category&action=add&channelid=$channelid",'form');

$category_select = category_select('catid', $LANG['choose_category'], $catid);
$category_jump = category_select('catid', $LANG['choose_category_add_movie'], $catid, "onchange=\"if(this.value!=''){location='?mod=$mod&file=$file&action=add&job=$job&channelid=$channelid&catid='+this.value;}\"");
$cat = new category_channel($channelid, $catid);
$list = $cat->get_list();
if(is_array($list))
{
	$categorys = array();
	foreach($list as $catid => $category)
	{
		$module = $CHA['module'];
		$linkurl = $category['linkurl'];
		$catdir = $category['islink'] ? "<a href='$linkurl' title='".$LANG['title']."' target='_blank'>".str_cut($linkurl,20)."</a>" : "<a href='$linkurl' title='".$LANG['title']."' target='_blank'>".$category['catdir']."</a>";
		//if($CHA['ishtml'])
	
		$createlist = ' | <a href="?mod='.$module.'&file=createhtml&action=per_list&catid='.$category['catid'].'&channelid='.$channelid.'" title="'.$LANG['generat_information_list'].'">'.$LANG['generat_list'].'</a>';
		$createshow =  ' | <a href="?mod='.$module.'&file=createhtml&action=per_show&catid='.$category['catid'].'&channelid='.$channelid.'" title="'.$LANG['generat_movie_category'].'">'.$LANG['movie_generat'].'</a>';

		if($category['child'] && !$category['enableadd'])
		{
			$addmovie = "<font color=\"#CCCCCC\">".$LANG['add_movie']."</font>";
		}
		else
		{
			$addmovie = "<a href=\"?mod=$mod&file=$file&action=add&catid=$catid&channelid=$channelid\"><font color=\"red\">".$LANG['add_movie']."</font></a>";
		}
		$categorys[$category['catid']] = array('id'=>$category['catid'],'parentid'=>$category['parentid'],'name'=>$category['catname'],'catdir'=>$catdir,'listorder'=>$category['listorder'],'style'=>$category['style'],'items'=>$category['items'],'createlist'=>$createlist,'createshow'=>$createshow,'mod'=>$mod,'channelid'=>$channelid,'file'=>$file, 'addmovie'=>$addmovie);
	}
	$str = "<tr align='center' align='center' onmouseout=this.style.backgroundColor='#F1F3F5' onmouseover=this.style.backgroundColor='#BFDFFF' bgColor='#F1F3F5' height='23'>
				<td>\$id</td>
				<td align='left'>\$spacer<a href='?mod=\$mod&file=\$file&action=manage&catid=\$id&channelid=\$channelid'><span style='\$style'>\$name</span></a></td>
				<td>\$items</td>
				<td>\$addmovie | <a href='?mod=\$mod&file=\$file&action=manage&catid=\$id&channelid=\$channelid'>".$LANG['manage_movie']."</a> | <a href='?mod=\$mod&file=\$file&action=manage&job=check&catid=\$id&channelid=\$channelid'>".$LANG['check_movie']."</a> | <a href='?mod=\$mod&file=\$file&action=manage&job=recycle&catid=\$id&channelid=\$channelid'>".$LANG['recycle_bin']."</a>\$createlist \$createshow</td>
			</tr>";
	$tree->tree($categorys);
	$categorys = $tree->get_tree(0,$str);
}
include admintpl($mod.'_main');
?>