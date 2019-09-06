<?php
defined('IN_PHPCMS') or exit('Access Denied');

/**
* 定义错误提示信息
*/
$UPLOAD_CLASS_ERROR = array( 0 => 'File upload success',
                             1 => 'File upload fail,the filesize is over the option(upload_max_filesize) in php.ini',
                             2 => 'File is too large',
                             3 => 'Not allowed to upload such type of file',
                             4 => 'the directory is not writeable',
                             5 => 'File existed',
							 6 => 'File upload fail,can not find the temp upload directory',
                           );

/**
* 文件上传类，可实现文件的安全上传
*/
class upload
{
	/**
	* 临时文件路径
	*/
    var $file;
	/**
	* 文件名
	*/
    var $file_name;
	/**
	* 文件大小
	*/
    var $file_size;
	/**
	* 文件类型
	*/
    var $file_type;
	/**
	* 上传错误
	*/
	var $file_error;

    /**
	* 保存名
	*/
    var $savename;

    /**
	* 保存路径
	*/
    var $savepath;
	/**
	* 保存地址 
	*/
	var $saveto;
    /**
	* 文件格式限定，多个后缀之间用 | 隔开
	*/
    var $fileformat = "jpg|jpeg|gif|bmp|png|doc|txt|rar|zip|htm|html";
    /**
	* 覆盖模式 
	*/
    var $overwrite = 0;
    /**
	* 文件最大字节 
	*/
    var $maxsize = 0;
    /**
	* 文件扩展名
	*/
    var $ext;
    /**
	* 错误代号
	*/
    var $errno;

    /**
     * 构造函数
     * @param array 文件信息数组 'file' 临时文件所在路径及文件名
                                 'name' 上传文件名
                                 'size' 上传文件大小
                                 'type' 上传文件类型
     * @param string 文件保存名
     * @param string 文件保存路径
     * @param string 文件格式限制，例如 jpg|gif|bmp|png|rar|zip|doc|txt
     * @param bool 是否覆盖 1 允许覆盖 0 禁止覆盖
     * @param int 文件最大尺寸
     */
    function upload($fileArr, $savename, $savepath, $fileformat, $overwrite = 0, $maxsize = 0) {
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

    /**
	* 上传文件
	*/
    function up()
    {
		if($this->file_error == UPLOAD_ERR_PARTIAL || $this->file_error == UPLOAD_ERR_NO_FILE )
		{//|| $this->file_error == UPLOAD_ERR_NO_TMP_DIR
			$this->errno = 1;
			return false;
		}

        /** 如果有大小限制，检查文件是否超过限制 */
        if ($this->file_error == UPLOAD_ERR_INI_SIZE || $this->file_error == UPLOAD_ERR_FORM_SIZE || ($this->maxsize > 0 && $this->file_size > $this->maxsize))
        {
             $this->errno = 2;
             return false;
        }

        /** 检查文件格式 */
        if (!$this->validate_format())
        {
            $this->errno = 3;
            return false;
        }
        /** 检查目录是否可写 */
        if(!@is_writable(PHPCMS_ROOT.'/'.$this->savepath))
        {
            $this->errno = 4;
            return false;
        }
        /** 如果不允许覆盖，检查文件是否已经存在 */
        if($this->overwrite == 0 && @file_exists($this->saveto))
        {
            $this->errno = 5;
            return false;
        }
        /** 文件上传 */
        if(!$this->uploadfile($this->file, PHPCMS_ROOT.'/'.$this->saveto))
        {
            $this->errno = 6;
            return false;
        }
	    $this->errno = 0;
		chmod(PHPCMS_ROOT.'/'.$this->saveto, 0777);
        return true;
    }

	function uploadfile($file, $saveto)
	{
		global $PHPCMS;
		return $PHPCMS['uploadfunctype'] ? @move_uploaded_file($file, $saveto) : @copy($file, $saveto);
	}

    /**
     * 文件格式检查
     * @access private
     */
    function validate_format()
    {
        return $this->fileformat && preg_match("/^(".$this->fileformat.")$/i",$this->ext) && !preg_match("/^(php|php3|php4)$/i",$this->ext);
    }

    /**
     * 获取文件扩展名
     */
    function get_ext()
    {
        $this->ext = strtolower(trim(substr(strrchr($this->file_name, '.'), 1)));
    }

    /**
     * 设置上传文件的最大字节限制
     * @param int 文件大小(bytes) 0:表示无限制
     */
    function set_maxsize($maxsize)
    {
        $this->maxsize = intval($maxsize);
    }

    /**
     * 设置覆盖模式
     * @param bool 覆盖模式 1:允许覆盖 0:禁止覆盖
     */
    function set_overwrite($overwrite=1)
    {
        $this->overwrite = intval($overwrite) == 1 ? 1 : 0;
    }

    /**
     * 设置允许上传的文件格式
     * @param $fileformat 允许上传的文件扩展名数组
     */
    function set_fileformat($fileformat)
    {
        $this->fileformat = $fileformat;
    }

    /**
     * 设置保存路径
     * @param string 文件保存路径：以 "/" 结尾
     */
    function set_savepath($savepath)
    {
		$savepath = str_replace("\\", "/", $savepath);
	    $savepath = substr($savepath,-1)=="/" ? $savepath : $savepath."/";
        $this->savepath = $savepath;
    }

    /**
     * 设置文件保存名
     * @param string 保存名，如果为空，则系统自动生成一个随机的文件名
     */
    function set_savename($savename)
    {
        if (!$savename)  // 如果未设置文件名，则生成一个随机文件名
        {
            srand ((double) microtime() * 1000000);
            $name = date('Ymdhis').rand(100,999);
            $this->savename = $name.".".$this->ext;
        } else {
            $this->savename = $savename;
        }
		$this->saveto = $this->savepath.$this->savename;
    }

    /**
     * 得到错误信息
     * @return error msg string or false
     */
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