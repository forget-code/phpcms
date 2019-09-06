<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once PHPCMS_ROOT.'/include/ftp.class.php';

function fileext_select($name, $fileext = 'html' , $property = '', $fileextarr = array('html','htm','shtml','shtm','php'))
{
	$data = '';
	foreach($fileextarr as $ext)
	{
		$data .= "<option value='$ext' ".($ext == $fileext ? 'selected' : '').">$ext</option>\n";
	}
	return "<select name='$name' id='fileext' $property>\n$data</select>\n";
}

switch($action)
{
	case 'save':
		if($setting['enableftp'])
	    {
			$ftp = new phpcms_ftp($setting['ftphost'], $setting['ftpuser'], $setting['ftppass'], $setting['ftpport'], $setting['ftpwebpath'], 'I', 1);
			if(strpos($ftp->data, '230') === FLASE) showmessage($LANG['ftp_set_error']);
			if(!$ftp->is_phpcms()) showmessage($LANG['root_or_relative_ftproot_error']); 
		}

		module_setting($mod, $setting);
	    
		set_config($setconfig);

		if($setting['ishtml'] == 0) 
	    {
			$data = '<html>
					<head>
					<title>phpcms 2007</title>
					<meta http-equiv="Refresh" content="0;URL=index.php" />
					</head>
					<body>
					</body>
					</html>';
			file_put_contents(PHPCMS_ROOT.'/'.$setting['index'].'.'.$setting['fileext'], $data);
			chmod(PHPCMS_ROOT.'/'.$setting['index'].'.'.$setting['fileext'], 0777);
		}

		ob_start();
		phpcms_tm();
		$data = ob_get_contents();
		ob_clean();
		cache_write('tm.html', $data);

		showmessage($LANG['save_setting_success'], $PHP_REFERER);
		break;

	case 'testftp':
		$ftp = new phpcms_ftp($ftphost, $ftpuser, $ftppass, $ftpport, $ftpwebpath, 'I', 1);
		if(!$ftp->connected) showmessage($LANG['ftp_set_error']);
		if(!$ftp->is_phpcms()) showmessage($LANG['root_or_relative_ftproot_error']); 

        showmessage($LANG['ftp_set_right']);
		break;

	default :
		require PHPCMS_ROOT.'/config.inc.php';
		

		@extract(new_htmlspecialchars($CONFIG));
		@extract(new_htmlspecialchars($PHPCMS));

		if(!function_exists('ob_gzhandler')) $enablegzip = 0;
		$safe_mode = ini_get('safe_mode');

		if(!function_exists('imagepng') && !function_exists('imagejpeg') && !function_exists('imagegif'))
	    {
			$gd = "<font color='red'>".$LANG['no_gd_support']."</font>";
			$enablegd = 0;
		}
		else
	    {
			$gd = $LANG['support'];
			$enablegd = 1;
		}
        if(function_exists('imagepng')) $gd .= "PNG ";
        if(function_exists('imagejpeg')) $gd .= " JPG ";
        if(function_exists('imagegif')) $gd .= " GIF ";

        include admintpl('setting');
}
?>