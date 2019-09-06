<?php
define('IN_ADMIN', TRUE);
require dirname(__FILE__).'/include/admin/global.func.php';
require dirname(__FILE__).'/include/common.inc.php';
require 'log.class.php';
require 'form.class.php';
require 'priv_role.class.php';
require_once 'cache.func.php';
require_once 'version.inc.php';
require PHPCMS_ROOT.'languages/'.LANG.'/phpcms_admin.lang.php';

if(!isset($file)) $file = 'index';
preg_match("/^[0-9A-Za-z_-]+$/", $file) or showmessage('Invalid Request.');
$action = isset($action) ? $action : '';
$catid = isset($catid) ? intval($catid) : 0;
$specialid = isset($specialid) ? intval($specialid) : 0;
if(!isset($forward) && str_exists(HTTP_REFERER, '?')) $forward = HTTP_REFERER;

session_start();

if($_userid && $_groupid == 1 && $_SESSION['is_admin'] == 1)
{
	$ROLE = cache_read('role.php');
	$GROUP = cache_read('member_group.php');
	$POS = cache_read('position.php');
	$STATUS = cache_read('status.php');
	$_roleid = cache_read('admin_role_'.$_userid.'.php');
	if(!$_roleid) showmessage('您没有任何角色权限！');
	$priv_role = new priv_role();
	if(!$priv_role->module()) showmessage('您没有操作权限！');
}
elseif($file != 'login')
{
	showmessage('请登录！', '?mod=phpcms&file=login&forward='.urlencode(URL),1,1);
}

$log = new log();
if(ADMIN_LOG && $file != 'database' && !in_array($action, array('get_menu_list', 'menu_pos')))
{
	$log->set('admin', 0);
	$log->add();
}
if($mod != 'phpcms' && !@include PHPCMS_ROOT.$M['path'].'admin/admin.inc.php') showmessage('The file ./'.$M['path'].'admin.inc.php is not exists!');
if(!@include PHPCMS_ROOT.(isset($M['path']) ? $M['path'] : '').'admin/'.$file.'.inc.php') showmessage("The file ./{$M['path']}admin/{$file}.inc.php is not exists!");
?>