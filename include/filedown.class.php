<?php
//defined('IN_PHPCMS') or exit('Access Denied');

class filedown
{
	var $mdownstart;
	var $mfilesize;
	var $mfilehandle;
	var $mfilepath;
	var $mfilename;
	var $mfileext;

	function filedown()
	{
	}

	//public
	function down($pfilepath, $pfilename = '')
	{
		$this->mfilepath = $pfilepath;
		if(!$this->ini_file()) $this->send_error();
		$this->mfilename = empty($pfilename) ? $this->get_filename() : $pfilename;
		$this->set_start();
		$this->set_header();
		$this->send();
	}

	function ini_file()
	{
		if(!is_file($this->mfilepath)) return FALSE;
		$this->mfilehandle = fopen($this->mfilepath, 'rb');
		$this->mfilesize = filesize($this->mfilepath);
		$this->mfileext = fileext($this->mfilepath);
		return TRUE;
	}

	function set_start()
	{
		if(!empty($_server['http_range']) && preg_match("/^bytes=([\d]?)-([\d]?)$/i", $_server['http_range'], $match))
		{
		    if(empty($match[1])) $this->mdownstart = $match[1];
		    fseek($this->mfilehandle, $this->mdownstart);
		}
		else
		{
		    $this->mdownstart = 0;
		}
	}

	function set_header()
	{
		@header("cache-control: public");
		@header("pragma: public");
		header("content-length: " . ($this->mfilesize - $this->mdownstart));
		if ($this->mdownstart > 0)
		{
		    @header("http/1.1 206 partial content");
		    header("content-ranges: bytes" . $this->mdownstart . "-" . ($this->mfilesize - 1) . "/" . $this->mfilesize);
		}
		else
		{
		    header("accept-ranges: bytes");
		}
		header("content-disposition: attachment; filename=" .$this->mfilename);
		header("content-type:".$this->get_filetype());
	}

	function get_filename()
	{
		return basename($this->mfilepath);
	}

	function get_filetype()
	{
		$filetype['chm']='application/octet-stream'; 
		$filetype['ppt']='application/vnd.ms-powerpoint'; 
		$filetype['xls']='application/vnd.ms-excel'; 
		$filetype['doc']='application/msword'; 
		$filetype['exe']='application/octet-stream'; 
		$filetype['rar']='application/octet-stream'; 
		$filetype['js']="javascript/js"; 
		$filetype['css']="text/css"; 
		$filetype['hqx']="application/mac-binhex40"; 
		$filetype['bin']="application/octet-stream"; 
		$filetype['oda']="application/oda"; 
		$filetype['pdf']="application/pdf"; 
		$filetype['ai']="application/postsrcipt"; 
		$filetype['eps']="application/postsrcipt"; 
		$filetype['es']="application/postsrcipt"; 
		$filetype['rtf']="application/rtf"; 
		$filetype['mif']="application/x-mif"; 
		$filetype['csh']="application/x-csh"; 
		$filetype['dvi']="application/x-dvi"; 
		$filetype['hdf']="application/x-hdf"; 
		$filetype['nc']="application/x-netcdf"; 
		$filetype['cdf']="application/x-netcdf"; 
		$filetype['latex']="application/x-latex"; 
		$filetype['ts']="application/x-troll-ts"; 
		$filetype['src']="application/x-wais-source"; 
		$filetype['zip']="application/zip"; 
		$filetype['bcpio']="application/x-bcpio"; 
		$filetype['cpio']="application/x-cpio"; 
		$filetype['gtar']="application/x-gtar"; 
		$filetype['shar']="application/x-shar"; 
		$filetype['sv4cpio']="application/x-sv4cpio"; 
		$filetype['sv4crc']="application/x-sv4crc"; 
		$filetype['tar']="application/x-tar"; 
		$filetype['ustar']="application/x-ustar"; 
		$filetype['man']="application/x-troff-man"; 
		$filetype['sh']="application/x-sh"; 
		$filetype['tcl']="application/x-tcl"; 
		$filetype['tex']="application/x-tex"; 
		$filetype['texi']="application/x-texinfo"; 
		$filetype['texinfo']="application/x-texinfo"; 
		$filetype['t']="application/x-troff"; 
		$filetype['tr']="application/x-troff"; 
		$filetype['roff']="application/x-troff"; 
		$filetype['shar']="application/x-shar"; 
		$filetype['me']="application/x-troll-me"; 
		$filetype['ts']="application/x-troll-ts"; 
		$filetype['gif']="image/gif"; 
		$filetype['jpeg']="image/pjpeg"; 
		$filetype['jpg']="image/pjpeg"; 
		$filetype['jpe']="image/pjpeg"; 
		$filetype['ras']="image/x-cmu-raster"; 
		$filetype['pbm']="image/x-portable-bitmap"; 
		$filetype['ppm']="image/x-portable-pixmap"; 
		$filetype['xbm']="image/x-xbitmap"; 
		$filetype['xwd']="image/x-xwindowdump"; 
		$filetype['ief']="image/ief"; 
		$filetype['tif']="image/tiff"; 
		$filetype['tiff']="image/tiff"; 
		$filetype['pnm']="image/x-portable-anymap"; 
		$filetype['pgm']="image/x-portable-graymap"; 
		$filetype['rgb']="image/x-rgb"; 
		$filetype['xpm']="image/x-xpixmap"; 
		$filetype['txt']="text/plain"; 
		$filetype['c']="text/plain"; 
		$filetype['cc']="text/plain"; 
		$filetype['h']="text/plain"; 
		$filetype['html']="text/html"; 
		$filetype['htm']="text/html"; 
		$filetype['htl']="text/html"; 
		$filetype['rtx']="text/richtext"; 
		$filetype['etx']="text/x-setext"; 
		$filetype['tsv']="text/tab-separated-values"; 
		$filetype['mpeg']="video/mpeg"; 
		$filetype['mpg']="video/mpeg"; 
		$filetype['mpe']="video/mpeg"; 
		$filetype['avi']="video/x-msvideo"; 
		$filetype['qt']="video/quicktime"; 
		$filetype['mov']="video/quicktime"; 
		$filetype['moov']="video/quicktime"; 
		$filetype['movie']="video/x-sgi-movie"; 
		$filetype['au']="audio/basic"; 
		$filetype['snd']="audio/basic"; 
		$filetype['wav']="audio/x-wav"; 
		$filetype['aif']="audio/x-aiff"; 
		$filetype['aiff']="audio/x-aiff"; 
		$filetype['aifc']="audio/x-aiff"; 
		$filetype['swf']="application/x-shockwave-flash";
		return array_key_exists($this->mfileext, $filetype) ? $filetype[$this->mfileext] : $this->mfileext;
	}

	function send()
	{
		fpassthru($this->mfilehandle);
	}

	//public 
	function send_error()
	{
		@header("http/1.0 404 not found");
		@header("status: 404 not found");
		exit();
	}
}
?> 