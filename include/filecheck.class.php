<?php
class filecheck
{
	var $dir;
    
    function __construct()
    {
		$this->dir = PHPCMS_ROOT.'data/md5_file/';
    }

	function filecheck()
	{
		$this->__construct();
	}

	function set($filename = '')
	{
		if($filename == '' || !file_exists($this->dir.$filename)) 
		{
			$this->file = PHPCMS_ROOT.'data/md5_file/'.date('Y-m-d', TIME);
		}
		else
		{
			$this->file = $this->dir.$filename;
		}
	}

	function check($dir, $exts = 'php|js|html', $require = 1)
	{
		$list = $this->lists($dir, $exts, $require);
		if(!$list) return false;
		$files = array();
		$data = file_get_contents($this->file);
		foreach($list as $v)
		{
			$md5 = md5_file($v);
			$filepath = str_replace(PHPCMS_ROOT, '', $v);
			$line = $md5.' '.$filepath."\n";
			if(strpos($data, $line) !== false) continue;
			if(strpos($data, ' '.$filepath."\n") !== false) $files['edited'][] = $filepath;
			else $files['unknow'][] = $filepath;
		}
		return $files;
	}

	function make($dir, $exts = 'php|js|html')
	{
		$list = $this->lists($dir, $exts);
		if(!$list) return false;
		$data = '';
		foreach($list as $v)
		{
			$data .= md5_file($v).' '.str_replace(PHPCMS_ROOT, '', $v)."\n";
		}
		return file_put_contents($this->file, $data);
	}

	function lists($dir, $exts = 'php|js|html', $require = 1)
	{
		$files = array();
		if($require)
		{
			@set_time_limit(600);
			$list = dir_list($dir);
			if(!$list) return false;
			foreach($list as $v)
			{
				if(is_file($v) && preg_match("/\.($exts)$/i", $v)) $files[] = $v;
			}
		}
		else
		{
			$list = glob($dir.'*');
			foreach($list as $v)
			{
				if(is_file($v) && preg_match("/\.($exts)$/i", $v)) $files[] = $v;
			}
		}
		return $files;
	}

	function dirs()
	{
		$dirs = array();
		$list = glob(PHPCMS_ROOT.'*');
		foreach($list as $v)
		{
			if(is_dir($v)) $dirs[] = str_replace(PHPCMS_ROOT, '', $v);
		}
		return $dirs;
	}

	function checked_dirs()
	{
		global $MODULE;
	    $systemdirs = array('./', 'admin','api','corpandresize','data','fckeditor','images','include','install','languages','templates','uploadfile');
		$dirs = array();
		foreach($MODULE as $module=>$m)
		{
			if($module == 'phpcms') continue;
			$dirs[] = substr($m['path'], 0, -1);
		}
		return array_merge($systemdirs, $dirs);
	}

	function md5_files()
	{
		return array_map('basename', glob($this->dir.'*'));
	}

	function scan_dir($dir, $option = array(), $file_list)
	{
		if($dir == './')$dir = '';
		$fp = dir(PHPCMS_ROOT.$dir);
		while (false !== ($en = $fp->read())) {
			if ($en != '.' && $en != '..') {
				if (is_dir(PHPCMS_ROOT.$dir.'/'.$en) && !empty($dir)) {
					$file_list = $this->scan_dir($dir.'/'.$en, $option, $file_list);
				}
				else 
				{
					if(!empty($option))
					{
						$p = pathinfo(PHPCMS_ROOT.$dir.'/'.$en, PATHINFO_EXTENSION);
						if (in_array($p, $option)) {
							$file_list[$dir.'/'.$en] = md5_file(PHPCMS_ROOT.$dir.'/'.$en);
						}
					}
					else 
					{
						$file_list[$dir.'/'.$en] = md5_file(PHPCMS_ROOT.$dir.'/'.$en);
					}
				}
			}
		}
		return $file_list;
	}
}
?>