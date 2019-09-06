<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once PHPCMS_ROOT.'/include/tree.class.php';
require_once PHPCMS_ROOT.'/include/channel.inc.php';
require_once PHPCMS_ROOT.'/admin/include/category_channel.class.php';

$tree = new tree;

$channelid = isset($channelid) ? intval($channelid) : 0;
if(!$channelid) showmessage($LANG['illegal_parameters']);

$catid = isset($catid) ? intval($catid) : 0;

$cat = new category_channel($channelid, $catid);

$module = $CHANNEL[$channelid]['module'];

$submenu = array
(
	array($LANG['manage_index'], '?mod='.$mod.'&file='.$file.'&channelid='.$channelid.'&action=manage'),
	array($LANG['add_category'], '?mod='.$mod.'&file='.$file.'&channelid='.$channelid.'&action=add'),
	array($LANG['join_category'], '?mod='.$mod.'&file='.$file.'&channelid='.$channelid.'&action=join'),
	array($LANG['update_category_cache'], '?mod='.$mod.'&file='.$file.'&channelid='.$channelid.'&action=updatecache'),
	array($LANG['category_data_repair'], '?mod='.$mod.'&file='.$file.'&channelid='.$channelid.'&action=repair')
);
$menu = adminmenu($LANG['category_manage'], $submenu);

$action = $action ? $action : 'manage';

switch($action)
{
	case 'add':

		if($dosubmit)
		{
		    if(!$category['catname']) showmessage($LANG['category_name_not_null']);
			if(!$category['islink'] && !$category['catdir']) showmessage($LANG['category_dir_not_null']);
			if($category['islink'] && !$category['linkurl']) showmessage($LANG['external_category_linkurl_not_null']);
			
			if(!$category['islink'])
			{
				if(!preg_match("/^[0-9a-z_-]+$/i",$category['catdir'])) showmessage($LANG['catdir_num_alpha']);
				$r = $db->get_one("select catid from ".TABLE_CATEGORY." where catdir='$category[catdir]' and channelid=$channelid ");
				if($r) showmessage($LANG['category_dir_same_in_one_channel']);
            }
            
            $category['urlruleid'] = $category['ishtml'] ? $category['cat_html_urlruleid'] : $category['cat_php_urlruleid'];
            unset($category['cat_html_urlruleid'],$category['cat_php_urlruleid']);

            $setting['arrgroupid_browse'] = isset($arrgroupid_browse) && is_array($arrgroupid_browse) ? implode(',',$arrgroupid_browse) : "";
            $setting['arrgroupid_view'] = isset($arrgroupid_view) && is_array($arrgroupid_view) ? implode(',',$arrgroupid_view) : "";
            $setting['arrgroupid_add'] = isset($arrgroupid_add) && is_array($arrgroupid_add) ? implode(',',$arrgroupid_add) : "";

            $cat->add($category, $setting);

	        showmessage($LANG['operation_success'], '?mod='.$mod.'&file='.$file.'&action=updatecache&channelid='.$channelid.'&forward='.urlencode($forward));
		}
		else
	    {
			$parentid = category_select('category[parentid]',$LANG['no_as_top_category'],$catid);
			$arrgroupid_browse = showgroup("checkbox","arrgroupid_browse[]");
			$arrgroupid_view = showgroup("checkbox","arrgroupid_view[]");
			$arrgroupid_add = showgroup("checkbox","arrgroupid_add[]");
            $templateid = showtpl($module,'category','setting[templateid]');
            $listtemplateid = showtpl($module,'category_list','setting[listtemplateid]');
		    $skinid = showskin('setting[skinid]');
            $defaultitemtemplate = showtpl($module,'content','setting[defaultitemtemplate]');
		    $defaultitemskin = showskin('setting[defaultitemskin]');
			$page_select = '';
			$cat_html_urlrule = urlrule_select('category[cat_html_urlruleid]','html','cat',$CHA['cat_html_urlruleid']);
			$item_html_urlrule = urlrule_select('category[item_html_urlruleid]','html','item',$CHA['item_html_urlruleid']);
			$cat_php_urlrule = urlrule_select('category[cat_php_urlruleid]','php','cat',$CHA['cat_php_urlruleid']);
			$item_php_urlrule = urlrule_select('category[item_php_urlruleid]','php','item',$CHA['item_php_urlruleid']);
		    include admintpl('category_add');
		}
		break;

	case 'edit':
		$catid = intval($catid);
		if(!$catid) showmessage($LANG['illegal_parameters']);

		if($dosubmit)
		{
		    if(!$category['catname']) showmessage($LANG['category_name_not_null']);

            $setting['arrgroupid_browse'] = isset($arrgroupid_browse) && is_array($arrgroupid_browse) ? implode(',',$arrgroupid_browse) : "";
            $setting['arrgroupid_view'] = isset($arrgroupid_view) && is_array($arrgroupid_view) ? implode(',',$arrgroupid_view) : "";
            $setting['arrgroupid_add'] = isset($arrgroupid_add) && is_array($arrgroupid_add) ? implode(',',$arrgroupid_add) : "";

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
				$db->query("UPDATE ".channel_table($CHANNEL[$channelid]['module'], $channelid)." SET ishtml=$ishtml,urlruleid=$item_urlruleid,htmldir='$item_htmldir',prefix='$item_prefix' WHERE catid=$catid AND islink=0");
				$forward = '?mod=phpcms&file=linkurl&action=updatecategory&updatecategory=1&channelid='.$channelid.'&catid='.$catid;
            }
            
			showmessage($LANG['operation_success'], '?mod='.$mod.'&file='.$file.'&action=updatecache&channelid='.$channelid.'&forward='.urlencode($forward));
		}
		else
	    {
			$category = $cat->get_info();
            @extract(new_htmlspecialchars($category));

			$oldparentid = $parentid;
			$parentid = category_select('category[parentid]', $LANG['no_as_top_category'], $parentid);
			$arrgroupid_browse = showgroup("checkbox","arrgroupid_browse[]",$arrgroupid_browse);
			$arrgroupid_view = showgroup("checkbox","arrgroupid_view[]",$arrgroupid_view);
			$arrgroupid_add = showgroup("checkbox","arrgroupid_add[]",$arrgroupid_add);
		    $skinid = showskin('setting[skinid]',$skinid);
            $templateid = showtpl($module,'category','setting[templateid]',$templateid);
            $listtemplateid = showtpl($module,'category_list','setting[listtemplateid]',$listtemplateid);
            $defaultitemtemplate = showtpl($module,'content','setting[defaultitemtemplate]',$defaultitemtemplate);
		    $defaultitemskin = showskin('setting[defaultitemskin]',$defaultitemskin);
		    $cat_html_urlruleid = $ishtml ? $urlruleid : $CHA['cat_html_urlruleid'];
		    $cat_php_urlruleid = $ishtml ? $CHA['cat_php_urlruleid'] : $urlruleid;
			$cat_html_urlrule = urlrule_select('category[cat_html_urlruleid]','html','cat',$cat_html_urlruleid);
			$item_html_urlrule = urlrule_select('category[item_html_urlruleid]','html','item',$item_html_urlruleid);
			$cat_php_urlrule = urlrule_select('category[cat_php_urlruleid]','php','cat',$cat_php_urlruleid);
			$item_php_urlrule = urlrule_select('category[item_php_urlruleid]','php','item',$item_php_urlruleid);
		    include admintpl('category_edit');
		}
		break;

     case 'recycle':
		 $forward = '?mod=phpcms&file=category&action=manage&channelid='.$channelid;
		 $module = $CHANNEL[$channelid]['module'];
		 $table = channel_table($module, $channelid);
		 $catid = intval($catid);
		 $r = $db->get_one("select arrchildid from ".TABLE_CATEGORY." where catid=$catid");
		 $arrchildid = $r['arrchildid'];
		 $db->query("update $table set status=-1 where catid in ($arrchildid)");
		 showmessage($LANG['operation_success'], $forward);
		 break;

     case 'repair':

        $cat->repair();

        showmessage($LANG['operation_success'], $forward);
		break;

     case 'delete':
		 $forward = '?mod=phpcms&file=category&action=manage&channelid='.$channelid;
		 $module = $CHA['module'];
		 $catid = intval($catid);
		 if(!array_key_exists($catid, $CATEGORY)) showmessage($LANG['illegal_parameters'], $forward);

		 $cat->delete();

		 showmessage($LANG['operation_success'], '?mod='.$mod.'&file='.$file.'&action=updatecache&channelid='.$channelid.'&forward='.urlencode($forward));
		 break;

	case 'join':

	    if($dosubmit)
		{
		   $targetcatid = intval($targetcatid);
		   $sourcecatid = intval($sourcecatid);
           if(!$targetcatid || !$sourcecatid) showmessage($LANG['parameters_error'], $forward);
		   if($targetcatid==$sourcecatid) showmessage($LANG['source_not_same_as_distinct_category'],$forward);

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
		$catids = cache_categorys($channelid);
	    foreach($catids as $id)
	    {
            $cat->update_linkurl($id);
		    cache_category($id);
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
				 $module = $CHA['module'];
				 $linkurl = linkurl($category['linkurl']);
				 $catdir = $category['islink'] ? "<a href='$linkurl' title='".$LANG['click_view']."' target='_blank'>".str_cut($linkurl,20)."</a>" : "<a href='$linkurl' title='".$LANG['click_view']."' target='_blank'>".$category['catdir']."</a>";
				 $islink = $category['islink'] ? '<font color="blue">'.$LANG['external_category'].'</font>' : $LANG['internal_category'];
				 $enablepurview = $category['enablepurview'] ? '<font color="blue">'.$LANG['certificate_category'].'</font>' : $LANG['open_category'];
				 $admin = admin_users('catids', $catid);
				 $add_child_cat = $category['islink'] ? '<font color="#CCCCCC">'.$LANG['add_child_category'].'</font>' : "<a href='?mod=$mod&file=$file&action=add&catid=$catid&channelid=$channelid'>".$LANG['add_child_category']."</a>";
				 $clear_cat = $category['islink'] ? '<font color="#CCCCCC">'.$LANG['clear'].'</font>' : "<a href=javascript:confirmurl('?mod=$mod&file=$file&action=recycle&catid=$catid&channelid=$channelid','".$LANG['confirm_clear_category_info']."') >".$LANG['clear']."</a>";
				 $categorys[$category['catid']] = array('id'=>$category['catid'],'parentid'=>$category['parentid'],'name'=>$category['catname'],'islink'=>$islink,'catdir'=>$catdir,'listorder'=>$category['listorder'],'enablepurview'=>$enablepurview,'style'=>$category['style'],'mod'=>$mod,'channelid'=>$channelid,'file'=>$file,'admin'=>$admin,'add_child_cat'=>$add_child_cat,'clear_cat'=>$clear_cat);
			}
			$str = "<tr align='center' align='center' onmouseout=this.style.backgroundColor='#F1F3F5' onmouseover=this.style.backgroundColor='#BFDFFF' bgColor='#F1F3F5'>
						<td><input name='listorder[\$id]' type='text' size='3' value='\$listorder'></td>
						<td>\$id</td>
						<td align='left'>\$spacer<a href='?mod=\$mod&file=\$file&action=edit&catid=\$id&channelid=\$channelid&parentid=\$parentid'><span style='\$style'>\$name</span></a></td>
						<td>\$islink</td>
						<td>\$catdir</td>
						<td>\$enablepurview</td>
						<td>\$admin</td>
						<td>\$add_child_cat | <a href='?mod=\$mod&file=\$file&action=edit&catid=\$id&channelid=\$channelid&parentid=\$parentid'>".$LANG['edit']."</a> | \$clear_cat | <a href=javascript:confirmurl('?mod=\$mod&file=\$file&action=delete&catid=\$id&channelid=\$channelid','".$LANG['confirm_delete_category']."')>".$LANG['delete']."</a></td>
					</tr>";
			$tree->tree($categorys);
			$categorys = $tree->get_tree(0,$str);
		}
		include admintpl('category');
		break;
}
?>