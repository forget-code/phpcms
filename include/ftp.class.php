<?php 
class ftp
{
	var $conn_id;
	var $error = '';

    function __construct($ftp_server, $ftp_port, $ftp_user, $ftp_pass, $ftp_dir = '')
    {
		if(!function_exists('ftp_connect'))
		{
			$this->error = 'ftp_unloaded';
			return false;
		}
		$this->conn_id = @ftp_connect($ftp_server, $ftp_port, 600);
        if(!$this->conn_id)
		{
			$this->error = 'ftp_connect_failed';
			return false;
		}
		$login_result = ftp_login($this->conn_id, $ftp_user, $ftp_pass);
		if(!$login_result)
		{
			$this->error = 'ftp_login_failed';
			return false;
		}
		if($ftp_dir && !@ftp_chdir($this->conn_id, $ftp_dir))
		{
			$this->error = 'ftp_dir_change_failed';
			return false;
		}
		register_shutdown_function(array(&$this, 'close'));
    }

	function ftp($ftp_server, $ftp_port, $ftp_user, $ftp_pass, $ftp_dir = '')
	{
		$this->__construct($ftp_server, $ftp_port, $ftp_user, $ftp_pass, $ftp_dir);
	}

	function mkdir($directory)
	{
		$directory = stripstr($directory);
		return @ftp_mkdir($this->conn_id, $directory);
	}

	function rmdir($directory)
	{
		$directory = stripstr($directory);
		return @ftp_rmdir($this->conn_id, $directory);
	}

	function put($remote_file, $local_file, $mode = FTP_BINARY, $startpos = 0)
	{
		$remote_file = stripstr($remote_file);
		$local_file = stripstr($local_file);
		$mode = intval($mode);
		$startpos = intval($startpos);
		return @ftp_put($this->conn_id, $remote_file, $local_file, $mode, $startpos);
	}

	function get($local_file, $remote_file, $mode, $resumepos = 0)
	{
		$remote_file = stripstr($remote_file);
		$local_file = stripstr($local_file);
		$mode = intval($mode);
		$resumepos = intval($resumepos);
		return @ftp_get($this->conn_id, $local_file, $remote_file, $mode, $resumepos);
	}

	function nlist($directory)
	{
		$directory = stripstr($directory);
		$list = @ftp_rawlist($this->conn_id, $directory);
		if(!$list) return false;
		$array = array();
		foreach($list as $l)
		{
			$l = preg_replace("/^.*[ ]([^ ]+)$/", "\\1", $l);
			if($l == '.' || $l == '..') continue;
			$array[] = $l;
		}
		return $array;
	}

	function rawlist($directory)
	{
		$directory = stripstr($directory);
		return @ftp_rawlist($this->conn_id, $directory);
	}

	function exists($pathname)
	{
		$directory = str_exists($pathname, '/') ? dirname($pathname).'/' : '.';
		$files = $this->nlist($directory);
		return in_array(basename($pathname), $files);
	}

	function pwd()
	{
		return @ftp_pwd($this->conn_id);
	}

	function size($remote_file)
	{
		$remote_file = stripstr($remote_file);
		return @ftp_size($this->conn_id, $remote_file);
	}

	function delete($path)
	{
		$path = stripstr($path);
		return @ftp_delete($this->conn_id, $path);
	}

	function login($username, $password)
	{
		$username = stripstr($username);
		$password = str_replace(array("\n", "\r"), array('', ''), $password);
		return @ftp_login($this->conn_id, $username, $password);
	}

	function pasv($pasv)
	{
		$pasv = intval($pasv);
		return @ftp_pasv($this->conn_id, $pasv);
	}

	function chdir($directory)
	{
		$directory = stripstr($directory);
		return @ftp_chdir($this->conn_id, $directory);
	}

	function site($cmd)
	{
		$cmd = stripstr($cmd);
		return @ftp_site($this->conn_id, $cmd);
	}

	function chmod($mode, $filename)
	{
		$mode = intval($mode);
		$filename = stripstr($filename);
        return (function_exists('ftp_chmod') && @ftp_chmod($this->conn_id, $mode, $filename)) || $this->site($this->conn_id, 'CHMOD '.$mode.' '.$filename);
	}

	function dir_chmod($dir, $mode = 0777, $require = 0)
	{
		if(!$require) $require = substr($dir, -1) == '*' ? 2 : 0;
		if($require)
		{
			if($require == 2) $dir = substr($dir, 0, -1);
			$dir = dir_path($dir);
			$list = glob($dir.'*');
			$files = array();
			foreach($list as $v)
			{
				if(is_dir($v))
				{
					$this->dir_chmod($v.'/', $mode, $require);
				}
				else
				{
					$files[] = $v;
				}
			}
			if($files)
			{
				foreach($files as $file)
				{
					$this->chmod($mode, $file);
				}
			}
		}
		$this->chmod($mode,$dir);
	}

	function set_dir($dir = '')
	{
		$dir = str_replace(PHPCMS_ROOT, $this->dir, $dir);
		if(!$dir) $dir = $this->dir;
		$dir = dir_path($dir);
		return ftp_chdir($this->conn_id,$dir);
	}

	function errormsg()
	{
		$LANG['ftp_unloaded'] = '服务器不支持FTP功能，请联系服务器管理员安装FTP扩展！';
		$LANG['ftp_connect_failed'] = 'FTP 连接失败！';
		$LANG['ftp_login_failed'] = 'FTP 连接成功，登录失败！';
		$LANG['ftp_dir_change_failed'] = 'FTP 登录成功，目录切换失败！';
		echo $LANG[$this->error];
	}

	function close()
	{
		return @ftp_close($this->conn_id);
	}
}
?>