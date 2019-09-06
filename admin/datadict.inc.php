<?php
defined('IN_PHPCMS') or exit('Access Denied');

$files = glob(PHPCMS_ROOT.'data/datasource/*');
foreach($files as $k=>$v)
{
	$v = substr(basename($v), 7, -4);
	if($v) $tables[] = $v;
}
$tablenames = cache_read('phpcms.php', PHPCMS_ROOT.'data/datasource/');
if(strtolower(CHARSET) != 'utf-8') $tablenames = str_charset('utf-8', CHARSET, $tablenames);

switch($action)
{
    case 'field':
		$fields = cache_read('phpcms_'.$table.'.php', PHPCMS_ROOT.'data/datasource/');
		if(strtolower(CHARSET) != 'utf-8') $fields = str_charset('utf-8', CHARSET, $fields);
		include admin_tpl('datadict_field');
		break;

    default :
		include admin_tpl('datadict');
}
?>