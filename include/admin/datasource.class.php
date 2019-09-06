<?php 
class datasource
{
	var $db;
	var $table;

	function datasource()
	{
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'datasource';
        $dbclass = 'db_'.DB_DATABASE;
		$this->newdb = new $dbclass;
		$this->newdb->debug = 0;
	}

	function get($name, $fields = '*')
	{
		return $this->db->get_one("SELECT $fields FROM `$this->table` WHERE `name`='$name'");
	}

	function add($info)
	{
		if(!$this->checkname($info['name'])) return false;
		$info['status'] = $this->status($info);
		$this->db->insert($this->table, $info);
		$this->cache($info['name']);
		return true;
	}

	function edit($name, $info)
	{
		unset($info['name']);
		$info['status'] = $this->status($info);
		$this->db->update($this->table, $info, "`name`='$name'");
		$this->cache($name);
		return true;
	}

	function delete($name)
	{
		$this->db->query("DELETE FROM `$this->table` WHERE `name`='$name'");
		cache_delete('db_'.$name.'.php');
		return true;
	}

	function checkname($name)
	{
		if(!preg_match("/^[0-9a-z_\-]+$/i", $name)) return false;
		return $this->db->get_one("SELECT `name` FROM `$this->table` WHERE `name`='$name'") ? false : true;
	}

	function link($name)
	{
		$s = cache_read('db_'.$name.'.php', '', 1);
		return $this->newdb->connect($s['dbhost'], $s['dbuser'], $s['dbpw']);
	}

	function test($dbhost, $dbuser, $dbpw, $dbname, $dbcharset = 'gbk')
	{
		if(!$this->newdb->connect($dbhost, $dbuser, $dbpw)) return '2';
		if(!$this->newdb->select_db($dbname)) return '3';
		return '1';
	}

	function tables($dbhost, $dbuser, $dbpw, $dbname, $dbcharset)
	{
		if(!$this->newdb->connect($dbhost, $dbuser, $dbpw) || !$this->newdb->select_db($dbname)) return false;
		$result = $this->newdb->query("SHOW TABLES FROM `$dbname`");
		while($r = $this->newdb->fetch_array($result))
		{
			$r = array_values($r);
			$tables[$r[0]] = $r[0];
		}
		return $tables;
	}

	function fields($dbhost, $dbuser, $dbpw, $dbname, $dbcharset, $tablename)
	{
		if(!$this->newdb->connect($dbhost, $dbuser, $dbpw) || !$this->newdb->select_db($dbname)) return false;
		$fields = array();
		$result = $this->newdb->query("SHOW COLUMNS FROM `$tablename`");
		while($r = $this->newdb->fetch_array($result))
		{
			$field = $r['Field'];
			$fields[$field] = $field;
		}
		return $fields;
	}

	function status($info)
	{
		return ($info['dbhost'] == DB_HOST && $info['dbuser'] == DB_USER && $info['dbpw'] == DB_PW) ? 1 : 0;
	}

	function listinfo($where = '', $order = '')
	{
		if($where) $where = " WHERE $where";
		if($order) $order = " ORDER BY $order";
		return $this->db->select("SELECT * FROM `$this->table` $where $order");
	}

    function cache($name = '')
    {
		if($name)
		{
			$data = $this->get($name, 'dbhost, dbuser, dbpw, dbname, dbcharset, status');
			if($data) cache_write('db_'.$name.'.php', $data);
		}
		else
		{
			$data = $this->db->select("SELECT `name` FROM `$this->table` ORDER BY `name`");
			foreach($data as $r)
			{
				$this->cache($r['name']);
			}
		}
		return true;
    }
    
    function get_fields($dbhost, $dbuser, $dbpw, $dbname, $dbcharset, $tablename)
	{
		if(!$this->newdb->connect($dbhost, $dbuser, $dbpw) || !$this->newdb->select_db($dbname)) return false;
		$fields = array();
		$result = $this->newdb->query("SHOW COLUMNS FROM `$tablename`");
		while($r = $this->newdb->fetch_array($result))
		{
			$fields[] = $this->format_fields($r);
		}
		return $fields;
	}
    
    function format_fields($data)
    {
    	$str['field'] = $data['Field'];
    	if(preg_match('/([A-Z]+)/i', $data['Type'],$m))
    	{
    		$str['type'] = $m[1];
    	}
    	if(preg_match('/(\d+)/i', $data['Type'],$m))
    	{
    		$str['num'] = $m[1];
    	}
    	return $str;
    }
}
?>