<?php 
class type
{
	var $db;
	var $table;

	function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'search_type';
    }

	function type()
	{
		$this->__construct();
	}

	function get($type, $fields = '*')
	{
		return $this->db->get_one("SELECT $fields FROM `$this->table` WHERE `type`='$type'");
	}

	function add($type, $name, $md5key, $description, $disabled = 0)
	{
		if($this->get($type) || empty($name)) return false;
		$this->db->query("INSERT INTO `$this->table`(`type`, `name`, `md5key`, `description`, `disabled`) VALUES('$type', '$name', '$md5key', '$description', '$disabled')");
		$this->cache();
		return true;
	}

	function edit($type, $name, $md5key, $description, $disabled = 0)
	{
		if(!$this->get($type) || empty($name)) return false;
		$result = $this->db->query("UPDATE `$this->table` SET `name`='$name', `md5key`='$md5key', `description`='$description', `disabled`='$disabled' WHERE `type`='$type'");
		$this->cache();
		return $result;
	}

	function delete($type)
	{
		$this->db->query("DELETE FROM `$this->table` WHERE `type`='$type'");
		$this->cache();
		return true;
	}

	function listinfo()
	{
		$array = array();
		$result = $this->db->query("SELECT * FROM `$this->table` ORDER BY `listorder`,`type`");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r;
		}
        $this->db->free_result($result);
		return $array;
	}

	function listorder($info)
	{
		if(!is_array($info)) return false;
		foreach($info as $type=>$listorder)
		{
			$listorder = intval($listorder);
			$this->db->query("UPDATE `$this->table` SET `listorder`=$listorder WHERE `type`='$type'");
		}
		return true;
	}

	function check($type)
	{
		if(!preg_match("/^[0-9a-z_]+$/i", $type))
		{
			$this->error = 'type_not_match';
			return false;
		}
		if($this->db->get_one("SELECT `type` FROM `$this->table` WHERE `type`='$type'"))
		{
			$this->error = 'type_exists';
			return false;
		}
		return true;
	}

	function cache()
	{
		$types = $apis = array();
		$result = $this->db->query("SELECT * FROM `$this->table` WHERE `disabled`=0 ORDER BY `listorder`,`type`");
		while($r = $this->db->fetch_array($result))
		{
			$types[$r['type']] = $r['name'];
			$apis[$r['type']] = $r['md5key'];
		}
        $this->db->free_result($result);
		cache_write('search_type.php', $types);
		cache_write('search_api.php', $apis);
		return true;
	}

	function errormsg()
	{
		$LANG['type_not_match'] = '类别必须是字母、数字和下划线组成';
		$LANG['type_exists'] = '类别已存在';
		return $LANG[$this->error];
	}
}
?>