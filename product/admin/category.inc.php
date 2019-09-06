<?php
defined('IN_PHPCMS') or exit('Access Denied');
require_once PHPCMS_ROOT.'/include/tree.class.php';
require_once PHPCMS_ROOT.'/admin/include/category_module.class.php';
require_once PHPCMS_ROOT.'/'.$mod.'/include/formselect.func.php';
$catid = isset($catid) ? intval($catid) : 0;
$module = $mod;

$tree = new tree;

$cat = new category_module($mod, $catid);

$submenu = array
(
	array($LANG['manage_index'], '?mod='.$mod.'&file='.$file.'&action=manage'),
	array($LANG['add_category'], '?mod='.$mod.'&file='.$file.'&action=add'),
	array($LANG['join_category'], '?mod='.$mod.'&file='.$file.'&action=join'),
	array($LANG['update_category_cache'], '?mod='.$mod.'&file='.$file.'&action=updatecache'),
	array($LANG['category_data_repair'], '?mod='.$mod.'&file='.$file.'&action=repair')
);

$menu = adminmenu($LANG['category_manage'],$submenu);

$action = $action ? $action : 'manage';

switch($action)
{
	case 'add':

		if($dosubmit)
		{
		    if(!$category['catname']) showmessage($LANG['category_name_not_null']);
			if($category['islink']==1 && !$category['catdir']) showmessage($LANG['category_dir_not_null']);
			if($category['islink']==0 && !$category['linkurl']) showmessage($LANG['external_category_linkurl_not_null']);
			
			$category['urlruleid'] = $category['ishtml'] ? $category['cat_html_urlruleid'] : $category['cat_php_urlruleid'];
            unset($category['cat_html_urlruleid'],$category['cat_php_urlruleid']);			
			if(!$category['islink'])
			{
				$r = $db->get_one("select catid from ".TABLE_CATEGORY." where catdir='$category[catdir]' and channelid=$channelid ");
				if($r) showmessage($LANG['category_dir_same_in_one_channel']);
            }

            $cat->add($category, $setting);

	        showmessage($LANG['operation_success'], '?mod='.$mod.'&file='.$file.'&action=updatecache&forward='.urlencode($forward));
		}
		else
	    {
			$parentid = category_select('category[parentid]',$LANG['no_as_top_category'],$catid);
            $templateid = showtpl($module,'category','setting[templateid]');
            $listtemplateid = showtpl($module,'category_list','setting[listtemplateid]');
		    $skinid = showskin('setting[skinid]','product');
            $defaultitemtemplate = showtpl($module,'content','setting[defaultitemtemplate]');
		    $defaultitemskin = showskin('setting[defaultitemskin]','product');
			$page_select = page_select(0,"onchange='document.myform.linkurl.value=this.value'");
			$producttypeselect = property_select('setting[relatedtype]',$LANG['select_product_property'], " id='relatedtype'");
			
			$cat_html_urlrule = product_urlrule_select('category[cat_html_urlruleid]','html','cat',$MOD['cat_html_urlruleid']);
			$item_html_urlrule = product_urlrule_select('category[item_html_urlruleid]','html','item',$MOD['item_html_urlruleid']);
			$cat_php_urlrule = product_urlrule_select('category[cat_php_urlruleid]','php','cat',$MOD['cat_php_urlruleid']);
			$item_php_urlrule = product_urlrule_select('category[item_php_urlruleid]','php','item',$MOD['item_php_urlruleid']);

		    include admintpl('category_add');
		}
		break;

	case 'edit':
		$catid = intval($catid);
		if(!$catid) showmessage($LANG['illegal_parameters']);

		if($dosubmit)
		{
		    if(!$category['catname']) showmessage($LANG['category_name_not_null']);
            $category['urlruleid'] = $category['ishtml'] ? $category['cat_html_urlruleid'] : $category['cat_php_urlruleid'];
            unset($category['cat_html_urlruleid'],$category['cat_php_urlruleid']);
            
            $cat->edit($category, $setting);

			if($createtype_application)
			{
				$ishtml = $category['ishtml'];
				$htmldir = $category['htmldir'];
				$prefix = $category['prefix'];
				$urlruleid = $category['urlruleid'];
				$item_htmldir = $category['item_htmldir'];
				$item_prefix = $category['item_prefix']; 
                $item_html_urlruleid = $category['item_html_urlruleid'];
                $item_php_urlruleid = $category['item_php_urlruleid'];
				$item_urlruleid = $ishtml ? $category['item_html_urlruleid'] : $category['item_php_urlruleid'];
				$arrchildid = $CATEGORY[$catid]['arrchildid'];
				$db->query("UPDATE ".TABLE_CATEGORY." SET ishtml=$ishtml,urlruleid=$urlruleid,htmldir='$htmldir',prefix='$prefix',item_htmldir='$item_htmldir',item_prefix='$item_prefix',item_html_urlruleid=$item_html_urlruleid,item_php_urlruleid=$item_php_urlruleid WHERE catid IN($arrchildid)");
				$db->query("UPDATE ".TABLE_PRODUCT." SET ishtml=$ishtml,urlruleid=$item_urlruleid,htmldir='$item_htmldir',prefix='$item_prefix' WHERE catid=$catid");
				$forward = '?mod=phpcms&file=linkurl&action=updatecategory&updatecategory=1&module='.$mod.'&catid='.$catid;
            }

			showmessage($LANG['operation_success'], '?mod='.$mod.'&file='.$file.'&action=updatecache&forward='.urlencode($forward));
		}
		else
	    {
			$category = $cat->get_info();
            @extract(new_htmlspecialchars($category));           

			$oldparentid = $parentid;
			$parentid = category_select('category[parentid]',$LANG['no_as_top_category'],$parentid);
		    $skinid = showskin('setting[skinid]',$skinid);
            $templateid = showtpl($module,'category','setting[templateid]',$templateid);
            $listtemplateid = showtpl($module,'category_list','setting[listtemplateid]',$listtemplateid);
            $defaultitemtemplate = showtpl($module,'content','setting[defaultitemtemplate]',$defaultitemtemplate);
		    $defaultitemskin = showskin('setting[defaultitemskin]',$defaultitemskin);
		    $producttypeselect = property_select('setting[relatedtype]',$LANG['select_product_property'], " id='relatedtype' " ,$relatedtype);
		    
		    $cat_html_urlruleid = $ishtml ? $urlruleid : $MOD['cat_html_urlruleid'];
		    $cat_php_urlruleid = $ishtml ? $MOD['cat_php_urlruleid'] : $urlruleid;		    
		    $cat_html_urlrule = product_urlrule_select('category[cat_html_urlruleid]','html','cat',$cat_html_urlruleid);
			$item_html_urlrule = product_urlrule_select('category[item_html_urlruleid]','html','item',$item_html_urlruleid);
			$cat_php_urlrule = product_urlrule_select('category[cat_php_urlruleid]','php','cat',$cat_php_urlruleid);
			$item_php_urlrule = product_urlrule_select('category[item_php_urlruleid]','php','item',$item_php_urlruleid);
			
		    include admintpl('category_edit');
		}
		break;

     case 'recycle':
		 $forward = '?mod=product&file=category&action=manage';
		 $module = $mod;
		 $catid = intval($catid);
		 $r=$db->get_one("select arrchildid from ".TABLE_CATEGORY." where catid=$catid");
		 $arrchildid = $r['arrchildid'];
		 $db->query("update $tablepre$module set recycle=1 where catid in ($arrchildid)");
		 $forward = "?mod=phpcms&file=category&action=manage&channelid=".$channelid;
		 showmessage($LANG['operation_success'], $forward);
		 break;

     case 'repair':

        $cat->repair();

        showmessage($LANG['operation_success'], $forward);
		break;

     case 'delete':
		 $forward = '?mod=product&file=category&action=manage';
		 $module = $mod;
		 $catid = intval($catid);
		 $r = $db->get_one("select * from ".TABLE_CATEGORY." where catid=$catid");
		 if(!$r) showmessage($LANG['illegal_parameters'], $forward);

         $cat->delete();
		 showmessage($LANG['operation_success'], $forward);
		 break;

	case 'join':

	    if($dosubmit)
		{
		   $targetcatid = intval($targetcatid);
		   $sourcecatid = intval($sourcecatid);
           if(!$targetcatid || !$sourcecatid) showmessage($LANG['parameters_error'], $forward);
		   if($targetcatid == $sourcecatid) showmessage($LANG['source_not_same_as_distinct_category'],$forward);

           $target = $cat->get_info($targetcatid);
           if($target['child']==1 && $target['enableadd']==0) showmessage($LANG['distinct_category_has_child_banned_add_information']);

           if($target['arrparentid'])
		   {
              $arrparentid = explode(",", $r['arrparentid']);
              if(in_array($sourcecatid,$arrparentid)) showmessage($LANG['distinct_is_the_child_of_source_category_cannot_join']);
           }

           $source = $cat->get_info($sourcecatid);
		  
           $cat->join($sourcecatid, $targetcatid);
		   showmessage($LANG['operation_success'], $forward);
		}
		else
		{
			$category_source = category_select('sourcecatid', $LANG['please_select'], $catid);
			$category_target = category_select('targetcatid', $LANG['please_select'], $catid);

			include admintpl('category_join');
		}
		break;

    case 'listorder':
		$cat->listorder($listorder);
		showmessage($LANG['operation_success'], $forward);
        break;

	case 'updatecache':
		$catids = cache_categorys($mod);
	    foreach($catids as $catid)
	    {
            $cat->update_linkurl($catid);
		    cache_category($catid);
	    }
		showmessage($LANG['category_cache_update_success'], $forward);
		break;

	case 'manage':
		$list = $cat->get_list();

		if(is_array($list))
	    {
			$categorys = array();
			foreach($list as $catid => $category)
			{
				$module = $mod;
				$islink = $category['islink'] ? '<font color="blue">'.$LANG['external_category'].'</font>' : $LANG['internal_category'];
				$linkurl = linkurl($category['linkurl']);
				$catdir = $category['islink'] ? "<a href='$linkurl' title='".$LANG['click_view']."' target='_blank'>".str_cut($linkurl,20)."</a>" : "<a href='$linkurl' title='".$LANG['click_view']."' target='_blank'>".$category['catdir']."</a>";

				if(($category['enableadd'] || $category['child']==0) && !$category['islink'])
				{ 
					$strhref = "<a href='?mod=$mod&file=product&action=add&catid=".$category['catid']."'><font color='red'>".$LANG['add_product']."</font></a>";
				}
				else 
				{
					$strhref = "<font color='#CCCCCC'>".$LANG['add_product']."</font>";
				}
				$categorys[$category['catid']] = array('id'=>$category['catid'],'parentid'=>$category['parentid'],'name'=>$category['catname'],'islink'=>$islink,'catdir'=>$catdir,'listorder'=>$category['listorder'],'style'=>$category['style'],'mod'=>$mod,'file'=>$file,'addhref'=>$strhref);
			}
			$str = "<tr align='center' align='center' onmouseout=this.style.backgroundColor='#F1F3F5' onmouseover=this.style.backgroundColor='#BFDFFF' bgColor='#F1F3F5'>
						<td><input name='listorder[\$id]' type='text' size='3' value='\$listorder'></td>
						<td>\$id</td>
						<td align='left'>\$spacer<a href='?mod=\$mod&file=\$file&action=edit&catid=\$id&parentid=\$parentid'><span style='\$style'>\$name</span></a></td>
						<td>\$islink</td>
						<td>\$catdir</td>
						<td></td>
						<td>\$addhref | <a href='?mod=\$mod&file=\$file&action=add&catid=\$id'>".$LANG['add_child_category']."</a> | <a href='?mod=\$mod&file=\$file&action=edit&catid=\$id&parentid=\$parentid'>".$LANG['edit']."</a> | <a href=javascript:confirmurl('?mod=\$mod&file=\$file&action=recycle&catid=\$id','".$LANG['confirm_clear_category_info']."') >".$LANG['clear']."</a> | <a href=javascript:confirmurl('?mod=\$mod&file=\$file&action=delete&catid=\$id','".$LANG['confirm_delete_category']."')>".$LANG['delete']."</a></td></tr>";
			$tree->tree($categorys);
			$categorys = $tree->get_tree(0,$str);
		}
		include admintpl('category');
		break;
}
?>