<?php
class comment {
	var $db = '';
	var $_comment_table = '';
	function comment()
    {
		global $db;
		$this->db = $db;
		$this->_comment_table = DB_PRE.'comment';
		$this->count_table = DB_PRE.'content_count';
	}

	/**
	 *
	 *	@params
	 *	@return
	 */
	 function get_list($keyid, $page = 1, $pagesize)
     {
        global $MODULE;
		$keyid = trim($keyid);
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
		$comments = array();
        $count = cache_count("SELECT COUNT(*) AS `count` FROM `$this->_comment_table` WHERE `keyid`='{$keyid}' AND `status`='1'");
		$comments['pages'] = pages($count, $page, $pagesize);
		$ip_area = load('ip_area.class.php');
		$result = $this->db->query("SELECT `commentid`,`username`,`support`,`against`,`ip`,`addtime`,`status`,`content`, `userid` FROM `$this->_comment_table` WHERE `keyid` = '{$keyid}' AND `status` = '1' ORDER BY `addtime` DESC limit $offset,$pagesize");
		while($r = $this->db->fetch_array($result))
        {
			$r['content'] = str_replace( '[quote]', '<div class="reply">', $r['content']);
			$r['content'] = str_replace( '[blue]', '<div href="#" class ="blue"><p>', $r['content']);
			$r['content'] = str_replace( '[/quote]', '</div>', $r['content']);
			$r['content'] = str_replace( '[/blue]', '</p></div>', $r['content']);
			$r['addtime'] = date('Y-m-d H:i:s',$r['addtime']);
            list($r['ip_area'], ) = explode(' ', $ip_area->get($r['ip']));
            $r['ip_area'] = $r['ip_area'].'网友';
			$r['ip'] = preg_replace("/^([0-9]{1,3}\.[0-9]{1,3})\.[0-9]{1,3}\.[0-9]{1,3}$/", "\\1.*.*", $r['ip']);
            $userid = $r['userid'];
            if(!$r['userid'])
            {
                $r['url'] = '：'.$r['username'];
            }
            else
            {
                $r['url'] = '：'.'<a href='.$MODULE['member']['url'].'view.php?userid='.$r['userid'].'>'.$r['username'].'</a>';
            }
            $comments['info'][] = $r;
		}

		return $comments;
	 }

	 /**
	  *
	  *	@params
	  *	@return
	  */
	  function ajaxupdate( $field, $id )
      {

          $sql = "UPDATE $this->_comment_table SET {$field} = {$field} +1 WHERE `commentid` = '$id' ";
		  $this->db->query($sql);
		  $sql2 = "SELECT {$field} FROM $this->_comment_table WHERE `commentid` = '$id' ";
		  return $this->db->get_one($sql2);
	  }

	  function ajaxpost()
      {
           global $_userid, $_username ;
            $contentid = $contentid;
            $module = $module;
            $userid = trim($_userid);
            $username = trim($_username);
            $content = new_htmlspecialchars($content);
            $ip = IP;
            $addtime = TIME;
            $status = '1';
            $sql = "INSERT INTO `$this->_comment_table` (`contentid`, `module`, `userid` , `username`, `content`, `ip`, `addtime`, `status`) VALUES ('$contentid', '$module', '$userid' , '$username', '$content', '$ip', '$addtime', '$status')";

            $sql2 = "SELECT `commentid`, `username`, `support`, `against`, `ip`, `addtime`, `status`, `content` FROM `$this->_comment_table` WHERE `contentid` = '1' AND `status` = '1' ORDER BY `addtime` DESC";
            $result = $this->db->query($sql2);
            $comments = array();
            $ip_area = load('ip_area.class.php');
            $txt = '';
            while($r = $this->db->fetch_array($result))
            {
                $r['content'] = preg_replace_callback("/\[smile_[0-9]{1,3}\]/", 'smilecallback', $r['content']);
                $r['content'] = str_replace( '[quote]', '<div class="reply">', $r['content']);
                $r['content'] = str_replace( '[blue]', '<a href="#" class ="blue">', $r['content']);
                $r['content'] = str_replace( '[/quote]', '</div>', $r['content']);
                $r['content'] = str_replace( '[/blue]', '</a>', $r['content']);

                $r['addtime'] = date('Y-m-d H-m-s',$r['addtime']);
                $r['ip_area'] =  $ip_area->get($r['ip']);

                $txt .= "<div >\n";
                $txt .= $r['content'];
                $txt .= "</div>\n";
            }
            return $txt;
	  }

	  function addpost($content, $keyid)
	  {
		  global $_userid, $_username ;
		  $addtime = TIME;
		  if(empty($_username)) $username = '游客'; else $username = $_username;
		  $ip = IP;
		  $setting = cache_read('module_comment.php');
		  if($setting['ischeckcomment'])
		  {
			  $status = '0';
		  }
		  else
		  {
			  $status = '1';
		  }
		  if($this->updatecounter($keyid, $status))
          {
			  $sql = "INSERT INTO $this->_comment_table (`keyid`, `userid` , `username`,`content`,`ip`,`addtime`,`status`) VALUES ('$keyid', '$_userid' , '$username','$content','$ip','$addtime','$status')";
			  return $this->db->query($sql);
		  }
	  }
	  /**
	   *	回复网友的帖子
	   *	@params
	   *	@return
	   */

	  function add($commentid,$content, $keyid)
      {
		  global $_username, $_userid;
		  $commentid = trim($commentid);
		  $content = new_htmlspecialchars($content);
		  if (empty($_username)) $data['username'] = '游客'; else $data['username'] = $_username;
		  $r = $this->db->get_one("SELECT `content`,`username` FROM $this->_comment_table WHERE `commentid` = '$commentid' ");  //增加读取被引用帖子的发表用户名
		  $data['content'] = '[quote][blue]引用网友'.'('.$r['username'].')'.'的帖子[/blue]'.$r['content'].'[/quote]'.$content;  //原来的$data['username']该为$r['username']
		  $data['userid'] = $_userid;
		  $data['ip'] = IP;
		  $data['addtime'] = TIME;
		  $data['keyid'] = $keyid;
		  $setting = cache_read('module_comment.php');
		  if($setting['ischeckcomment'])
		  {
			  $data['status'] = '0';
		  }
		  else
		  {
			  $data['status'] = '1';
		  }
		  if($this->updatecounter($keyid, $status))
		  {
			return $this->db->insert($this->_comment_table, $data);
		  }
	  } 
	  //  0 不需要
	  function updatecounter($keyid, $mark=1)
	  {
		  list($module, $tablename, $titlefield, $contentid) = explode('-', $keyid);
		  if('special' != $module)
          {
              if ($mark)
              {
                  if ($this->db->query("UPDATE `$this->count_table` SET `comments` = comments + '1' WHERE `contentid` = '$contentid'"))
                  {
                      return $this->db->query("UPDATE `$this->count_table` SET `comments_checked` = comments_checked + '1' WHERE `contentid` = '$contentid'");
                  }
              }
              else
              {
                  return $this->db->query("UPDATE `$this->count_table` SET `comments` = comments + '1' WHERE `contentid` = '$contentid'");
              }
          }
          return true;
	  }
}
?>