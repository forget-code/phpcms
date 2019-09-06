<?php
defined('IN_PHPCMS') or exit('Access Denied');

$submenu = array
(
	array($LANG['manage_index'], "?mod=".$mod."&file=field&action=manage&channelid=".$channelid.'&tablename='.$tablename),
	array($LANG['add_field'], "?mod=".$mod."&file=field&action=add&channelid=".$channelid.'&tablename='.$tablename),
);
$menu = adminmenu($LANG['my_field_manage'],$submenu);

$r = $db->get_one("SHOW TABLES FROM `".$CONFIG['dbname']."` LIKE '$tablename' ");
if(!$r) showmessage($LANG['data_table']." $tablename ".$LANG['not_exist'],"goback");

require_once PHPCMS_ROOT.'/include/field.class.php';

$field = new field($tablename);

$action = $action ? $action : 'manage';

switch($action)
{
	case 'add':
		if($dosubmit)
		{
			if(empty($name)) showmessage($LANG['sorry_input_field_name']);
			$result = $field->add($name, $type, $size, $defaultvalue, $options, $title, $note, $formtype, $inputtool, $inputlimit, $enablehtml, $enablelist, $enablesearch);
			if(!$result) showmessage($LANG['field_name_type_existed'],'goback');
			showmessage($LANG['operation_success'], '?mod='.$mod.'&file=field&action=manage&channelid='.$channelid.'&tablename='.$tablename);
		}
		else
		{
			include admintpl('field_add');
		}
		break;

	case 'edit':
		if(!$fieldid) showmessage($LANG['illegal_parameters'], 'goback');

		if($dosubmit)
		{
			$field->edit($fieldid, $type, $size, $defaultvalue, $options, $title, $note, $formtype, $inputtool, $inputlimit, $enablehtml, $enablelist, $enablesearch);
			showmessage($LANG['operation_success'],'?mod='.$mod.'&file=field&action=manage&channelid='.$channelid.'&tablename='.$tablename);
		}
		else
		{
			$fieldinfo = $field->get_info($fieldid);
			extract($fieldinfo);
			include admintpl('field_edit');
		}
		break;

	case 'manage':
		$fieldtypes = array("input"=>$LANG['single_line_text'],"text"=>$LANG['multiple_line_text'],"select"=>$LANG['from_list_of_options'],"int"=>$LANG['number'],"date"=>$LANG['date'],);
		$fieldlist = $field->get_list();

		include admintpl('field_manage');
		break;

	case 'listorder':
		$field->listorder($listorder);
		showmessage($LANG['operation_success'], $forward);
		break;

	case 'delete':
		if(!$fieldid) showmessage($LANG['illegal_parameters'], 'goback');
		$field->delete($fieldid);
		showmessage($LANG['operation_success'], $forward);
		break;
}
?>