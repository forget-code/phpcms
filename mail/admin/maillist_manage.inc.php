<?php
defined('IN_PHPCMS') or exit('Access Denied');


$fmail = glob(PHPCMS_ROOT.'/'.$mail_datadir."*.txt");
$fnumber = count($fmail);
if($fnumber>0)
{
	foreach( $fmail as $key=>$val)
	{
		$mailfiles[$key] = basename($val);
	}
}
unset($fmail);
include admintpl('maillist_manage');
?>