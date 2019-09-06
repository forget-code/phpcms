<?php 
defined('IN_PHPCMS') or exit('Access Denied');

if($dosubmit)
{
	include PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/tags.php';

	$newtypes = array();
	if(isset($type) && $type)
	{
		foreach($type as $k=>$v)
		{
			if((isset($v['delete']) && $v['delete']) || empty($v['name']))
			{
				unset($type[$k]);
                if(isset($v['delete']))
				{
					cache_delete('freelink_'.urlencode($v['name']).'.php');
					@unlink(PHPCMS_ROOT.'/data/freelink/'.urlencode($v['name']).'.html');
				}
				if($v['name']) unset($tags[$v['name']]);
			}
			else
			{
				if(!isset($types[$v['name']]))
				{
					if(isset($tags[$v['name']])) showmessage($LANG['type_name_not_same_label_name']);
					$tags[$v['name']] = 'phpcms_freelink(\''.$v['name'].'\')';
				}
				$newtypes[$v['name']] = $v;
			}
		}
		cache_write('freelink_type.php', $newtypes);
		array_save($tags, "\$tags", PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/tags.php');
	}
	showmessage($LANG['operation_success'], $forward);
}
else
{
	foreach($types as $k=>$v)
	{
		unset($types[$k]);
		$types[] = $v;
	}

	include admintpl($file.'_'.$action);
}
?>