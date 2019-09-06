<?php
class mood
{
	var $db;
	var $table;

    function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'mood';
		register_shutdown_function(array(&$this, 'cache'));
    }

	function mood()
	{
		$this->__construct();
	}

	function add($name, $m = '', $p = '')
	{
		if(!is_array($m)) return false;
		$info['name'] = $name;
		$line = 0;
		foreach($m AS $k=>$v)
		{
			if(trim($v)=='') continue;
			$fname = 'm'.($k+1);
			$info[$fname] = $v.'|'.$p[$k];
			$line++;
		}
		$info['number'] = $line;
		return $this->db->insert($this->table, $info);
	}

	function show($id)
	{
		$id = intval($id);
		return $this->db->get_one("SELECT * FROM $this->table WHERE moodid=$id");
	}

	function edit($id, $name, $m = '', $p = '')
	{
		$id = intval($id);
		$info['name'] = $name;
		$line = 0;
		foreach($m AS $k=>$v)
		{
			$fname = 'm'.($k+1);
			$info[$fname] = $v.'|'.$p[$k];
			if(trim($v)=='')
			{
				$info[$fname] = '';
			}
			else
			{
				$line++;
			}
		}
		$info['number'] = $line;
		return $this->db->update($this->table, $info, "moodid=$id");
	}

	function delete($id)
	{
		$id = intval($id);
		if($id < 1) return false;
		$this->db->query("DELETE FROM `$this->table` WHERE `moodid` = $id ");
		return true;
	}

	function listinfo()
	{
		$array = array();
		$result = $this->db->query("SELECT * FROM $this->table ORDER BY moodid DESC");
		while($r = $this->db->fetch_array($result))
		{
			$array[] = $r;
		}
        $this->db->free_result($result);
		return $array;
	}

	function cache()
	{
		global $PHPCMS,$M;
		$result = $this->db->query("SELECT * FROM $this->table");
		while($r = $this->db->fetch_array($result))
		{
			$cache = $infos = array();
			for($i=1;$i<=$r['number'];$i++)
			{
				$field = 'm'.$i;
				$m = explode('|',$r[$field]);
				$cache[$i] = $infos[$i]['title'] = trim($m[0]);
				$infos[$i]['id'] = $i;
				$infos[$i]['img'] = trim($m[1]);
			}

			$string = "var votehtml = '";
			ob_start();
			include template('mood','show');
			$data = ob_get_contents();
			ob_clean();
			$string .=  format_js($data,0);
			$string .=  "';";
			$string .=  "document.getElementById(\"moodrank_div\").innerHTML = votehtml;";
			$string .=  "function vote(vote_id) {document.getElementById(\"moodrank_div\").innerHTML = \"处理中...\";document.getElementById(\"callback_js\").src = \"".SITE_URL."mood/callback.php?moodid=$r[moodid]&contentid=\" + contentid+\"&vote_id=\"+vote_id;}";
			cache_write('mood'.$r['moodid'].'.php',$cache);
			$cachefile = PHPCMS_ROOT.'data/moodrank/'.$r['moodid'].'.js';
			$strlen = file_put_contents($cachefile, $string);
			@chmod($cachefile, 0777);
		}
		$this->db->free_result($result);
		return true;
	}
}
?>