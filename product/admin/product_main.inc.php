<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once PHPCMS_ROOT.'/include/tree.class.php';
require_once PHPCMS_ROOT.'/admin/include/category_module.class.php';

$tree = new tree;

!empty($CATEGORY) or showmessage($LANG['add_category_first'],"?mod=product&file=category&action=add",'form');

$category_select = category_select('catid', $LANG['select_category'], $catid);
$category_jump = category_select('catid', $LANG['select_category_then_add_product'], $catid, "onchange=\"if(this.value!=''){location='?mod=$mod&file=$file&action=add&job=$job&catid='+this.value;}\"");
$cat = new category_module($mod, $catid);
$list = $cat->get_list();
if(is_array($list))
{
	$categorys = array();
	foreach($list as $catid => $category)
	{
		$module = $mod;
		$linkurl = $category['linkurl'];
		$catdir = $category['islink'] ? "<a href='$linkurl' title='".$LANG['click_view']."' target='_blank'>".str_cut($linkurl,20)."</a>" : "<a href='$linkurl' title='".$LANG['click_view']."' target='_blank'>".$category['catdir']."</a>";
		//if($MOD['ishtml'])
	
		$createlist = ' | <a href="?mod='.$module.'&file=createhtml&action=list&catid='.$category['catid'].'" title="'.$LANG['generate_category_info_list'].'">'.$LANG['generate_list'].'</a>';
		$createshow =  ' | <a href="?mod='.$module.'&file=createhtml&action=cat_product&catid='.$category['catid'].'" title="'.$LANG['generate_list_product'].'">'.$LANG['generate_product'].'</a>';

		if($category['child'] && !$category['enableadd'])
		{
			$addarticle = "<font color=\"#CCCCCC\">".$LANG['add_product']."</font>";
		}
		else
		{
			$addarticle = "<a href=\"?mod=$mod&file=$file&action=add&catid=$catid\"><font color=\"red\">".$LANG['add_product']."</font></a>";
		}
		$categorys[$category['catid']] = array('id'=>$category['catid'],'parentid'=>$category['parentid'],'name'=>$category['catname'],'catdir'=>$catdir,'listorder'=>$category['listorder'],'style'=>$category['style'],'items'=>$category['items'],'createlist'=>$createlist,'createshow'=>$createshow,'mod'=>$mod,'channelid'=>$channelid,'file'=>$file, 'addarticle'=>$addarticle);
	}
	$str = "<tr align='center' align='center' onmouseout=this.style.backgroundColor='#F1F3F5' onmouseover=this.style.backgroundColor='#BFDFFF' bgColor='#F1F3F5' height='23'>
				<td>\$id</td>
				<td align='left'>\$spacer<a href='?mod=\$mod&file=\$file&action=manage&catid=\$id'><span style='\$style'>\$name</span></a></td>
				<td>\$items</td>
				<td>\$addarticle | <a href='?mod=\$mod&file=\$file&action=manage&catid=\$id'>".$LANG['product_manage']."</a> | <a href='?mod=\$mod&file=\$file&action=manage&job=recycle&catid=\$id'>".$LANG['recycle']."</a>\$createlist \$createshow</td>
			</tr>";
	$tree->tree($categorys);
	$categorys = $tree->get_tree(0,$str);
}
include admintpl($mod.'_main');

foreach($CATEGORY AS $cate)
{
	//更新档案数量
	$r = $db->get_one("SELECT count(productid) as num FROM ".TABLE_PRODUCT." WHERE catid=".$cate['catid']);
	$items = $r['num'];
	$db->query("UPDATE  ".TABLE_CATEGORY." SET items=$items WHERE catid=".$cate['catid']);
	
	cache_category($cate['catid']);

}
?>