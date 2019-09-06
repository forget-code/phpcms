<?php
class comment_api
{
    var $comment_table = '';
    var $count_table = '';
    var $db = '';
    var $error = '';

    function comment_api()
    {
        global $db;
        $this->comment_table = DB_PRE.'comment';
        $this->count_table = DB_PRE.'content_count';
        $this->db = $db;
    }

    function drop($commentid, $tablename, $titlefield, $moudle = "phpcms")//$commentid => array,string
    {
        if(empty($tablename) || empty($titlefield))
        {
            $this->error = 2;
            return FALSE;
        }
        $prefix = $module.'-'.$tablename.'-'.$titlefield.'-';
        $keyids = $this->get_keyids($commentid, $prefix);
        if(empty($keyids))
        {
            $this->error = 0;
            return FALSE;
        }
        $sql = "DELECT FROM `$this->comment_table` WHERE `keyid` '{$keyids}'";
        if($this->db->query($sql))
        {
            $countids = $this->get_keyids($commentid);
            if($this->dropCommentCount($countids))
            {
                return TRUE;
            }
        }
        else
        {
            $this->error = 1;
            return FALSE;
        }
    }
    function addComment($content, $keyid)
    {
         global $_userid, $_username ;
         $addtime = TIME;
         if(empty($_username)) $username = '游客'; else $username = $_username;
         $content = new_htmlspecialchars($comment);
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
        if($this->updateCounter($keyid, $status))
        {
          $sql = "INSERT INTO `$this->comment_table` (`keyid`, `userid` , `username`,`content`,`ip`,`addtime`,`status`) VALUE ('$keyid', '$_userid' , '$username','$content','$ip','$addtime','$status')";
          return $this->db->query($sql);
        }
    }
    //添加评论, $commentid->userid.
    function add($commentid, $tablename = '', $titlefield = '', $moudle = "phpcms")
    {
        $prefix = $moudle.'-'.$commentid;
    }
    //删除文章评论数
    function dropCommentCount($keyids)
    {
        $sql = "DELECT FROM `$this->count_table` WHERE `keyid` '{$keyids}'";
        return $this->db->query($sql);
    }
    //
    function updateCounter($keyid, $mark=1)
    {
      list($module, $tablename, $titlefield, $contentid) = explode('-', $keyid);
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

    function get_keyids($item_list, $prefix = "", $field_name = "")
	{
		if ( empty( $item_list ) )
		{
			return $field_name." IN ('') ";
		}
		else
		{
			if ( !is_array( $item_list ) )
			{
				$item_list = explode( ",", str_replace( "'", "", $item_list ) );
			}
			$item_list = array_unique( $item_list );
			$item_list_tmp = "";
			foreach ( $item_list as $item )
			{
				if ( $item !== "" )
				{
                    $item = $prefix.$item;
                    $item_list_tmp .= $item_list_tmp ? ",'{$item}'" : "'{$item}'";
				}
			}
			if ( empty( $item_list_tmp ) )
			{
				return $field_name." IN ('') ";
			}
			else
			{
				return $field_name." IN (".$item_list_tmp.") ";
			}
		}
    }

    function get_count($id)
    {
        $id = intval($id);
        $keyid = "special-special-title-".$id;
        $sql = "SELECT COUNT(*) AS num FROM `$this->comment_table` WHERE `keyid` = '$keyid'";
        $count = $this->db->get_one($sql);
        return $count['num'];
    }
    function error() {
		$ERRORMSG = array(
					0 => '没有要删除的评论或者参数错误',
					1 => '删除失败',
					2 => '缺少参数'
				);
		return $ERRORMSG[$this->error];
	}
}
?>