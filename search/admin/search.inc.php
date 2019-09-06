<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require_once MOD_ROOT.'include/search.class.php';
$search = new search();
if(!$forward) $forward = HTTP_REFERER;

switch($action)
{
    case 'createindex':
		if($dosubmit)
		{
			$search->create_index();
			showmessage('全文索引重建成功！', $forward);
		}
		else
		{
			$inifile = substr(PHP_OS, 0, 3) == 'WIN' ? 'my.ini' : 'my.cnf';
			include admin_tpl('search_createindex');
		}
		break;
    default :
}
?>