<?php
defined('IN_PHPCMS') or exit('Access Denied');
$types = array('member'=>'用户');
if(!$forward) $forward = "?mod=member&file=tag&action=manage&module=member";
require 'admin/tag.class.php';
$t = new tag($mod);
$orderfields = array('a.userid ASC'=>'用户ID升序', 'a.userid DESC'=>'用户ID降序','a.amount ASC'=>'金钱升序','a.amount DESC'=>'金钱降序', 'a.point ASC'=>'积分升序', 'a.point DESC'=>'积分降序');
$menu = admin_menu($LANG['member_manage']);
switch($action)
{
    case 'add':
		
		require CACHE_MODEL_PATH.'member_tag_form.class.php';
		$member_tag_form = new member_tag_form($modelid);
		$forminfos = $member_tag_form->get();
		$fields = $orderfields = $selectfields = array();
		$defalut_fields = $member_tag_form->default_fields;
		foreach($member_tag_form->fields as $field=>$v)
		{
			$fields[$field] = $v['name'];
			if($v['isselect']) $selectfields[] = $field;
			if($v['isorder'])
			{		
				if(in_array($field, array_keys($member_tag_form->common_fields)))
				{
					$orderfields['a.'.$field.' ASC'] = $v['name'].' 升序';
					$orderfields['a.'.$field.' DESC'] = $v['name'].' 降序';
				}
				else
				{
					$orderfields['b.'.$field.' ASC'] = $v['name'].' 升序';
					$orderfields['b.'.$field.' DESC'] = $v['name'].' 降序';
				}	
			}
		}
		$selectfields = implode(',', $selectfields);
		if(isset($tag_config)) extract($tag_config);
		include admin_tpl('tag_add');
	break;
	case 'edit':
		$tagname = preg_replace("/^[^{]*[{]?tag_([^}]+)[}]?.*/", "\\1", trim($tagname));
		$tag_config = $t->get_tag_config($tagname);
		if($modelid) $tag_config['modelid'] = $modelid;
		if($tag_config) extract($tag_config);
		require CACHE_MODEL_PATH.'member_tag_form.class.php';
		$member_tag_form = new member_tag_form($modelid);
		$forminfos = $member_tag_form->get($where);
		$fields = $orderfields = array();
		foreach($member_tag_form->fields as $field=>$v)
		{
			$fields[$field] = $v['name'];
			if(in_array($field, array_keys($member_tag_form->common_fields)))
			{
				$orderfields['a.'.$field.' ASC'] = $v['name'].' 升序';
				$orderfields['a.'.$field.' DESC'] = $v['name'].' 降序';
			}
			else
			{
				$orderfields['b.'.$field.' ASC'] = $v['name'].' 升序';
				$orderfields['b.'.$field.' DESC'] = $v['name'].' 降序';
			}	
		}
		$tpl = !$ajax ? 'tag_edit': 'tag_edit_ajax';
		
		$selectfields = implode(',', $selectfields);
		include admin_tpl($tpl);
		break;
	case 'copy':
		$tagname = preg_replace("/^[^{]*[{]?tag_([^}]+)[}]?.*/", "\\1", trim($tagname));
		$tag_config = $t->get_tag_config($tagname);
		if($modelid) $tag_config['modelid'] = $modelid;
		if($tag_config) extract($tag_config);

		require CACHE_MODEL_PATH.'member_tag_form.class.php';
		$member_tag_form = new member_tag_form($modelid);
		$forminfos = $member_tag_form->get($where);
		$fields = $orderfields = array();
		foreach($member_tag_form->fields as $field=>$v)
		{
			$fields[$field] = $v['name'];
			if(in_array($field, array_keys($member_tag_form->common_fields)))
			{
				$orderfields['a.'.$field.' ASC'] = $v['name'].' 升序';
				$orderfields['a.'.$field.' DESC'] = $v['name'].' 降序';
			}
			else
			{
				$orderfields['b.'.$field.' ASC'] = $v['name'].' 升序';
				$orderfields['b.'.$field.' DESC'] = $v['name'].' 降序';
			}	
		}
		$selectfields = implode(',', $selectfields);
		
		include admin_tpl('tag_copy');
		break;
	case 'manage':
		$page = max(intval($page), 1);
        $tags = $t->listinfo($type, $page, 20);
		include admin_tpl('tag_manage');
		break;
	case 'update':
		if($isadd && isset($t->TAG[$tagname])) showmessage('该标签已经存在');
		if(!$tag_config['mode'])
		{
			$tag_config['where'] = $info;
			require CACHE_MODEL_PATH.'member_tag.class.php';
			$member_tag = new member_tag($modelid);
			$tag_config['sql'] = $member_tag->get($tag_config['selectfields'], $info, $tag_config['orderby']);
		}
		$tag_config['modelid'] = $modelid;
		$t->update($tagname, $tag_config);
		
		if($ajax)
		{
			if($template_data) file_put_contents(TPL_ROOT.TPL_NAME.'/'.$mod.'/'.$tag_config['template'].'.html', stripslashes($template_data));
			if(strpos($tag_config['sql'], '$') !== false)
			{
				echo '<script language="JavaScript">top.right.location.reload();</script>';
			}
			else
			{
				$tagcode = $t->TAG[$tagname];
				eval($tagcode.';');
				$data = ob_get_contents();
				ob_clean();
				echo '<script language="JavaScript">top.right.tag_save("'.$tagname.'", "'.format_js($data, 0).'");</script>';
			}
		}
		else
		{
			showmessage('操作成功！', $forward);
		}
		break;
	case 'delete':
		$tagname = preg_replace("/^[^{]*[{]?tag_([^}]+)[}]?.*/", "\\1", trim($tagname));
        $t->delete($tagname);
		showmessage('操作成功！', "?mod=$mod&file=$file&action=manage&module=$module");
		break;
	case 'checktag':
		if(isset($t->TAG[$value]))
		{
			exit('该标签已经存在');
		}
		else
		{
			exit('success');
		}
	break;
}
?>