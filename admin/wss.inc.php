<?php
defined('IN_PHPCMS') or exit('Access Denied');
$wss_site_id = $PHPCMS['wss_site_id'];
$wss_password = $PHPCMS['wss_password'];
if(!$wss_site_id || !$wss_password)
{
	//KEY EXAMPLE 80209982@5446303681 
	if (preg_match('%http://([a-z0-9.\-]+)/%', $PHPCMS['siteurl'], $regs))
	{
		$domain = $regs[1];
	}
	else
	{
		showmessage('网站地址配置有误，请更正...','?mod=phpcms&file=setting&tab=0');
	}

	$key = md5($domain.'F0dkYYtw');
	if(preg_match("/^[0-9.]{7,15}$/", @gethostbyname('wss.cnzz.com')))
	{
		$data = @file_get_contents("http://wss.cnzz.com/user/companion/phpcms.php?domain=$domain&key=$key");
		if(!$data) showmessage('与远程服务器通信失败，请稍后再试');
		$datas = explode('@',$data);
		$PHPCMS['wss_site_id'] = $datas[0];
		$PHPCMS['wss_password'] = $datas[1];
		module_setting('phpcms', $PHPCMS);
		if($action!='setting')
		{
			header('Location: http://wss.cnzz.com/user/companion/phpcms_login.php?site_id='.$datas[0].'&password='.$datas[1]);
		}
	}
	else
	{
		showmessage("您的服务器无法解析域名wss.cnzz.com，请检测服务器相关设置");
	}
}

if($action=='setting')
{
	if($dosubmit)
	{
		$PHPCMS['wss_enable'] = $wss_enable;
		module_setting('phpcms', $PHPCMS);
		showmessage('配置更新成功',$forward);
	}
	else
	{
		include admin_tpl('wss');
	}
}
else
{
	header('Location: http://wss.cnzz.com/user/companion/phpcms_login.php?site_id='.$wss_site_id.'&password='.$wss_password);
}
?>