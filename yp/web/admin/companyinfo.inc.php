<?php
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/include/formselect.func.php';
require_once PHPCMS_ROOT.'/include/tree.class.php';
$tree = new tree;
$AREA = cache_read('areas_'.$mod.'.php');
require_once PHPCMS_ROOT.'/include/area.func.php';
require PHPCMS_ROOT.'/include/field.class.php';
$TRADE = cache_read('trades_trade.php');
require_once PHPCMS_ROOT.'/yp/include/trade.func.php';
$field = new field($CONFIG['tablepre'].'member_company');

if($dosubmit)
{
	$companyname = strip_tags($companyname);
	$product = strip_tags($product);
	$address = strip_tags($address);
	$homepage = strip_tags($homepage);
	$linkman = strip_tags($linkman);
	$postid = intval($postid);
	$fax = strip_tags($fax);
	$field->check_form();
	$patternString = '';
	foreach($pattern AS $v)
	{
		$patternString .= $v.'|';
	}
	$patternString = substr($patternString,0,-1);
	$regtime = strtotime($regtime);
	$_sitedomain = '';
	if($MOD['enableSecondDomain'])
	{
		$_sitedomain = ",`sitedomain` = '$sitedomain'";
	}
	$db->query("UPDATE ".TABLE_MEMBER_COMPANY." SET `companyname` = '$companyname', `areaid` = '$areaid', `tradeid` = '$tradeid',`pattern` = '$patternString', `typeid` = '$typeid',`product` = '$product',`regtime` = '$regtime',`employnum` = '$employnum',`linkurl`='$mydomain',`turnover` = '$turnover' $_sitedomain,`linkman` = '$linkman',`telephone` = '$telephone',`fax`='$fax',`postid` = '$postid',`email` = '$email',`address` = '$address',`homepage` = '$homepage' WHERE companyid='$companyid' AND username='$_username'");
	$field->update("companyid=$companyid");
	createhtml('header',PHPCMS_ROOT.'/yp/web');
	createhtml('introduce',PHPCMS_ROOT.'/yp/web');
	createhtml('index',PHPCMS_ROOT.'/yp/web');
	showmessage($LANG['operation_success'],$forward);
}
else
{
	@extract($db->get_one("SELECT * FROM ".TABLE_MEMBER_COMPANY." WHERE username='$_username'"),EXTR_OVERWRITE);
	$fromdate = date('Y-m-d',$regtime);
	$postid = $postid ? $postid : '';
	$patterns = $editpattern = '';
	$patterns = explode('|',$MOD['pattern']);
	foreach($patterns AS $v)
	{
		$checked = '';
		$pos = strpos($pattern,$v);
		if($pos !== false) $checked = 'checked="checked"';
		$editpattern .= '<input name="pattern[]" type="checkbox" value="'.$v.'" '.$checked.'> '.$v;
	}
	$type_selected = "<select name='typeid' ><option value='0'>".$LANG['please_choose_type']."</option>";
	$types = explode("\n",$MOD['type']);
	foreach($types AS $t)
	{
		$selected = '';
		if($typeid==$t) $selected = 'selected';
		$type_selected .= "<option value='$t' $selected>$t</option>";
	}
	$type_selected .= "</select>";

	$fields = $field->get_form('<tr><td class="tablerow">$title</td><td class="tablerow">$input $tool $note</td></tr>');
	include managetpl('companyinfo');
}
?>