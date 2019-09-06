<?php
defined('IN_PHPCMS') or exit('Access Denied');
require_once MOD_ROOT.'admin/include/pointcard.class.php';
$pointcard = new pointcard();
switch($action)
{
	case 'list':
		$page = isset($page) ? intval($page) : 1;
		$pagesize	= $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 20;
		$pointcards = $pointcard->get_list();
		include admin_tpl('pointcard_view');
	break;
    case 'add':
        if($dosubmit)
        {
            if ($pointcard->add($setting)) showmessage($LANG['operation_success'], '?mod=pay&file=pointcard&action=list');
        }
        else
        {
            $typetitle = '添加';
            include admin_tpl('pointcard_detail');
        }
    break;
    case 'drop':
        if(empty($ids))
        {
            showmessage('请选择要删除的对象');
        }
        else
        {
            $pointcard->drop($ids); showmessage('删除成功', '?mod=pay&file=pointcard&action=list');
        }
    break;
	case 'update':
        $pointid = intval($pointid);
        if(empty($pointid)) showmessage('非法的参数');
        if($dosubmit)
        {
            if ($pointcard->update($pointid, $setting)) showmessage($LANG['operation_success'], '?mod=pay&file=pointcard&action=list');
        }
        else
        {
            $typetitle = '修改';
            $card = $pointcard->get_card($pointid);
            include admin_tpl('pointcard_detail');
        }
	break;
}
?>