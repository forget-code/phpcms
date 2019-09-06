<?php
class subscription
{
	var $db = '';
	var $mail_table = '';
	var $t_table = '';
	var $lang ;
    var $mail = '';

	function subscription()
	{
		global $db ,$LANG;
		$this->lang = $LANG;
		$this->db = $db;
		$this->table_mail = DB_PRE.'mail';
		$this->table_t = DB_PRE.'mail_email_type';
	}

	function get_list($condition = null, $page = 1, $pagesize )
	{
		$page = max(intval($page), 1);
		$offset = $pagesize*($page-1);
		$arg['where'] = $this->_make_condition($condition);
		$subscriptions = array();
		$subscriptions['num'] = $this->db->get_one("SELECT COUNT(*) AS number FROM `$this->table_mail` WHERE 1 {$arg['where']}");
		$subscriptions['pages'] = pages($subscriptions['num']['number'], $page, $pagesize);
		$sql = "SELECT * FROM `$this->table_mail` WHERE 1  {$arg['where']} ORDER BY `mailid` DESC limit $offset,$pagesize";
		$result = $this->db->query($sql);
		$mailtype = subtype('mail');
        $api = load('member_api.class.php','member','api');
		while($r = $this->db->fetch_array($result))
		{
			if(!$r['sendtime'])
			{
				$r['sendtime'] = '未发送';
			}
			else
			{
				$r['sendtime'] = date('Y-m-d H:i:s',$r['sendtime']);
			}
			$r['addtime'] = date('Y-m-d H:i:s' , $r['addtime']);
			$r['typename'] =  $mailtype[$r['typeid']]['name'];
            $r['typestyle'] = $mailtype[$r['typeid']]['style'];
			$subscriptions['info'][] = $r;
		}
		return $subscriptions;
	}

	function add( $data )
	{
        if(!empty($data))
        {
            return $this->db->insert($this->table_mail , $data);
        }
	}

	function update( $data , $mailid)
	{
        global $_userid,$_username;
        $data['userid'] = trim($_userid);
        $data['username'] = trim($_username);
		$mailid = intval($mailid);
		return $this->db->update($this->table_mail , $data , "`mailid` = $mailid");
	}

	function drop($mailid)
	{
		$mailid = intval($mailid);
        $sql = "DELETE FROM `$this->table_mail` WHERE `mailid` = '{$mailid}'";
        return $this->db->query($sql);
	}

    function dropTypeContent($typeid)
    {
        $typeid = intval($typeid);
        $sql = "DELETE FROM `$this->table_mail` WHERE `typeid` = '{$typeid}' ";
        return $this->db->query($sql);
    }
	function get_one_list($mailid)
	{
		$mailid = intval($mailid);
		$sql = "SELECT * FROM $this->table_mail WHERE `mailid` = '$mailid' ";
		return $this->db->get_one($sql);
	}

	/**
	 *	更新邮件发送时间
	 *	@params
	 *	@return
	 */

	function update_send($mailid)
	{
		$mailid = intval($mailid);
		$time = TIME;
		$sql = "UPDATE `$this->table_mail` SET `sendtime` = '$time', `count` = count +1 WHERE `mailid` = '$mailid' ";
		return $this->db->query($sql);
	}

	function get_message($condition = null, $page = 1, $pagesize)
	{
		$page = max(intval($page), 1);
		$offset = $pagesize*($page-1);
		$message = array();
		$message['num'] = $this->db->get_one("SELECT COUNT(mailid) AS number FROM  `$this->table_mail` ");
		$sql ="SELECT `mailid` , `typeid` , `title` , `addtime` , `sendtime` , `username` ,`period`, `count`  ".
				"FROM ".DB_PRE."mail ORDER BY `period` DESC limit $offset,$pagesize";
		$result = $this->db->query($sql);
		$message['pages'] = pages($message['num']['number'],$page,$pagesize);
		while($r = $this->db->fetch_array($result))
		{
			$num = $this->db->get_one("SELECT count(email) as num FROM ".DB_PRE."mail_email_type WHERE `typeid` = '".$r['typeid']."'" );
			$r['num'] = $num['num'];
			$r['addtime'] = date('Y-m-d  H:i:s',$r['addtime']);
			$r['sendtime'] = $r['sendtime'] ? date('Y-m-d H:i:s',$r['sendtime']) : '';
            $r['stauts'] = $r['sendtime'] ? '已发送' : '<font color=red>未发送</font>';
			$message['info'][] = $r;
		}
		return $message;
	}

	function get_mail_msg($mailid)
	{
		$mailid = intval($mailid);
		return $this->db->get_one("SELECT `title`, `content` FROM  `$this->table_mail` WHERE `mailid` = '{$mailid}' ");
	}
	function get_mail_num($typeid)
	{
		$typeid = intval($typeid);
		$num = $this->db->get_one("SELECT COUNT(email) AS number FROM `$this->table_t` WHERE `typeid` = '{$typeid}' ");
		return $num['number'];
	}
	function send_m_mail($typeid, $start, $maxnum, $mailid)
	{
        global $PHPCMS;
        $this->mail = load('sendmail.class.php');
		$start = isset($start) ? intval($start) : 0;
		$maxnum = intval($maxnum);
		$typeid = intval($typeid);
        $startnum = $start + $maxnum;
        $sql = "SELECT `email` FROM `$this->table_t` WHERE `typeid` = '{$typeid}' limit $start,$maxnum" ;
		$result = $this->db->query($sql);
		while ($r = $this->db->fetch_array($result))
		{
			$s = $r['email'];
			if ($s != '' && is_email($s))
			{
				$temp .= $s.',';
			}
		}
		$tempsendto = substr($temp, 0, -1);
        $mail_content = $this->get_mail_msg($mailid);
        $url = "?mod=mail&file=subscription&action=send&job=start&mailid=$mailid&startnum=$startnum&typeid=$typeid&maxnum=$maxnum&total=$total";
        if($this->mail->send($tempsendto, stripslashes($mail_content['title']), stripslashes($mail_content['content']), $PHPCMS['mail_user']))
        {
            showmessage('正在发送从'.$start.'到'.$startnum.'个电子邮件,发送成功', $url);
        }
        else
        {
            return FALSE;
        }
	}

	function _make_condition($conditions)
	{
		$where = '';
		if(is_array($conditions))
		{
			$where .= implode(' AND ', $conditions);
		}
		if ($where)
		{
			return ' AND ' . $where;
		}
	 }
}