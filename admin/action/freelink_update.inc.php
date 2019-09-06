<?php 
defined('IN_PHPCMS') or exit('Access Denied');

if($dosubmit)
{
	$freelinks = array();
	if(isset($freelink) && $freelink)
	{
		foreach($freelink as $k=>$v)
		{
			if((isset($v['delete']) && $v['delete'] == 1) || empty($v['title']) || empty($v['url']))
			{
				unset($freelink[$k]);
			}
			else
			{
				$freelinks[] = $v;
			}
		}
		cache_write('freelink_'.urlencode($type).'.php', $freelinks);
	}
	showmessage($LANG['operation_success'], $forward);
}
else
{

	include admintpl($file.'_'.$action);
}
?>