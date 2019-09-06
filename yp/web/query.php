<?php
require '../include/common.inc.php';
define('WEB_ROOT', str_replace("\\", '/',dirname(__FILE__)).'/');
require WEB_ROOT.'include/common.inc.php';
if(!$category) $category = 'index';
$page = $page ? $page : 1;

$head['title'] = $companyname;
$head['keywords'] = $system_name[$category];
$head['description'] = $system_name[$category];
switch($action)
{
	case 'guestbook':
		checkcode($checkcodestr,1,$forward);
		$userid = intval($userid);
		if($userid==$_userid) showmessage('您不能给自己留言！');
		$id = intval($id);
		$qq = intval($new_qq);
		
		$username = htmlspecialchars($new_username);
		$fax = htmlspecialchars($new_fax);
		$telephone = htmlspecialchars($new_telephone);
		$unit = htmlspecialchars($new_unit);
		$msn = htmlspecialchars($new_msn);
		$email = htmlspecialchars($new_email);
		$forwardpage = htmlspecialchars($forwardpage);
		if($username=='') showmessage("用户名不能为空");
		if($telephone=='') showmessage("联系电话不能为空");
		if($unit=='') showmessage("所在单位不能为空");

		$db->query("INSERT INTO `".DB_PRE."yp_guestbook` (`userid`, `id`, `vid`, `username`, `fax`, `telephone`, `qq`, `unit`, `msn`, `email`, `forwardpage`, `content`, `status`, `label`, `addtime`) VALUES ('$userid', '$id', '$_userid', '$username', '$fax', '$telephone', '$qq', '$unit', '$msn', '$email','$forwardpage', '$new_content', '0', '$label', '".TIME."')");
		showmessage("您的留言已经提交成功！",$forward);
	break;
	
	case 'search':
	$q = addslashes(htmlspecialchars(urldecode($q)));
	$tq = $q;
	$q = urlencode($tq);
	if($tq)$where = "AND title LIKE '%$tq%'";
	else $where = "";
	switch($type)
	{
		case 'buy':
		case 'product':
		case 'news':
		break;
		
		default:
		$type = 'product';
		break;
	}
	$category = $type;
	include template('yp', 'com_'.TPL.'-search');
	break;
}
?>