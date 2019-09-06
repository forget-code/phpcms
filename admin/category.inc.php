<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once 'tree.class.php';
require_once 'admin/category.class.php';

$tree = new tree;
$catid = isset($catid) ? intval($catid) : 0;
$cat = new category($mod);

$action = $action ? $action : 'manage';
if(!$forward) $forward = '?mod='.$mod.'&file='.$file.'&action=manage';
switch($action)
{
	case 'add':
		if($dosubmit)
		{
		    if(!$category['catname']) showmessage($LANG['category_name_not_null']);
			$category['catname'] = trim($category['catname']);
			$category['catdir'] = trim($category['catdir']);
			$catid = $cat->add($category, $setting);
			$priv_group->update('catid', $catid, $priv_groupid);
			$priv_role->update('catid', $catid, $priv_roleid);
			cache_common();
	        showmessage('添加成功！开始更新网站地图...', '?mod=phpcms&file=sitemap&dosubmit=1&forward='.urlencode($forward));
		}
		else
	    {
			if(!isset($type))
			{
				$modelid = 0;
				if(isset($catid) && isset($CATEGORY[$catid]))
				{
					$modelid = $CATEGORY[$catid]['modelid'];
				}
			}
		    include admin_tpl('category_add');
		}
		break;

	case 'edit':
		$catid = intval($catid);
		if(!$catid) showmessage($LANG['illegal_parameters']);
		if($catid == $category['parentid']) showmessage('当前栏目不能与上级栏目相同');
		if($dosubmit)
		{
		    if(!$category['catname']) showmessage($LANG['category_name_not_null']);
			$category['catname'] = trim($category['catname']);
			$category['catdir'] = trim($category['catdir']);
			$cat->edit($catid, $category, $setting);
			$priv_group->update('catid', $catid, $priv_groupid);
			$priv_role->update('catid', $catid, $priv_roleid);
			showmessage('操作成功！开始更新网站地图...', '?mod=phpcms&file=sitemap&dosubmit=1&forward='.urlencode($forward));
		}
		else
	    {
			$category = $cat->get($catid);
            @extract(new_htmlspecialchars($category));
			if($type == 1)
			{
				$priv_roleids = $priv_role->get_roleid('catid', $catid);
				$priv_roleids = implodeids($priv_roleids);
				$priv_groupids = $priv_group->get_groupid('catid', $catid);
				$priv_groupids = implodeids($priv_groupids);
			}
		    include admin_tpl('category_edit');
		}
		break;

     case 'repair':

        $cat->repair();
        showmessage('更新成功', $forward);
		break;

     case 'delete':
		 if(!array_key_exists($catid, $CATEGORY)) showmessage($LANG['illegal_parameters'], '?mod=phpcms&file=category&action=manage');
		 $cat->delete($catid);
		 showmessage($LANG['operation_success'], '?mod='.$mod.'&file='.$file.'&action=updatecache&forward='.urlencode('?mod=phpcms&file=category&action=manage'));
		 break;

	case 'join':

	    if($dosubmit)
		{
			$targetcatid = intval($targetcatid);
			$sourcecatid = intval($sourcecatid);
			if(!$targetcatid || !$sourcecatid) showmessage('源栏目或目标栏目没有选择', $forward);
			if($targetcatid==$sourcecatid) showmessage($LANG['source_not_same_as_distinct_category'],$forward);

			$target = $cat->get($targetcatid);
			if($target['child']==1) showmessage($LANG['distinct_category_has_child_banned_add_information']);

			if($target['arrparentid'])
			{
				$arrparentid = explode(",", $r['arrparentid']);
				if(in_array($sourcecatid,$arrparentid)) showmessage($LANG['distinct_is_the_child_of_source_category_cannot_join']);
			}

			$source = $cat->get($sourcecatid);
			$cat->join($sourcecatid, $targetcatid);

		   showmessage($LANG['operation_success'], $forward);
		}
		else
		{
			foreach($CATEGORY AS $catid=>$c)
			{
				if($c['type']!=0) unset($CATEGORY[$catid]);
			}
			include admin_tpl('category_join');
		}
		break;

    case 'listorder':
		$cat->listorder($listorder);
		showmessage($LANG['operation_success'], $forward);
        break;

	case 'recycle':
		$cat->recycle($catid);
		showmessage($LANG['operation_success'], '?mod='.$mod.'&file='.$file.'&action=manage');
        break;
	case 'checkcategory':
		if($CATEGORY[$targetcatid]['modelid'] != $CATEGORY[$sourcecatid]['modelid'])
		{
			echo -1;
		}
		elseif($CATEGORY[$targetcatid]['child'])
		{
			echo -2;
		}
		elseif($targetcatid == $sourcecatid)
		{
			echo -3;
		}
		elseif(in_array($targetcatid,explode(',',$CATEGORY[$sourcecatid]['arrchildid'])))
		{
			echo -4;
		}
        break;

	case 'updatecache':
		cache_common();
		cache_category();
		showmessage($LANG['category_cache_update_success'], $forward);
		break;

	case 'manage':
		if(count($CATEGORY) < 50)
		{
			$data = $cat->listinfo();
			$categorys = array();
			foreach($data as $catid => $category)
			{
				 $url = url($category['url']);
				 $type = $category['type'] == 0 ? '内部栏目' : ($category['type'] == 1 ? '<font color="blue">单网页</font>' : '<font color="red">外部链接</font>');
				 $model = $category['type'] == 0 ? '<a href="?mod=phpcms&file=model_field&action=manage&modelid='.$category['modelid'].'">'.$MODEL[$category['modelid']]['name'].'</a>' : '';
				 $add_child_cat = $category['type'] ? '<font color="#CCCCCC">'.$LANG['add_child_category'].'</font>' : "<a href='?mod=$mod&file=$file&action=add&catid=$catid'>".$LANG['add_child_category']."</a>";
				 $clear_cat = $category['type'] ? '<font color="#CCCCCC">'.$LANG['clear'].'</font>' : "<a href=javascript:confirmurl('?mod=$mod&file=$file&action=recycle&catid=$catid','".$LANG['confirm_clear_category_info']."') >".$LANG['clear']."</a>";
				 $move_content = $category['type'] ? '<font color="#CCCCCC">移动</font>' : "<a href='?mod=$mod&file=content_all&action=move&catid=$catid'>移动</a>";
				 $categorys[$category['catid']] = array('id'=>$category['catid'],'parentid'=>$category['parentid'],'name'=>str_replace(' ','&nbsp;',$category['catname']),'type'=>$type,'catdir'=>$catdir,'url'=>$url,'listorder'=>$category['listorder'],'model'=>$model,'style'=>$category['style'],'items'=>$category['items'],'hits'=>$category['hits'],'mod'=>$mod,'file'=>$file,'add_child_cat'=>$add_child_cat,'clear_cat'=>$clear_cat,'move_content'=>$move_content);
			}
			$str = "<tr>
						<td class='align_c'><input name='listorder[\$id]' type='text' size='3' value='\$listorder'></td>
						<td class='align_c'>\$id</td>
						<td>\$spacer<a href='?mod=\$mod&file=\$file&action=edit&catid=\$id&parentid=\$parentid'><span class='\$style'>\$name</span></a></td>
						<td class='align_c'>\$type</td>
						<td class='align_c'>\$model</td>
						<td class='align_c'><a href='?mod=phpcms&file=content&action=manage&catid=\$id' title='管理内容'>\$items</a></td>
						<td class='align_c'><a href='\$url' target='_blank'>访问</a></td>
						<td class='align_c'>\$add_child_cat | <a href='?mod=\$mod&file=\$file&action=edit&catid=\$id&parentid=\$parentid'>".$LANG['edit']."</a> | \$move_content | \$clear_cat | <a href=javascript:confirmurl('?mod=\$mod&file=\$file&action=delete&catid=\$id','确认删除{\$name}栏目吗？') >".$LANG['delete']."</a></td>
					</tr>";
			$tree->tree($categorys);
			$categorys = $tree->get_tree(0, $str);
			include admin_tpl('category');
		}
		else
	    {
		    $parentid = (isset($catid) && $catid) ? intval($catid) : 0;
			$data = $cat->listinfo($parentid);
			include admin_tpl('category_manage');
		}
		break;
	case 'urlrule':
		$ishtml = intval($ishtml);
		$category_urlruleid = intval($category_urlruleid);
		echo form::select_urlrule('phpcms', 'category', $ishtml, 'setting[category_urlruleid]', 'category_urlruleid', $category_urlruleid);
		break;
	case 'checkdir':
		if(!preg_match("/[a-zA-Z0-9_-]+$/i",$value)) exit('栏目目录名称只能为字母、数字、下划线，中划线');
		if($catdir == trim($value)) exit('success');
		foreach($CATEGORY AS $k=>$v)
		{
			if($v['parentid'] == $parentid && $v['catdir'] == trim($value)) exit('栏目目录名称不能重复');
		}
		if($parentid == 0 && isset($MODULE[$value])) exit('栏目目录名称不能重复');
		exit('success');
		break;
	case 'checkname':
		if($catname == trim($value)) exit('success');
		foreach($CATEGORY AS $k=>$v)
		{
			if($v['parentid'] == $parentid && $v['catname'] == trim($value)) exit('栏目名称不能重复');
		}
		exit('success');
		break;
    case 'more':
        if($dosubmit)
		{
            $category['catname'] = array_map("trim", $category['catname']);
			$category['catdir'] = array_map("trim",$category['catdir']);
            $c = $s = array();
            $c['type'] = $category['type'];
            $c['parentid'] = $category['parentid'];
            $c['modelid'] = $category['modelid'];

            $s['presentpoint'] = $setting['presentpoint'];
            $s['defaultchargepoint'] = $setting['defaultchargepoint'];
            $s['repeatchargedays'] = $setting['repeatchargedays'];
            $s['template_category'] = $setting['template_category'];
            $s['template_list'] = $setting['template_list'];
            $s['template_show'] = $setting['template_show'];
            $s['template_print'] = $setting['template_print'];
            foreach($category['catname'] AS $key => $value)
            {
                if(!empty($value) && !empty($category['catdir'][$key]))
                {
                    $c['catname'] = $category['catname'][$key];
                    $c['catdir'] = $category['catdir'][$key];
                    $c['ismenu'] = $category['ismenu'][$key];

                    $s['workflowid'] = $setting['workflowid'][$key];
                    $s['meta_title'] = $setting['meta_title'][$key];
                    $s['meta_keywords'] = $setting['meta_keywords'][$key];
                    $s['meta_description'] = $setting['meta_description'][$key];
                    $catid = $cat->add($c, $s);
                    $priv_group->update('catid', $catid, $priv_groupid);
                    $priv_role->update('catid', $catid, $priv_roleid);
                    cache_common();
                }
                else
                {
                    unset($category['catname'][$key]);
                    unset($category['catdir'][$key]);
                    continue;
                }
            }
			if(!$catid) showmessage('添加失败', '?mod=phpcms&file=category&action=more');
	        showmessage('添加成功', $forward);
		}
		else
	    {
			if(!isset($type))
			{
				$modelid = 0;
				if(isset($catid) && isset($CATEGORY[$catid]))
				{
					$modelid = $CATEGORY[$catid]['modelid'];
				}
			}
		    include admin_tpl('category_more');
		}
        break;
}
?>