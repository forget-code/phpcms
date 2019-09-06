<?php
class maillist
{
	var $mail_setdir = '';
	var $mail_datadir = '';
    var $mail_files = '';

	function maillist()
	{
		global $db;
		$this->mail_setdir = PHPCMS_ROOT.'data/mail/';
		$this->mail_datadir = PHPCMS_ROOT.'data/mail/data/';
        $this->mail_files = 'data/mail/data';
		dir_create($this->mail_setdir);
		dir_create($this->mail_datadir);
	}

	function get_list()
	{
		$fmail = glob($this->mail_datadir."*.txt");
		$fnumber = count($fmail);
		$mailfiles = array();
		if($fnumber > 0)
		{
			foreach( $fmail as $key=>$val)
			{
				$mailfiles[$key] = basename($val);
			}
		}
		unset($fmail);
		return $mailfiles;
	}

	/**
	 *
	 *	@params array or sting $filename
	 *	@return
	 */

	function drop( $file )
	{
		if (is_array($file))
		{
			foreach ($file as $key => $value )
			{
				$filename = $this->mail_datadir.trim($value);
				if(!preg_match("/^[0-9a-z_]+\.txt$/i",$value)) showmessage($LANG['illegal_file']);
				if(file_exists($filename))
				{
					@unlink($filename);
				}
			}
		}
		else
		{
			if(file_exists($this->mail_datadir.$file))
			{
				@unlink($this->mail_datadir.$file);
			}
		}
		return TRUE;
	}


    function uploadfile()
    {
        require_once PHPCMS_ROOT.'include/upload.class.php';
		$savepath = $this->mail_files;
		$savename = 'phpcms_'.time();
		$upload = new upload('uploadfile', $savepath, $savename.'.txt', 'txt');
		if(!$upload->up())  showmessage($upload->error());
        $name = basename($savepath.$upload->uploadedfiles[0][filepath]);
		copy( $savepath.$upload->uploadedfiles[0][filepath], $savepath.$name );
		dir_delete($savepath.date('Y'));
        showmessage("上传文件成功","?mod=mail&file=maillist&action=list");
    }

	function error()
	{
		$ERRORMSG = array(
                0=>'文件不存在',
			    1=>'请选择订阅类别',
	    );
		return $ERRORMSG[$this->error];
	}

}
?>