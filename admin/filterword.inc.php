<?php 
defined('IN_PHPCMS') or exit('Access Denied');

function log_read($logfile, $ip = '')
{
	if(!file_exists($logfile)) return FALSE;
	$data = array();
	$fp = fopen($logfile, 'r');
	while($line = fgetcsv($fp))
	{
		if($ip && !preg_match("/^$ip/", $line[1])) continue;
		$data[] = $line;
	}
	fclose($fp);
	return $data;
}

if(!$action) $action = 'manage';

switch($action)
{
    case 'manage':
		$curyear = date('Y', TIME);
		$curmonth = date('m', TIME);

		$infos = array();
		$year = isset($year) ? intval($year) : $curyear;
		$month = isset($month) ? $month : '';

		if($month)
		{
			$logfile = PHPCMS_ROOT.'data/filterlog/'.$year.$month.'.csv';
			$result = log_read($logfile, $ip);
			if($result) $infos = $result;
		}
		else
		{
			for($i=1; $i<=12; $i++)
			{
				$m = $i > 9 ? $i : '0'.$i;
				$logfile = PHPCMS_ROOT.'data/filterlog/'.$year.$m.'.csv';
				$result = log_read($logfile, $ip);
				if($result) $infos = array_merge($infos, $result);			
			}
		}
		$number = count($infos);

		include admin_tpl('filterword_manage');
		break;
    case 'delete':
		if($month)
		{
			@unlink(PHPCMS_ROOT.'data/filterlog/'.$year.$month.'.csv');
		}
		else
		{
			for($i=1; $i<=12; $i++)
			{
				$m = $i > 9 ? $i : '0'.$i;
			    @unlink(PHPCMS_ROOT.'data/filterlog/'.$year.$m.'.csv');
			}
		}
		showmessage('操作成功！', $forward);
		break;
	case 'download':
		file_down(PHPCMS_ROOT.'data/filterlog/'.$year.$month.'.csv');
		break;
}
?>