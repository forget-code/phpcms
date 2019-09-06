<?php
defined('IN_PHPCMS') or exit('Access Denied');

define('FILE_TIME', strtotime(date('Y-m-d h:i', $PHP_TIME)));
$allfiles_path = PHPCMS_ROOT.'/data/old_files.php';
$new_path = PHPCMS_ROOT.'/data/new_files.php';
$error_path = PHPCMS_ROOT.'/data/error_files.php';
$check_path = PHPCMS_ROOT.'/data/check_path.php';

$submenu = array(
    array($LANG['view_file_checktime'].date('Y-m-d h:i', filemtime($error_path)), "?mod=$mod&file=filecheck&action=file_look"),
    );
$menu = adminmenu($LANG['error_name'], $submenu);
function listfiles($dir, $file_type = '.', $arrfiles = array(), $rootfile = 0)
{
    $dir = dir_path($dir);
    $list = glob($dir.'*');
    foreach($list as $v)
    {
		set_time_limit(600);
        if (is_dir($v))
        {
            $rootfile == 0 ? $arrfiles = listfiles($v, $file_type, $arrfiles) : '';
        }
		elseif (strpos($v, $file_type))
        {
            $arrfiles[] = $v.'*'.md5_file($v);
        }
    }

    return $arrfiles;
}
function files_read($file, $mode = 'i')
{
    if (!file_exists($file)) return array();
    return $mode == 'i' ? include $file : file_get_contents($cachefile);
}
function files_write($file, $string, $type = 'array')
{
	if(is_array($string))
	{
		$type = strtolower($type);
		if($type == 'array')
		{
			$string = "<?php\n return ".var_export($string,TRUE).";\n?>";
		}
		elseif($type == 'constant')
		{
			$data='';
			foreach($string as $key => $value) $data .= "define('".strtoupper($key)."','".addslashes($value)."');\n";
			$string = "<?php\n".$data."\n?>";
		}
	}
	$strlen = file_put_contents($file, $string);
	chmod($file, 0777);
	return $strlen;
}

if ($action == 'edit')
{
    if (!is_writeable($fname)) showmessage($LANG['file'].' '.$fname.' '.$LANG['cannot_write_edit_online']);
    if ($dosubmit)
    {
        file_put_contents($fname, stripslashes($content));
        showmessage($LANG['operation_success'], "?mod=$mod&file=$file&action=main&dir=".urlencode($dir));
    }
    else
    {
        $content = file_get_contents($fname);
        $filemtime = date("Y-m-d H:i:s", filemtime($fname));
        include admintpl('filemanager_edit');
    }
}
// 开始执行
if ($action)
{
    if ($files)
    {
        if (is_array($files))

        {
			$data = "<?php\nreturn ".var_export(array(),true).";\n?>";
            if (is_array($files) && $action == 'reload')
            {
				files_write($allfiles_path,$data);
				files_write($check_path,$files);
            }
            if (is_array($files) && $action == 'check')
            {
				files_write($new_path,$data);
            }
            if ($files['mod'] == 'mod')
            {
                foreach ($MODULE as $v => $moduledir)
                {
                    $files_mod[] = $v.'.php';
                }
                $files = array_merge($files, $files_mod);
            }
            $files = implode(',', $files);
            $referer = '?mod='.$mod.'&file='.$file.'&action='.$action.'&files='.$files;
            showmessage($LANG['files_begin'], $referer);
        }
        else
        {
            $files = explode(',', $files);
            $filess = $files[0];
            unset($files[0]);
            $files = implode(',', $files);

            if (substr($filess, -4) == '.php')
            {
                $filess = substr($filess, 0, -4);
                $file_type = '.php';
            }
            else
            {
                $file_type = '.';
            }
            $dir = PHPCMS_ROOT.'/'.$filess;
            if ($filess == 'root')
            {
                $file_root = 1;
                $dir = PHPCMS_ROOT;
            }
            $referer = '?mod='.$mod.'&file='.$file.'&action='.$action.'&files='.$files.'&file_type='.$file_type;
            $newfiles = listfiles($dir, $file_type, array(), "$file_root");

			if($action=='reload')
			{
				$oldfiles = files_read($allfiles_path);
				$oldfiles=array_merge($oldfiles, $newfiles);
				files_write($allfiles_path, $oldfiles);
			}
            if ($action == 'check')
            {
				$oldfiles = files_read($new_path);
				$oldfiles=array_merge($oldfiles, $newfiles);
				files_write($new_path, $oldfiles);
            }
            showmessage('[./'.$filess.']', $referer);
        }
    }
    else
    {
        if ($action == 'check')
        {
            $oldfiles = files_read($allfiles_path);
            $newfiles = files_read($new_path);
            $errorfile = array_diff($newfiles, $oldfiles);
            files_write($error_path, $errorfile);
            $filedate = date('Y-m-d h:i', filemtime($allfiles_path));
            $errorfile ? include admintpl('filecheck_list') : showmessage($LANG['files_check_ok']);
        }
		elseif ($action == 'file_look')
        {
            $errorfile = files_read($error_path);
            include admintpl('filecheck_list');
        }
        else
        {
            showmessage($LANG['files_mirror_success']);
        }
    }
}
else
{
    $filedate = date('Y-m-d h:i', filemtime($allfiles_path));
	$check_path=files_read($check_path);
    include admintpl('filecheck');
}
?>