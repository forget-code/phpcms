<?php 
class priv_role
{
	var $db;
	var $table;
	var $roleids;

	function priv_role()
	{
		global $db, $_roleid;
		$this->db = &$db;
		$this->table = DB_PRE.'admin_role_priv';
		$this->roleids = implode(',', $_roleid);
		$this->issuperadmin = in_array(1, $_roleid);
		$this->ischiefeditor = in_array(2, $_roleid);
		$this->isdesigner = in_array(4, $_roleid);
	}

    function add($field, $value, $priv, $roleid)
    {
		$roleid = intval($roleid);
		return $this->db->query("INSERT INTO `$this->table`(`roleid`,`field`,`value`,`priv`) VALUES('$roleid', '$field', '$value', '$priv')");
    }

	function delete($field, $value, $priv = '', $roleid = 0)
	{
		$where = '';
		if($roleid) $where .= "AND `roleid`='$roleid' ";
		if($field) $where .= "AND `field`='$field' ";
		if($value) $where .= "AND `value`='$value' ";
		if($priv) $where .= "AND `priv`='$priv' ";
		if($where)
		{
            $where = substr($where, 3);
			return $this->db->query("DELETE FROM `$this->table` WHERE $where");
		}
		return false;
	}

	function update($field, $value, $priv_role)
	{
		if(!$field || !$value) return false;
		$this->delete($field, $value);
		if(!is_array($priv_role)) return true;
		foreach($priv_role as $priv_roleid)
		{
            if(is_numeric($priv_roleid))
			{
				$priv = '';
				$roleid = $priv_roleid;
			}
			else
			{
				list($priv, $roleid) = explode(',', $priv_roleid);
			}
			$this->add($field, $value, $priv, $roleid);
		}
		return true;
	}

	function module()
	{
		global $mod, $file, $action, $MODULE, $catid;
		if($this->issuperadmin || ($this->ischiefeditor && (in_array($file,array('content','category','block','position','html','url','content_all')) || $mod == 'special')) || ($this->isdesigner && ($file == 'template' || $file == 'tag'))) return true;
		$privs = cache_read('priv.inc.php', PHPCMS_ROOT.$MODULE[$mod]['path'].'include/');
		if(!$privs) return true;
		if($this->check('module', $mod, 'all')) return true;
		if($catid && $this->check('catid', $catid, $action)) return true;

		$publish_files = cache_read('publish_priv.inc.php', PHPCMS_ROOT.'include/');	
		if(in_array($file,array_keys($publish_files)) && ($publish_files[$file]=='' || in_array($action,$publish_files[$file]))) return true;

		$actions = array();
        foreach($privs as $priv=>$v)
        {
			if(in_array($file, explode(',', $v['file'])) && (!$v['action'] || in_array($action, explode(',', $v['action'])))) $actions[] = $priv;
        }
	
		return $actions && $this->check('module', $mod, $actions);
	}

	function check($field, $value, $priv = '', $roleid = 0)
	{
		if($roleid == 0 && ($this->issuperadmin || $this->ischiefeditor && in_array($field, array('catid', 'specialid', 'blockid')))) return true;
		$roleids = $roleid ? intval($roleid) : $this->roleids;
		$where = " `field`='$field' AND `value`='$value' AND `roleid` IN($roleids)";
		if($priv) $where .= is_array($priv) ? " AND `priv` IN('".implode("','", $priv)."') " : " AND `priv`='$priv' ";
		return $this->db->get_one("SELECT `roleid` FROM `$this->table` WHERE $where LIMIT 1");
	}

	function get_roleid($field, $value, $priv = '')
	{
		$roleids = array();
		$array = $this->db->select("SELECT `roleid` FROM `$this->table` WHERE `field`='$field' AND `value`='$value' AND `priv`='$priv'", 'roleid');
		foreach($array as $k=>$v)
		{
			$roleids[$k] = $v['roleid'];
		}
		return $roleids;
	}
}
?>