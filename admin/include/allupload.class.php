<?php
defined('IN_PHPCMS') or exit('Access Denied');

$UPLOAD_CLASS_ERROR = array( 0 => 'File upload success',
                             1 => 'File upload fail,the filesize is over the option(upload_max_filesize) in php.ini',
                             2 => 'File is too large',
                             3 => 'Not allowed to upload such type of file',
                             4 => 'the directory is not writeable',
                             5 => 'File existed',
							 6 => 'File upload fail,can not find the temp upload directory',
                           );


class upload
{

    var $file;
    var $file_name;
    var $file_size;
    var $file_type;
	var $file_error;
    var $savename;
    var $savepath;
	var $saveto;
    var $fileformat = "jpg|jpeg|gif|bmp|png|doc|txt|rar|zip|htm|html";
    var $overwrite = 0;
    var $maxsize = 0;
    var $ext;
    var $errno;

    function upload($fileArr, $savename, $savepath, $fileformat, $overwrite = 0, $maxsize = 0)
	{
        $this->file = $fileArr['file'];
        $this->file_name = $fileArr['name'];
        $this->file_size = $fileArr['size'];
        $this->file_type = $fileArr['type'];
		$this->file_error = $fileArr['error'];

        $this->get_ext();
        $this->set_savepath($savepath);
        $this->set_fileformat($fileformat);
        $this->set_overwrite($overwrite);
        $this->set_savename($savename);
        $this->set_maxsize($maxsize);
    }

    function up()
    {
		if($this->file_error == UPLOAD_ERR_PARTIAL || $this->file_error == UPLOAD_ERR_NO_FILE )
		{
			$this->errno = 1;
			return false;
		}

        if ($this->file_error == UPLOAD_ERR_INI_SIZE || $this->file_error == UPLOAD_ERR_FORM_SIZE || ($this->maxsize > 0 && $this->file_size > $this->maxsize))
        {
             $this->errno = 2;
             return false;
        }

        if (!$this->validate_format())
        {
            $this->errno = 3;
            return false;
        }

        if(!@is_writable(PHPCMS_ROOT."/".$this->savepath))
        {
            $this->errno = 4;
            return false;
        }

        if($this->overwrite == 0 && @file_exists($this->saveto))
        {
            $this->errno = 5;
            return false;
        }

        if(!@move_uploaded_file($this->file, PHPCMS_ROOT."/".$this->saveto) && !@copy($this->file, PHPCMS_ROOT."/".$this->saveto))
        {
            $this->errno = 6;
            return false;
        }
	    $this->errno = 0;
        return true;
    }

    function validate_format()
    {
        return true; 
    }


    function get_ext()
    {
        $this->ext = strtolower(trim(substr(strrchr($this->file_name, '.'), 1)));
    }


    function set_maxsize($maxsize)
    {
        $this->maxsize = intval($maxsize);
    }


    function set_overwrite($overwrite=1)
    {
        $this->overwrite = intval($overwrite) == 1 ? 1 : 0;
    }

    function set_fileformat($fileformat)
    {
        $this->fileformat = $fileformat;
    }

    function set_savepath($savepath)
    {
		$savepath = str_replace("\\", "/", $savepath);
	    $savepath = substr($savepath,-1)=="/" ? $savepath : $savepath."/";
        $this->savepath = $savepath;
    }

    function set_savename($savename)
    {
        if (!$savename)
        {
            $this->savename = $this->file_name;
        } else {
            $this->savename = $savename;
        }
		$this->saveto = $this->savepath.$this->savename;
    }

    function errmsg()
    {
        global $UPLOAD_CLASS_ERROR;
        if ($this->errno == 0)
            return false;
        else
            return $UPLOAD_CLASS_ERROR[$this->errno];
    }
}
?>