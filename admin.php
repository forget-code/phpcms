<?php 
define('IN_ADMIN', TRUE);
$rootdir = dirname(__FILE__);
require $rootdir.'/admin/include/global.func.php';
require $rootdir.'/include/common.inc.php';
$session = new phpcms_session();
require PHPCMS_ROOT.'/languages/'.$CONFIG['adminlanguage'].'/phpcms_admin.lang.php';
require_once PHPCMS_ROOT.'/include/version.inc.php';
require_once PHPCMS_ROOT.'/include/formselect.func.php';
require_once PHPCMS_ROOT.'/include/cache.func.php';
require_once PHPCMS_ROOT.'/include/post.func.php';

if(!isset($file)) $file = 'index';
preg_match("/^[0-9A-Za-z_]+$/",$file) or showmessage('Invalid Request.');

$db->iscache = 0;
$fileiscache = 0;
$filecaching = 0;

$file = isset($file) ? $file : 'login';
$action = isset($action) ? $action : '';
$job = isset($job) ? $job : '';
$catid = isset($catid) ? intval($catid) : 0;
$specialid = isset($specialid) ? intval($specialid) : 0;

$_grade = isset($_SESSION['admin_grade']) ? $_SESSION['admin_grade'] : -1;

if($file != 'login' && ($_grade == -1 || $_groupid != 1)) showmessage($LANG['login_website'], '?mod=phpcms&file=login&forward='.urlencode(strpos($PHP_URL, '?') ? $PHP_URL : '?mod=phpcms&file=index&action=index'));
if($CONFIG['enableadminlog'] && $file != 'database' && $action != 'import') adminlog();

if($_grade > 0)
{
    $_modules = $_SESSION['admin_modules'];
    $_channelids = $_SESSION['admin_channelids'];
    $_purviewids = $_SESSION['admin_purviewids'];
    $_catids = $_SESSION['admin_catids'];
    $_specialids = $_SESSION['admin_specialids'];
	if($mod == 'phpcms')
	{
		require PHPCMS_ROOT.'/admin/include/checkpurview.inc.php';
	}
	else
	{
		if($MODULE[$mod]['iscopy'])
		{
			if(!in_array($channelid, $_channelids)) showmessage($LANG['you_have_no_permission_this_channel']);
		}
		else
		{
			if($MODULE[$mod]['isshare'] == 0)
			{
				if(!in_array($mod, $_modules)) showmessage($LANG['you_have_no_permission_this_module']);
			}
			elseif($_grade > 1 || !isset($keyid) || (!in_array($keyid, $_channelids) && !in_array($keyid, $_modules)))
			{
				showmessage($LANG['you_have_no_permission_this_module']);
			}
		}
	}
}
else
{
	$_modules = $_channelids = $_catids = $_specialids = array();
}

$grades = array(0 => $LANG['administrator'], 1 => $LANG['module_channel_admin'], 2 => $LANG['category_cheif_editor'], 3 => $LANG['category_editor'], 4 => $LANG['info_publisher'] , 5 => $LANG['info_verifier']);

$module_dir = moduledir($mod);
$filepath = $mod == 'phpcms' ? PHPCMS_ROOT.'/admin/'.$file.'.inc.php' : PHPCMS_ROOT.'/'.$module_dir.'/admin.inc.php';

if(!@include $filepath) showmessage($LANG['illegal_operation']);
?>