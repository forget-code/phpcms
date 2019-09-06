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
				$v = array_map('stripslashes', $v);
				$freelinks[] = new_htmlspecialchars($v);
			}
		}
		foreach ($freelinks as $key => $row)
		{
			$order[$key]  = $row['order'];
		}
		array_multisort($order, SORT_ASC, $freelinks);
		cache_write('freelink_'.urlencode($type).'.php', $freelinks);
	}
	update_freelink($type);
	showmessage($LANG['operation_success'], $forward);
}
else
{
    $freelinks = cache_read('freelink_'.urlencode($type).'.php');
	$number = $types[$type]['number'] - count($freelinks);

	include admintpl($file.'_'.$action);
}
?>