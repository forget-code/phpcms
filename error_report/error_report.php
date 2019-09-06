<?php
require './include/common.inc.php';
require_once PHPCMS_ROOT.'include/form.class.php';
require_once 'output.class.php';

require_once MOD_ROOT.'/admin/include/error.class.php';
if ($dosubmit)
{
    checkcode($checkcode, $M['enablecheckcode']);
	foreach($info AS $key=>$val)
	{
		if(!in_array($key,array('error_link','contentid','typeid','error_title','error_text','error_link'))) unset($info[$key]);
	}
    if (strpos($info['error_link'], 'http://') === false && strpos($info['error_link'], 'https://') === false)
    {
        $info['error_link'] = 'http://' . trim($info['error_link']);
    }
    else
    {
        $info['error_link'] = trim($info['error_link']);
    }
	$info['error_link'] = htmlspecialchars($info['error_link']);
    $forward = $info['error_link'];
    $errors = new error();
    if($errors->add($info)) showmessage('提交成功', $forward);
}
else
{
	$title = htmlspecialchars(stripslashes($title));
	$contentid= intval($contentid);
    $radio = '';
	$types = subtype('error_report');
    foreach($types AS $k => $v)
    {
        $radio .= "<input id='typeid' name='info[typeid]' type='radio' value=".$v['typeid']." />";
        $radio .= output::style($v['name'], $v['style']);
    }
    include template('error_report', 'error_report');
}
?>