<?php
defined('IN_PHPCMS') or exit('Access Denied');

$step = isset($step) ? intval($step) : 1;
if($step == '1')
{
	include admintpl("form_add_step1");
}
else if($step == '2')
{
	if($dosubmit)
	{
		$items = array();
		if(!$formitem) showmessage($LANG['input_info_complete'],'goback');
		else 
		{
			$items = explode(',',$formitem);
		}
		include admintpl("form_add_step2");
	}
	else showmessage($LANG['illegal_operation'],'goback');
	
}
else if($step == '3')
{	
	if(!isset($list)) $list = array();
	$c = count($itemname);
	for($i=1; $i<$c+1; $i++)
	{
		if(!isset($list[$i])) $list[$i] = '';
	}	
	$items = array('itemname'=>$itemname,'ismust'=>$ismust,'formtype'=>$formtype,'list'=>$list);
	$itemstr = new_htmlspecialchars(serialize($items));
	include admintpl("form_add_step3");
}
else if($step == '4')
{
	if($email!='' && !is_email($email)) showmessage($LANG['email_format_error'],'goback');
	$r = $db->get_one("SELECT formid,formname FROM ".TABLE_FORMGUIDE." WHERE formname='$formname'");
	if($r) showmessage($LANG['form_name_exist_refill'],'goback');
	$query = "INSERT INTO ".TABLE_FORMGUIDE." (formname,introduce,toemail,formitems,addtime,disabled) VALUES('$formname','$formintroduce','$email','$formitems','$PHP_TIME','0')";
	$db->query($query);	
	$insertid = $db->insert_id();
	
	require_once PHPCMS_ROOT.'/admin/include/tag.class.php';
	$tag = new tag($mod);
	$tag_config = array('templateid'=>'0','formid'=>$insertid,'func'=>'formguide');
	$tag->update($formname , $tag_config, 'formguide($templateid,$formid)');
	tag_write($mod,$formname);
	showmessage($LANG['form_create_success'],"?mod=$mod&file=$file&action=manage");
}
?>