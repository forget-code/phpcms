<?php 
class session
{
	var $lifetime = 1800;
	var $db;
	var $table;

    function session()
    {
		global $db;
	    $this->lifetime = SESSION_TTL;
		$this->db = &$db;
		$this->table = '`'.DB_NAME.'`.`'.DB_PRE.'session`';
    	session_set_save_handler(array(&$this,'open'), array(&$this,'close'), array(&$this,'read'), array(&$this,'write'), array(&$this,'destroy'), array(&$this,'gc'));
    }

    function open($save_path, $session_name)
	{
		return true;
    }

    function close()
	{
        return $this->gc($this->lifetime);
    } 

    function read($id)
	{
		$r = $this->db->get_one("SELECT `data` FROM $this->table WHERE `sessionid`='$id'");
		return $r ? $r['data'] : '';
    } 

    function write($id, $data)
	{
		global $_userid, $_groupid, $mod, $catid, $contentid;
		if(strlen($data) > 255) $data = '';
		$catid = intval($catid);
		$contentid = intval($contentid);
		return $this->db->query("REPLACE INTO $this->table (`sessionid`, `userid`, `ip`, `lastvisit`, `groupid`, `module`, `catid`, `contentid`, `data`) VALUES('$id', '$_userid', '".IP."', '".TIME."', '$_groupid', '$mod', '$catid', '$contentid', '".addslashes($data)."')");
    } 

    function destroy($id)
	{
		return $this->db->query("DELETE FROM $this->table WHERE `sessionid`='$id'");
    } 

    function gc($maxlifetime)
	{
		$expiretime = TIME - $maxlifetime;
		return $this->db->query("DELETE FROM $this->table WHERE `lastvisit`<$expiretime"); 
    }
}
?>