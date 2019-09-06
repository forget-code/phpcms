<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(!class_exists('member'))
{
	require PHPCMS_ROOT.'member/include/member.class.php';
}

class message
{
	var $table;
	
	function __construct()
	{
		global $db, $_userid, $msg_status;
		$this->db = &$db;
		$this->table = DB_PRE.'message';
	}
		
	function message()
	{
		$this->__construct();	
	}
	
	/**
	 * 发送新短信
	 *
	 * @param INT $msgtoid
	 * @param INT $msgfromid
	 * @param TEXT $subject
	 * @param TEXT $message
	 * @return $message
	 */
	function send_new($send_to_id, $send_from_id, $subject, $content='', $savetooutbox=0)
	{
		$send_to_id = intval($send_to_id);
		$send_from_id = intval($send_from_id);
		if(!$send_to_id || !$send_from_id)
		{
			$this->msg = 'user_not_existed';
			return false;
		}
		elseif(strlen($subject) > 50 || strlen($subject) < 1)
		{
			$this->msg = 'msg_subjec_is_null';
			return false;
		}
		$dateline = TIME;
		$folder = $savetooutbox ? 'all' : 'inbox';
		$subject= new_htmlspecialchars($subject);
		$arr_message = array('send_to_id'=>$send_to_id, 'send_from_id'=>$send_from_id, 'folder'=>$folder, 'status'=>1, 'message_time'=>$dateline, 'subject'=>$subject, 'content'=>$content);
		$this->db->insert($this->table, $arr_message);
		$msgid = $this->db->insert_id();
		return $msgid;
	}
		
	/**
	 * 回复短消息
	 *
	 * @param INT $replyid
	 * @param INT $msgfromid
	 * @param STRING $content
	 * @return $msgid
	 */
	function reply($replyid, $send_to_id, $send_from_id, $content = '')
	{
		$messageid = $replyid = intval($replyid);
		$send_to_id = intval($send_to_id);
		$send_from_id = intval($send_from_id);
		if($replyid < 1 || $send_from_id < 1 || $send_to_id < 1)
		{
			$this->msg = 'user_not_existed';
			return false;
		}
		$arr_user = $this->_get($replyid);
		$userid = $arr_user['send_to_id'];
		$status = ($userid == $send_to_id) ? 1 : 2;
		$arr_folder = array('folder'=>'all', 'status'=>$status);
		$this->db->update($this->table, $arr_folder, "`messageid`='$replyid'");
		$arr_message = array('send_to_id'=>$send_to_id, 'send_from_id'=>$send_from_id, 'folder'=>'inbox', 'status'=>0, 'message_time'=>TIME, 'content'=>$content, 'replyid'=>$replyid);
		$this->db->insert($this->table, $arr_message);
		$msgid = $this->db->insert_id();
		return $msgid;
	}
	
	/**
	 * 未读的短消息
	 *
	 * @param int $userid
	 * @param int $page
	 * @param int $pagesize
	 * @param string $order
	 * @return unknown
	 */
	function newmsg($userid, $page, $pagesize, $order = 'message_time DESC')
	{
		$userid = intval($userid);
		if($userid < 1) return false;
		$arr_message = $this->_listinfo($where = " send_to_id='$userid' AND (folder='inbox' OR folder='all') AND replyid=0 AND status=1", $order, $page, $pagesize);
		return $arr_message;
	}
	
	/**
	 * 列出某个用户的收件箱消息
	 *
	 * @param INT $userid
	 * @return $message
	 */
	function inbox($userid, $page, $pagesize, $order = 'status DESC, message_time DESC')
	{
		$userid = intval($userid);
		if($userid < 1) return false;
		$arr_message = $this->_listinfo($where = " send_to_id='$userid' AND (folder='inbox' OR folder='all') AND replyid=0", $order, $page, $pagesize);
		return $arr_message;
	}
	
	/**
	 * 列出用户的发件箱的消息
	 *
	 * @param INT $userid
	 * @return $message
	 */
	function outbox($userid, $page, $pagesize, $order = 'status DESC, message_time DESC')
	{
		$userid = intval($userid);
		if($userid < 1) return false;
		$arr_message = $this->_listinfo($where = " send_from_id='$userid' AND (folder='outbox' OR folder='all')" , $order, $page, $pagesize);
		return $arr_message;
	}
	
	/**
	 * 把信息从数据库导为excel
	 *
	 * @param Array $arr_msgid
	 * @return $array
	 */
	function export($arr_msgid = Array())
	{
		global $LANG;
		if(!is_array($arr_msgid) && empty($arr_msgid))
		{
			$this->msg = 'please_choose_msg';
			return false;
		}
		foreach ($arr_msgid as $msgid)
		{
			$r = $this->_get($msgid);
			if($r['folder']) $r['folder'] = $LANG[$r['folder']];
			unset($r['message_time'], $r['send_from_id'], $r['send_to_id'], $r['replyid'], $r['status'], $r['num_reply']);
			$array[] = $r;
		}
		return $array;
	}
	
	/**
	 * 列出有关短信的回复信息
	 *
	 * @param INT $msgid
	 * @return $reply_message
	 */
	function list_reply($msgid)
	{
		$msgid = intval($msgid);
		if($msgid < 1) return false;
		$reply_message = $this->_listinfo($where = " replyid=$msgid", $order = 'message_time DESC');
		return $reply_message;
	}
	
	/**
	 * 读取新的用户新短信
	 *
	 * @param unknown_type $msgid
	 * @return unknown
	 */
	function read($userid, $msgid)
	{
		global $G;
		$status = '0';
		$userid = intval($userid);
		if($userid < 1) return false;
		$num_message = $this->count_message($where = " (send_to_id='$userid' OR send_from_id='$userid') AND replyid=0");
		$member_api = load('member_api.class.php', 'member', 'api');
		$message_info = $this->_get($msgid, $where = "send_to_id=$userid");
		if($message_info['status'] == 1 && $num_message > $G['allowmessage'])
		{
			$this->msg = 'msg_limit_is_reached';
			return false;
		}
		if($message_info['send_from_id']) $message_info['avatar'] = avatar($message_info['send_from_id']);
		$info = array('status'=>$status);
		if($message_info['status'] == 1 && $message_info['send_to_id'] == $userid)
		{
			$this->db->update($this->table, $info, $where = "messageid='$msgid'");
		}
		$num_new_message = $this->count_message(" send_to_id='$userid' AND status=1");
		if($num_new_message == 0)
		{
			
			$arr_update = array('message'=>0);
			$member_api->set($userid, $arr_update);
		}
		return $message_info;
	}

	/**
	 * 阅读在发件箱里的信息
	 *
	 * @param unknown_type $msgid
	 * @return unknown
	 */
	function read_send($userid, $msgid)
	{
		global $G;
		$status = '0';
		$userid = intval($userid);
		if($userid < 1) return false;
		$num_message = $this->count_message($where = ' send_from_id='.$userid);
		$message_info = $this->_get($msgid, $where = "send_from_id=$userid");
		$info = array('status'=>$status);
		if($message_info['send_from_id']) $message_info['avatar'] = avatar($message_info['send_from_id']);
		$info = array('status'=>$status);
		if($message_info['status'] == 2 && $message_info['send_from_id'] == $userid)
		{
			$this->db->update($this->table, $info, $where = "messageid='$msgid'");
		}
		return $message_info;
	}
	
	
	/**
	 * 计算用户的消息数
	 *
	 * @param INT $userid
	 * @return $message_num
	 */
	function count_message($where = '')
	{
		$where = empty($where) ? '' : 'WHERE '.$where;
		$message_num = $this->db->get_one("SELECT COUNT(messageid) as number FROM $this->table $where");
		return $message_num['number'];
	}
	
	/**
	 * 统计某条短信的回复数
	 *
	 * @param INT $msgid
	 * @return $reply_num
	 */
	function _count_reply($msgid)
	{
		$reply_num = $this->db->get_one("SELECT COUNT(messageid) AS replynum FROM $this->table WHERE replyid='$msgid'");
		return $reply_num['replynum'];
	}
	
	/**
	 * 删除短消息方法
	 *
	 * @param ARRAY INT $msgid
	 * @return true
	 */
	function delete_message($arrmsgid, $userid)
	{
		$userid = intval($userid);
		if(($userid < 1))
		{
			$this->msg = 'valide_input';
			return false;
		}
		if(is_array($arrmsgid))
		{
			foreach($arrmsgid as $msgid)
			{
				$folder = $this->db->get_one("SELECT folder FROM $this->table WHERE messageid='$msgid' AND (send_from_id='$userid' OR send_to_id='$userid')");
				if(!$folder) return false;
				if($folder['folder'] == 'all')
				{
					$arr_message = array('folder'=>'outbox', 'status'=>2);
					$this->db->update($this->table, $arr_message, "messageid='$msgid'");
				}
				else
				{
					$sql = "DELETE FROM $this->table WHERE messageid='$msgid'";
					$this->db->query($sql);
					$this->db->query("DELETE FROM $this->table WHERE replyid='$msgid'");
				}
			}
		}
		else
		{
			$msgid = intval($arrmsgid);
			if($msgid < 1) return false;
			$folder = $this->db->get_one("SELECT folder FROM $this->table WHERE messageid='$msgid' AND (send_from_id='$userid' OR send_to_id='$userid')");
			if(!$folder) return false;
			if($folder['folder'] == 'all')
			{
				$arr_message = array('folder'=>'outbox', 'status'=>2);
				$this->db->update($this->table, $arr_message, "messageid='$msgid'");
			}
			else
			{
				$sql = "DELETE FROM $this->table WHERE messageid='$msgid'";
				$this->db->query($sql);
				$this->db->query("DELETE FROM $this->table WHERE replyid='$msgid'");
			}
		}
		
		return true;
	}
	
	/**
	 * 删除短消息方法
	 *
	 * @param ARRAY INT $msgid
	 * @return true
	 */
	function delete_send_message($arrmsgid, $userid)
	{
		$userid = intval($userid);
		if(($userid < 1))
		{
			$this->msg = 'valide_input';
			return false;
		}
		if(is_array($arrmsgid))
		{
			foreach($arrmsgid as $msgid)
			{
				$folder = $this->db->get_one("SELECT folder FROM $this->table WHERE messageid='$msgid' AND (send_from_id='$userid' OR send_to_id='$userid')");
				if(!$folder) return false;
				if($folder['folder'] == 'all')
				{
					$arr_message = array('folder'=>'inbox', 'status'=>1);
					$this->db->update($this->table, $arr_message, "messageid='$msgid'");
				}
				else
				{
					$sql = "DELETE FROM $this->table WHERE messageid='$msgid'";
					$this->db->query($sql);
					$this->db->query("DELETE FROM $this->table WHERE replyid='$msgid'");
				}
			}
			
		}
		else
		{
			$msgid = intval($arrmsgid);
			if($msgid < 1) return false;
			$folder = $this->db->get_one("SELECT folder FROM $this->table WHERE messageid='$msgid' AND (send_from_id='$userid' OR send_to_id='$userid')");
			if(!$folder) return false;
			if($folder['folder'] == 'all')
			{
				$arr_message = array('folder'=>'inbox', 'status'=>1);
				$this->db->update($this->table, $arr_message, "messageid='$msgid'");
			}
			else
			{
				$sql = "DELETE FROM $this->table WHERE messageid='$msgid'";
				$this->db->query($sql);
				$this->db->query("DELETE FROM $this->table WHERE replyid='$msgid'");
			}
		}
		return true;
	}

	/**
	 * 获得用户的短信信息
	 *
	 * @param INT $msgid
	 * @param STRING $where
	 * @return $array
	 */
	function _get($msgid, $where = '')
	{
		global $member;
		$msgid = intval($msgid);
		if ($msgid <1) return false;
		if(!empty($where)) $where = "AND $where";
		$result = $this->db->get_one("SELECT * FROM $this->table WHERE messageid=$msgid $where");
		$result['num_reply'] = $this->_count_reply($result['messageid']);
		if(isset($result['send_from_id']))
		{
			$msgfromname = $member->get($result['send_from_id'], 'username'); 
			$result['msgfromname'] = $msgfromname['username'];
		}
		if(isset($result['message_time']))
		{
			$result['date'] = date('Y-m-d H:i', $result['message_time']);
		}
		return $result;
	}
	
	/**
	 * 列出短消息的信息
	 *
	 * @param STRING $where
	 * @param STRING $order
	 * @param INT $page
	 * @param INT $pagesize
	 * @return unknown
	 */
	function _listinfo($where = '', $order = '', $page = 1, $pagesize = 100)
	{
		global $member, $MODULE;
		$limit = '';
		$result = $array = array();
		if($where) $where = ' WHERE'.$where;
		if($order) $order = "ORDER BY $order";
		$page = max(intval($page), 1);
		$offset = $pagesize*($page-1);
		$limit = " LIMIT $offset, $pagesize";
		$result = $this->db->query("SELECT * FROM $this->table $where $order $limit");
		while ($r = $this->db->fetch_array($result))
		{
			$r['num_reply'] = $this->_count_reply($r['messageid']);
			if(isset($r['send_from_id']))
			{
				$msgfromname = $member->get($r['send_from_id'], 'username');
				$r['msgfromname'] = $msgfromname['username'];
				$r['avatar'] = avatar($r['send_from_id']);
			}
			if(isset($r['message_time']))
			{
				$r['date'] = date('Y-m-d H:i', $r['message_time']);
			}
			$array[] = $r;	
		}
		
		$this->db->free_result($result);
		unset($r);
		return $array;
	}
	
	function msg()
	{
		global $LANG;
		return $LANG[$this->msg];
	}
}
?>