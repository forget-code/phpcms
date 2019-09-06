<?php
require_once './include/common.inc.php';
require 'form.class.php';
require_once './include/link.class.php';

$datas = subtype('link');
$link = new link();
if($dosubmit)
{
	if($M['enablecheckcode'])	
	{
		checkcode($checkcodestr,1,$forward);
	}
	if(empty($typeid))
	{
		showmessage('请选择分类',$forward);
	}
	if(empty($name))
	{
		showmessage('请填写网站名称',$forward);
	}
	if(empty($url))
	{
		showmessage('请填写网站地址',$forward);
	}
	if(!preg_match('/\b((?#protocol)https?|ftp):\/\/((?#domain)[-A-Z0-9.]+)((?#file)\/[-A-Z0-9+&@#\/%=~_|!:,.;]*)?((?#parameters)\?[-A-Z0-9+&@#\/%=~_|!:,.;]*)?/i', $url))
	{
		showmessage('请填写正确的网站地址',$forward);
	}
	if($linktype && empty($logo))
	{
		showmessage('请填写网站的logo',$forward);
	}
	if($M['ischeck'])	
	{
		$passed = 0;
		$m = '请等待管理员审核该链接';
	}
	else
	{
		$passed = 1;
		$m = '';
	}
	$arr = array('typeid'=>$typeid,'linktype'=>$linktype,'name'=>$name,'url'=>$url,'logo'=>$logo,'username'=>$username,'passed'=>$passed,'addtime'=>TIME);
	if($link->add($arr))
	{
		if($passed)
		{
			showmessage($LANG['operation_success'].$m,"link/index.php");
		}
		showmessage($LANG['operation_success'].$m,"link/index.php");
	}
	else
		showmessage($LANG['operation_failure'],$forward);
}
else
{
	include template($mod, 'register');
}

?>