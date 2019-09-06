<?php
require './include/common.inc.php';

if(!$_userid) showmessage('请登录后再申请加入推广联盟！', $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));

$u = $db->get_one("SELECT * FROM ".TABLE_MEMBER_INFO." WHERE userid=$_userid");
if(!$u) showmessage('请您先申请加入推广联盟！', $MOD['linkurl'].'register.php');

if($dosubmit)
{
	if(!isset($checkcode)) $checkcode = '';
	checkcode($checkcode, $MOD['enablecheckcode'], $PHP_REFERER);

	if(strlen($truename) < 4 || strlen($truename) > 20) showmessage('请填写认真填写真实姓名！');
	if(!$telephone) showmessage('请填写联系电话！');
	if(!$mobile) showmessage('请填写联系手机！');
	if(!$qq) showmessage('请填写QQ！');
	if(!$address) showmessage('请填写联系地址！');
	if(!$postid) showmessage('请填写邮政编码！');
	if(!is_email($alipay)) showmessage('请填写正确的支付宝帐号！');

	$db->query("UPDATE ".TABLE_MEMBER_INFO." SET truename='$truename',telephone='$telephone',mobile='$mobile',qq='$qq',address='$address',postid='$postid',alipay='$alipay',homepage='$homepage' WHERE userid=$_userid");
	showmessage('资料修改成功！', $MOD['linkurl'].'manage.php');
}
else
{
    $head['title'] = '推广联盟修改资料';

	extract($u);

	include template($mod, 'edit');
}
?>