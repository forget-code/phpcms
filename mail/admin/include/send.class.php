<?php
class send
{
	var $mail_datadir = '';
	var $error = '';
    var $mail = '';
    var $max_mail = '';
    var $maxnum = '';
	function send()
	{
        global $M;
		$this->mail_datadir = PHPCMS_ROOT.'data/mail/data/';
        $this->mail = load('sendmail.class.php');
        $this->maxnum = $M['maxnum'];
	}

    function send_one($email, $title, $content, $fromemail)
    {
        return $this->mail->send($email, stripslashes($title), stripslashes($content), $fromemail);
    }

    function send_many($num = '',$MultiEmail = array(), $title, $content, $fromemail)
	{
		$maxnum = !empty($maxnum) ? intval($maxnum) : 10;
		$MultiEmail = str_replace("\r", "", $MultiEmail);
		$MultiEmail = str_replace("\n", ",", $MultiEmail);
		$MultiEmail = explode(",", $MultiEmail);
		$toemail = array();
		foreach($MultiEmail AS $email)
		{
			if($email == '' || !is_email($email)) continue;
			else
			{
				$toemail[] = $email;
			}
		}
		$temp_mail = implode(',', $toemail);
        return $this->mail->send($temp_mail, stripslashes($title), stripslashes($content), $fromemail);
	}

    function send_file($file, $start)
	{
        $temp_content = $this->get_cache();
        $start = isset($start) ? intval($start) : 0;
		$maxnum = intval($temp_content['maxnum']);// max
		$sendmail = array();
        $temp_mail = $this->get_mail($file, $start, $maxnum);
        $temp_total = $start + $maxnum;
        if($temp_mail['totalnum'] > $start)
        {
		    if($this->mail->send($temp_mail['tempmail'], stripslashes($temp_content['title']), stripslashes($temp_content['content']), $temp_content['fromemail']))
            {
                $url = "?mod=mail&file=send&type=3&maillistfile=$file&dosubmit=1";
                $url .= '&start='.$temp_total;
                showmessage('从'.$start.'发送到'.$temp_total.',成功发送!',$url);
			}
        }
        else
        {
            return FALSE;
        }
	}

    function set_cache($data = array())
    {
        return cache_write('mail_content.php', $data);
    }

    function get_cache()
    {
        if(file_exists(CACHE_PATH.'mail_content.php'))
        $content = cache_read('mail_content.php');
        return $content;
    }

    function get_mail($file, $start, $maxnum)//开始。结束
    {
        if(file_exists($this->mail_datadir.$file))
		{
			$sendtoemail = file($this->mail_datadir.$file);
		}
        $totalnum = count($sendtoemail);
        if ($totalnum)
		{
		 	if ($start >= $totalnum)
		 	{
				@unlink(CACHE_PATH.'mail_cache.php');
                return ;
		 	}
			else
		 	{
                $tempmail = '';
		 		for ($i = $start; $i < $start + $maxnum; $i++)
		 		{
					if($i >= $totalnum) break;
		 			$m = trim($sendtoemail[$i]);
		 			if ($m != '' && is_email($m))
		 			{
		 				$tempmail .= $m.',';
		 			}
		 		}
		 		$sendmail['tempmail']   = substr($tempmail,0,-1);
		 		$sendmail['start']      = $start + $maxnum;
                $sendmail['totalnum']   = $totalnum;//邮箱总数
                return $sendmail;
		 	}
		}
    }
    function getFileMail()
    {
        $fmail      = glob($this->mail_datadir.'*.txt');
        $fnumber    = count($fmail);
        $mailfiles = array();
        if($fnumber > 0 )
        {
            foreach($fmail as $key => $val)
            {
                $mailfiles[$key] = basename($val);
            }
            return $mailfiles;
        }
    }
	function error()
	{
		$ERRORMSG = array(
				0 => '发送完成'
			);
		return $ERRORMSG[$this->error];
	}
}
?>