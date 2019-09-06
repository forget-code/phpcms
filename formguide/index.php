<?php
require 'include/common.inc.php';
if(!$M['allowunregsubmit'] && !$_userid) showmessage('请登录', $MODULE['member']['url'].'login.php?forward='.urlencode(URL));
if(!$forward) $forward = HTTP_REFERER;
if(!$FORMGUIDE[$formid]['disabled']) showmessage('该表单没有开启');
if(!class_exists('formguide'))
{
	require MOD_ROOT.'include/formguide.class.php';
}
require CACHE_MODEL_PATH.'formguide_form.class.php';
$formguide_form = new formguide_form($formid);
$forminfos = $formguide_form->get();

$formguid = new formguide();
if($formid) $FORM = $FORMGUIDE[$formid];
if($FORM['enabletime'] && ($FORM['starttime'] > TIME || $FORM['endtime'] < TIME)) showmessage("启用了时间限制，现在并未在时间限制内", $forward);
$allowsendemail = isset($FORM['allowsendemail']) ?$FORM['allowsendemail'] :$M['allowsendemail'];
if ($dosubmit)
{
	if(!$M['allowunregsubmit'] && !$_userid) showmessage('不允许匿名提交');
	if(!class_exists('formguide_input'))
	{
		require CACHE_MODEL_PATH.'formguide_input.class.php';
	}
	$formguide_input = new formguide_input($formid);

	if(!class_exists('formguide_update'))
	{
		require CACHE_MODEL_PATH.'formguide_update.class.php';
	}
	$formguide_update = new formguide_update($formid, $dataid);
	$infoinput = $formguide_input->get($info);
	$formguide_update->update($info);
	$result = $formguid->add($formid, $infoinput);
	if(!$result)
	{
		showmessage($formguid->msg());
	}
	if ($allowsendemail)
	{
		if(!class_exists('formguide_output'))
		{
			require CACHE_MODEL_PATH.'formguide_output.class.php';
		}
		$formguide_output = new formguide_output($formid);
		$info = $formguide_output->get($infoinput);
		$info['提交时间'] = date('Y-m-d', TIME);
		$info['用户名'] = username($_userid);
		$arr_email = explode(',', $FORM['email']);
		if(!is_array($arr_email) && empty($arr_email)) showmessage('邮件为空', $forward);
		if(!class_exists('sendmail'))
		{
			$sendmail = load('sendmail.class.php');
		}
		$title = $forminfos[$k]['name'];
		$content = tpl_data($mod, 'email');
		foreach ($arr_email as $email)
		{
			$sendmail->send($email, $title, stripslashes($content), $PHPCMS['mail_user']);
		}
	}
	showmessage('内容提交成功，我们将尽快查看您的提交内容!', 'close');
}
else 
{
	$result = $FORMGUIDE[$formid];
	@extract(new_htmlspecialchars($result));
	$formname = $name;
	$template = $FORM['template'] ? $FORM['template'] : 'index';
	$head['title'] = $formname;
	include template($mod, $template);
}
?>