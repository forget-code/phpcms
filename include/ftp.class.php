<?php
defined('IN_PHPCMS') or exit('Access Denied');

if(extension_loaded('ftp'))
{
	class phpcms_ftp
	{
		var $fp;
		var $data;
		var $dir;
		var $connected = 0;

		function phpcms_ftp($ftphost, $ftpuser, $ftppass, $ftpport = 21, $dir = '/', $type = 'I', $pasv = 0)
		{
			if(!preg_match("/[0-9.]{7,15}/", $ftphost))
			{
				$ftphost = gethostbyname($ftphost);
				if(!preg_match("/[0-9.]{7,15}/", $ftphost)) exit('SERVER DNS is disabled. Please set IP as FTP host.');
			}
			$this->dir = $this->set_path($dir);
			$this->fp = ftp_connect($ftphost, $ftpport) or die("Couldn't connect to $ftphost");
            $this->connected = @ftp_login($this->fp, $ftpuser, $ftppass);
			ftp_pasv($this->fp, $pasv);
        }

		function set_path($dir)
		{
			$dir = dir_path($dir);
			return $dir[0] == '/' ? $dir : '/'.$dir;
		}

		function set_dir($dir = '')
		{
			$dir = str_replace(PHPCMS_ROOT.'/', $this->dir, $dir);
			if(!$dir) $dir = $this->dir;
			return ftp_chdir($this->fp, $dir);
		}

		function chmod($path, $mode = 0777)
		{
			$path = str_replace(PHPCMS_ROOT.'/', $this->dir, $path);
			if($path == '') $path = $this->dir;
			$mode = intval($mode);
			return function_exists('ftp_chmod') ? ftp_chmod($this->fp, 0777, $path) : ftp_site($this->fp, "CHMOD 0777 $path");
		}

		function mkdir($dir, $mode = 0777)
		{
			$dir = str_replace(PHPCMS_ROOT.'/', $this->dir, $dir);
			$dir = dir_path($dir);
            ftp_mkdir($this->fp, $dir);
			$this->chmod($dir, $mode);
		}

		function rmdir($dir)
		{
			$dir = str_replace(PHPCMS_ROOT.'/', $this->dir, $dir);
			$dir = dir_path($dir);
            ftp_rmdir($this->fp, $dir);
		}

		function delete($file)
		{
			$file = str_replace(PHPCMS_ROOT.'/', $this->dir, $file);
            ftp_delete($this->fp, $file);
		}

		function get_list($dir = '')
		{
			$dir = $this->set_path($this->dir.$dir); 
			return array_map('basename', ftp_nlist($this->fp, $dir));
		}

		function is_phpcms()
		{
			$dirs = $this->get_list('include/');
			return $dirs && in_array('channel.inc.php', $dirs); 
		}

		function message()
		{
			return '';
		}
	}
}
else
{
	class phpcms_ftp
	{
		var $fp;
		var $data;
		var $ports;
		var $dir;
		var $port;
		var $ispasv;
		var $ip;
		var $connected = 0;

		function phpcms_ftp($ftphost, $ftpuser, $ftppass, $ftpport = 21, $dir = '/', $type = 'I', $pasv = 0)
		{
			if($ftphost && $ftpuser)
			{
				if(!preg_match("/[0-9.]{7,15}/", $ftphost))
				{
					$ftphost = gethostbyname($ftphost);
					if(!preg_match("/[0-9.]{7,15}/", $ftphost)) exit('SERVER DNS is disabled. Please set IP as FTP host.');
				}
				$this->connect($ftphost, $ftpuser, $ftppass, $ftpport);
				$this->set_type($type);
				if($pasv) $this->set_pasv();
				$this->dir = $this->set_path($dir);
				$this->set_dir($this->dir);
				$this->connected = strpos($this->data, '230') === FALSE ? FALSE : TRUE;
			}
		}

		function connect($ftphost, $ftpuser, $ftppass, $ftpport = 21)
		{
			$fp = fsockopen($ftphost, $ftpport);
			$this->fp = $fp;
			$this->data = fread($this->fp, 1024);
			fwrite($this->fp, "USER $ftpuser\r\n");
			$this->data .= fgets($this->fp, 1024);
			fwrite($this->fp, "PASS $ftppass\r\n");
			$this->data .= fgets($this->fp, 1024);
			fwrite($this->fp, "REST 100\r\n");
			$this->data .= fgets($this->fp, 1024);
			fwrite($this->fp, "PWD\r\n");
			$this->data .= fgets($this->fp, 1024);
		}

		function set_type($type = 'I')
		{
			fwrite($this->fp, "TYPE $type\r\n");
			$this->data .= fgets($this->fp, 1024);
		}

		function set_dir($dir = '')
		{
			$dir = str_replace(PHPCMS_ROOT.'/', $this->dir, $dir);
			if(!$dir) $dir = $this->dir;
			fwrite($this->fp, "CWD $dir\r\n");
			$this->data .= fgets($this->fp, 1024);
			if($this->ispasv && !$this->port) $this->get_pasvs();
		}

		function set_pasv()
		{
			fwrite($this->fp, "PASV\r\n");
			$this->data .= fgets($this->fp, 1024);
			$this->ispasv = 1;
		}

		function set_path($dir)
		{
			$dir = dir_path($dir);
			return $dir[0] == '/' ? $dir : '/'.$dir;
		}

		function chmod($path, $mode = 777)
		{
			$path = str_replace(PHPCMS_ROOT.'/', $this->dir, $path);
			if($path == '') $path = $this->dir;
			$mode = intval($mode);
			fwrite($this->fp, "SITE CHMOD $mode $path\r\n");
			$this->data .= fgets($this->fp, 1024);
		}

		function mkdir($dir, $mode = 777)
		{
			$dir = str_replace(PHPCMS_ROOT.'/', $this->dir, $dir);
			$dir = dir_path($dir);
			fwrite($this->fp, "MKD $dir\r\n");
			$this->data .= fgets($this->fp, 1024);
			$this->chmod($dir, $mode);
		}

		function rmdir($dir)
		{
			$dir = str_replace(PHPCMS_ROOT.'/', $this->dir, $dir);
			$dir = dir_path($dir);
			fwrite($this->fp, "RMD $dir\r\n");
			$this->data .= fgets($this->fp, 1024);
		}

		function delete($file)
		{
			$file = str_replace(PHPCMS_ROOT.'/', $this->dir, $file);
			fwrite($this->fp, "DELE $file\r\n");
			$this->data .= fgets($this->fp, 1024);
		}

		function get_list($dir = '')
		{
			$dir = $this->set_path($this->dir.$dir); 
			fwrite($this->fp, "NLST $dir\r\n");
			$sock_data = fsockopen($this->ip, $this->port);
			if(!$sock_data) return FALSE;
			$name = array();
			while(!feof($sock_data))
			{
				$line = fgets($sock_data, 1024);
				$this->data .= $line;
				$line = basename(trim($line));
				if($line) $name[] = $line;
			}
			return $name;
		}

		function is_phpcms()
		{
			$dirs = $this->get_list('include/');
			return $dirs && in_array('channel.inc.php', $dirs); 
		}

		function message()
		{
			return nl2br($this->data);
		}

		function get_pasvs() 
		{
		   if(!preg_match("/(227.+\()([0-9]{1,3},[0-9]{1,3},[0-9]{1,3},[0-9]{1,3},[0-9]+,[0-9]+)(\).*\r\n)/i", $this->data, $m)) return FALSE;
			$DATA = explode(',', $m[2]); 
			$this->ip = $DATA[0].'.'.$DATA[1].'.'.$DATA[2].'.'.$DATA[3]; 
			$this->port = $DATA[4]*256 + $DATA[5];
		} 
	}
}
?>