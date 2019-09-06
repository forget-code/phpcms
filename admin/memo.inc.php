<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$memo = load('memo.class.php');

switch($action)
{
    case 'get':
		echo $memo->mtime().$memo->get();
		break;
    case 'set':
		$memo->set($data);
	    echo $memo->mtime();
		break;
    case 'mtime':
		echo $memo->mtime();
		break;
}
?>