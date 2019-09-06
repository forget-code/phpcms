<?php 
class search
{
	var $db;
	var $table;
	var $type;
	var $types;
	var $segment;
	var $datadir;
	var $total;
	var $titlelen;
	var $descriptionlen;
	var $ft_min_word_len;
	var $color;

    function __construct($type = 0)
    {
		global $db,$MODULE;
		$this->db = &$db;
		$this->table = DB_PRE.'search';
		$this->mod_root = PHPCMS_ROOT.$MODULE['search']['path'];
		$this->datadir = $this->mod_root.'data/';
		$this->types = cache_read('search_type.php');
		$this->ft_min_word_len = $this->ft_min_word_len();
		$this->set();
    }

	function search($type = 0)
	{
		$this->__construct($type);
	}

	function set($titlelen = 80, $descriptionlen = 500, $color = 'red')
	{
		$this->titlelen = max(intval($titlelen), 10);
		$this->descriptionlen = max(intval($descriptionlen), 50);
		$this->color = $color;
	}

	function set_type($type)
	{
		$this->type = preg_match("/[0-9a-z_-]/", $type) ? $type : '';
	}

	function get_type()
	{
		return $this->types;
	}

	function add($title, $content, $url)
	{
		$data = $this->segment($title.$content);
		$data = $title.' '.$data;
		$data = $this->db->escape($data);
		$this->db->query("INSERT INTO `$this->table`(`type`, `data`) VALUES('$this->type', '$data')");
		$searchid = $this->db->insert_id();
        $this->set_data($searchid, array('title'=>$title, 'content'=>$content, 'url'=>$url));
		return $searchid;
	}

	function update($searchid, $title, $content, $url)
	{
		$data = $this->segment($title.$content);
		$data = $title.' '.$data;
		$data = $this->db->escape($data);
		$this->db->query("UPDATE `$this->table` SET `type`='$this->type',`data`='$data' WHERE `searchid`='$searchid'");
		//if($this->db->affected_rows() == 0) return false;
		$this->set_data($searchid, array('title'=>$title, 'content'=>$content, 'url'=>$url));
		return true;
	}

	function delete($id, $field = 'searchid')
	{
		$id = intval($id);
        if($field == 'searchid')
		{
			$this->db->query("DELETE FROM `$this->table` WHERE `searchid`=$id");
			if($this->db->affected_rows() == 0) return false;
			$this->set_data($id);
		}
		elseif($field == 'type')
		{
			@set_time_limit(600);
            dir_delete($this->datadir.$this->type.'/');
			$this->db->query("DELETE FROM `$this->table` WHERE `type`='$id'");
		}
		return true;
	}

	function q($q, $order = 0, $page = 1, $pasesize = 10, $is_red = 1)
	{
		global $M;
		$page = max(intval($page), 1);
		$offset = $pasesize*($page-1);
		if(!$M['fulltextenble'])
		{
			$q = str_replace(' ', '%', $q);
			$where = " `data` LIKE '%$q%' ";
		}
		else
		{
			if(preg_match("/[+-<>()~*]/", $q))
			{
				$where = " MATCH(`data`) AGAINST('$q' IN BOOLEAN MODE) ";
			}
			else
			{
				$tag = '\''.$q.'\'';
				if(strlen($q) > 4) $q = $this->segment($q);
				foreach(explode(' ', $q) as $a)
				{
					$tag .= ',\''.$a.'\'';
				}
				$this->db->query("UPDATE `".DB_PRE."keyword` SET `hits`=`hits`+1 WHERE `tag` IN ($tag)");
				$where = " MATCH(`data`) AGAINST('$q') ";
			}
		}
		if($this->type && isset($this->types[$this->type])) $where .= " AND `type`='$this->type'";
		$this->total = cache_count("SELECT COUNT(*) AS `count` FROM `$this->table` WHERE $where");
		if($this->total == 0) return array();
		$this->pages = pages($this->total, $page, $pasesize);
		$orderby = $order ? " ORDER BY `searchid` DESC " : '';
		$array = array();
		$result = $this->db->query("SELECT `searchid`,`type` FROM `$this->table` WHERE $where $orderby LIMIT $offset, $pasesize");
		while($r = $this->db->fetch_array($result))
		{
			$this->type = $r['type'];
			$data = $this->get_data($r['searchid']);
			$data['date'] = date('Y-m-d', $data['time']);
			$data['title'] = strip_tags($data['title']);
			$data['url'] = url($data['url'], 1);
			$data['content'] = strip_tags($data['content']);
			if($is_red)
			{
				$data['title'] = $this->red($data['title'], $q, $this->color, $this->titlelen);
				$data['content'] = $this->red($data['content'], $q, $this->color, $this->descriptionlen);
			}
			$data['searchid'] = $r['searchid'];
			$data['type'] = $r['type'];
			$array[] = $data;
		}
        $this->db->free_result($result);
		return $array;
	}

	function strip($q)
	{
		return str_replace(array('\\', '"', "'"), '', trim($q));
	}

	function red($string, $words, $color = 'red', $strlen = 0)
	{
		if($string == '' || $words == '') return '';
		$position = $search = $replace = array();
		if(!is_array($words)) $words = explode(' ', $words);
		foreach($words as $k=>$word)
		{
			if(!$word || strpos($string, $word) === false) continue;
			$search[$k] = $word;
			$replace[$k] = '<font color="'.$color.'">'.$word.'</font>';
			if($k == 2) break;
		}
		if($strlen) $string = str_cut($string, $strlen);
		return str_replace($search, $replace, $string);
	}

	function segment($content)
	{
		global $PHPCMS;
		if(!is_object($this->segment)) $this->segment = load($PHPCMS['segmentclass'].'.class.php');
		$this->segment->set_text($content);
		return $this->segment->get_words();
	}

	function set_data($searchid, $data = array())
	{
		$dir = $this->datadir.$this->type.'/'.substr($searchid, 0, 3).'/';
		if($data)
		{
			dir_create($dir);
			$data['time'] = TIME;
			return cache_write($searchid.'.php', $data, $dir);
		}
		else
		{
			return @unlink($dir.$searchid.'.php');
		}
	}

	function get_data($searchid)
	{
		$dir = $this->datadir.$this->type.'/'.substr($searchid, 0, 3).'/';
		return cache_read($searchid.'.php', $dir);
	}

	function create_index()
	{
		@set_time_limit(600);
		$this->db->query("ALTER TABLE `$this->table` DROP INDEX `data`");
		return $this->db->query("ALTER TABLE `$this->table` ADD FULLTEXT (`data`)");
	}

	function ft_min_word_len()
	{
		$r = $this->db->get_one("SHOW VARIABLES LIKE 'ft_min_word_len'");
		return $r ? $r['Value'] : 4;
	}
}
?>