<?php 
class block
{
	var $db;
	var $table;
	var $pages;
	var $log;
	var $priv_role;

    function __construct()
    {
		global $db, $log, $priv_role;
		$this->db = &$db;
		$this->table = DB_PRE.'block';
		$this->log = $log;
		$this->priv_role = $priv_role;
		require_once 'template.func.php';
    }

	function block()
	{
		$this->__construct();
	}

	function get($blockid, $fields = '*')
	{
		$blockid = intval($blockid);
		$r = $this->db->get_one("SELECT $fields FROM `$this->table` WHERE `blockid`=$blockid");
		if(!$r) return false;
		if($r['isarray']) $r['data'] = $r['data'] ? string2array($r['data']) : array();
		return $r;
	}

	function add($info, $roleids = array())
	{
		if($info['name'] == '') return false;
        $info['blockno'] = intval($info['blockno']);
        $info['isarray'] = intval($info['isarray']);
		$this->db->insert($this->table, $info);
		$blockid = $this->db->insert_id();
		$listorder = $this->get_max_listorder($info['pageid'], $info['blockno']);
        $this->db->query("UPDATE `$this->table` SET `listorder`=$listorder WHERE `blockid`=$blockid");
		$this->priv_role->update('blockid', $blockid, $roleids);
		if($info['isarray']) $this->set_template($blockid, ' ');
		$this->log->set('blockid', $blockid);
		$this->log->add($info);
		return $blockid;
	}

	function edit($blockid, $info, $roleids = array())
	{
		if($info['name'] == '') return false;
        $info['isarray'] = intval($info['isarray']);
		$this->db->update($this->table, $info, "`blockid`='$blockid'");
		$this->priv_role->update('blockid', $blockid, $roleids);
		$this->log->set('blockid', $blockid);
		$this->log->add($info);
        return true;
	}

	function update($blockid, $data)
	{
		if(is_array($data))
		{
			$data = $this->strip_data($data);
			if($data) $data = array2string($data);
		}
		$this->db->query("UPDATE `$this->table` SET `data`='$data' WHERE `blockid`='$blockid'");
		$this->log->set('blockid', $blockid);
		$this->log->add(array('data'=>$data));
		$this->set_html($blockid);
		return true;
	}

	function listinfo($where, $page = 1, $pagesize = 20)
	{
		if($where) $where = " WHERE $where";
		$page = max(intval($page), 1);
        $offset = $pagesize*($page-1);
        $limit = " LIMIT $offset, $pagesize";
		$r = $this->db->get_one("SELECT count(*) as `count` FROM `$this->table` $where");
        $number = $r['count'];
        $this->pages = pages($number, $page, $pagesize);
		$array = array();
		$result = $this->db->query("SELECT * FROM `$this->table` $where ORDER BY `blockid` DESC $limit");
		while($r = $this->db->fetch_array($result))
		{
			if($r['isarray'] && $r['data']) $r['data'] = string2array($r['data']);
			$array[] = $r;
		}
        $this->db->free_result($result);
		return $array;
	}

	function disable($blockid, $disabled)
	{
		$blockid = intval($blockid);
		$r = $this->get($blockid);
		if(!$r) return false;
		$this->db->query("UPDATE $this->table SET `disabled`=$disabled WHERE `blockid`=$blockid");
		$this->set_html_blockno($r['pageid'], $r['blockno']);
		return true;
	}

	function delete($blockid)
	{
		if(is_array($blockid))
		{
			array_map(array(&$this, 'delete'), $blockid);
		}
		else
		{
			$r = $this->get($blockid);
			if(!$r) return false;
			$this->db->query("DELETE FROM `$this->table` WHERE `blockid`='$blockid'");
			$this->rm_html($blockid);
			$this->set_html_blockno($r['pageid'], $r['blockno']);
		    $this->priv_role->delete('blockid', $blockid);
			$this->log->set('blockid', $blockid);
			$this->log->add();
		}
		return true;
	}

	function clear()
	{
		return $this->db->query("TRUNCATE TABLE `$this->table`");
	}

	function listorder($info)
	{
		if(!is_array($info)) return false;
		foreach($info as $id=>$listorder)
		{
			$listorder = intval($listorder);
			$id = intval($id);
			$r = $this->get($id);
			if(!$r) continue;
			$this->db->query("UPDATE $this->table SET `listorder`=$listorder WHERE `blockid`=$id");
			$this->set_html_blockno($r['pageid'], $r['blockno']);
		}
		return true;
	}

	function logs($blockid)
	{
		$this->log->set('blockid', $blockid);
		return $this->log->listinfo('', 0, 100);
	}

	function restore($logid)
	{
		$r = $this->log->get($logid);
		$data = $r['data'];
	    $data = $data['data'];
		if(substr($data, 0, 5) == 'array')
	    {
			$data = string2array($data);
			$data = str_charset(CHARSET, 'utf-8', $data);
			$data = json_encode($data);
		}
        return $data;
	}

	function strip_data($data)
	{
		ksort($data);
		$array = array();
		foreach($data as $k=>$v)
		{
			if($v['title'] && $v['url']) $array[] = $v;
		}
		return $array;
	}

	function get_max_listorder($pageid, $blockno)
	{
		$r = $this->db->get_one("SELECT max(listorder) AS `listorder` FROM `$this->table` WHERE `pageid`='$pageid' AND `blockno`='$blockno'");
		return $r ? $r['listorder']+1 : 0;
	}

	function refresh($pageid = '', $blockno = 0)
	{
		$where = '';
		if($pageid)	$where .= " AND `pageid`='$pageid' ";
		if($blockno) $where .= " AND `blockno`='$blockno' ";
		$arr = array();
		$array = $this->db->select("SELECT * FROM `$this->table` WHERE `disabled`=0 $where ORDER BY `listorder`", 'blockid');
		foreach($array as $blockid=>$r)
		{
			extract($r);
			ob_start();
			if($isarray)
			{
				$data = $data ? string2array($data) : array();
				include template_block($blockid);
			}
			else
			{
				echo $data;
			}
			createhtml(PHPCMS_ROOT.'data/block/'.$blockid.'.html');
			$arr[$pageid.$blockno] = array($pageid, $blockno);
		}
		foreach($arr as $k=>$r)
		{
			$this->set_html_blockno($r[0], $r[1]);
		}
		return true;
	}

	function set_html($blockid)
	{
		$r = $this->get($blockid);
		if(!$r) return false;
		extract($r);
		ob_start();
		if($isarray)
		{
			include template_block($blockid);
		}
		else
		{
			echo $data;
		}
		$result = createhtml(PHPCMS_ROOT.'data/block/'.$blockid.'.html');
		if($result !== false) $this->set_html_blockno($pageid, $blockno);
		return $result;
	}

	function get_html($blockid)
	{
		$blockid = intval($blockid);
		return @file_get_contents(PHPCMS_ROOT.'data/block/'.$blockid.'.html');
	}

	function rm_html($blockid)
	{
		return @unlink(PHPCMS_ROOT.'data/block/'.$blockid.'.html');
	}

	function set_html_blockno($pageid, $blockno)
	{
		$data = '';
		$array = $this->db->select("SELECT `blockid` FROM `$this->table` WHERE `pageid`='$pageid' AND `blockno`='$blockno' AND `disabled`=0 ORDER BY `listorder`", 'blockid');
		foreach($array as $blockid=>$v)
		{
			$data .= $this->get_html($blockid);
		}
		$file = PHPCMS_ROOT.'data/block/'.$pageid.'_'.$blockno.'.html';
		if($data) file_put_contents($file, $data);
		elseif(file_exists($file)) @unlink($file);
		return true;
	}

	function get_html_blockno($pageid, $blockno)
	{
		return @file_put_contents(PHPCMS_ROOT.'data/block/'.$pageid.'_'.$blockno.'.html');
	}

	function get_template_path($blockid)
	{
		return TPL_ROOT.TPL_NAME.'/phpcms/block/'.$blockid.'.html';
	}

	function get_template($blockid)
	{
		$tplfile = $this->get_template_path($blockid);
		return file_exists($tplfile) ? trim(file_get_contents($tplfile)) : '';
	}

	function set_template($blockid, $template)
	{
		$tplfile = $this->get_template_path($blockid);
		return @file_put_contents($tplfile, stripslashes($template));
	}

	function get_template_example($example = '')
	{
		$path = TPL_ROOT.TPL_NAME.'/phpcms/block/example/';
		if(!is_dir($path)) return array();
		if($example)
		{
			$data = @file_get_contents($path.$example.'.html');
		}
		else
		{
			$names = @include $path.'name.inc.php';
			$data = array(''=>'选择示例');
			$files = glob($path.'*.html');
			foreach($files as $k=>$v)
			{
				$tpl = basename($v);
				$k = substr($tpl,0, -5);
				$data[$k] = isset($names[$tpl]) ? $names[$tpl] : $tpl;
			}
		}
		return $data;
	}
}
?>