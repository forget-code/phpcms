<?php
if(!defined('CACHE_IMPORT_PATH'))
{
	define('CACHE_IMPORT_PATH', PHPCMS_ROOT.'data/cache_import/');
}

class import
{
	var $msg;
	var $db;
	var $sameserver = 0;
	var $sqldb;
	var $remotedb;
    var $mail_datadir = '';
    var $counter = '';
	function __construct()
	{
		global $db;
		$this->db = &$db;
        $this->mail_datadir = PHPCMS_ROOT.'data/mail/data/';
        $this->counter = 0;
	}

	function import()
	{
		$this->__construct();
	}

	function connect_db($dbtype, $dbhost, $dbuser, $dbpw, $dbname = '', $charset = '')
	{
		global $db;
		$this->remotedb = $dbname;
		if('mysql' == $dbtype && $dbhost == DB_HOST && $dbuser == DB_USER && $dbpw == DB_PW && DB_CHARSET == $charset)
		{
			$this->sameserver = 1;
			if (!empty($dbname))
			{
				$this->sqldb = &$this->db;
				if ($dbname != DB_NAME)
				{
					$this->sqldb->select_db($dbname);
				}
				return $this->sqldb;
			}
			return $this->db;
		}
		else
		{
			$dbclass = 'db_'.$dbtype;			
			if(!class_exists($dbclass))
			{
				require $dbclass.'.class.php';
			}	
			$this->sqldb = new $dbclass;
			if(!$this->sqldb->connect($dbhost, $dbuser, $dbpw, $this->remotedb, 0, $charset))
			{
				return false;
			}
			if('mysql' == $dbtype && $dbhost == DB_HOST && $dbuser == DB_USER && $dbpw == DB_PW)
			{
				$this->sameserver = 1;
			}
		}
		return $this->sqldb;
	}

	function filter_fields($info, $offset, $keyid)
	{

		$result['table'] = trim($info['table']);
		$firstdot = strpos($result['table'], ',');
		if($firstdot)
		{
			$startpos = intval(strpos($result['table'], ' '));
			$firsttable = trim(substr($result['table'], $startpos, $firstdot-$startpos));
		}

		$result['maxid'] = intval($info['maxid']);
		$condition = str_replace('$maxid', $result['maxid'], $info['condition']);
        if($condition) $result['condition'] = " WHERE $condition";
		$number = $info['number'];
		if($number) $result['limit'] = " LIMIT $offset,$number";

		if($this->sameserver) $this->sqldb->select_db($this->remotedb);
		$r = $this->sqldb->get_one("SELECT count(*) AS total FROM $result[table] $result[condition]");
		$result['total'] = $r['total'];

		$result['orderby'] = $firsttable ? $firsttable.'.'.$keyid : $keyid;
		$result['selectfield'] = $info['selectfield'] ? $info['selectfield'] : '*';
		return $result;
	}

	function add_member($import_info, $offset)
	{
		global $member_api;
		$data = array();
		$keyid = $import_info['userid']['field'];
		if($import_info['defaultgroupid']) $import_info['defaultgroupid'] = intval($import_info['defaultgroupid']);
		$data['groupid'] = $import_info['defaultgroupid'];
		if(!$keyid)
		{
			$this->msg = 'the_keyid_not_exists';
			return false;
		}
		$number = $import_info['number'];
		$data['modelid'] = $import_info['modelid'];
		$this->connect_db($import_info['dbtype'], $import_info['dbhost'], $import_info['dbuser'], $import_info['dbpw'], $import_info['dbname'], $import_info['charset']);

		$fields = cache_read($import_info['modelid'].'_fields.inc.php', CACHE_MODEL_PATH);
		$memberfields = include 'admin/import_fields.inc.php';
		$fields = array_merge($memberfields, $fields);
		foreach($fields as $field=>$val_field)
		{
			if($field == 'userid') continue;
			$oldfield = trim($import_info[$field]['field']);
			$func = trim($import_info[$field]['func']);
			$value = trim($import_info[$field]['value']);

			if($value)
			{
				$data[$field] = $value;
			}
			else
			{
				if($oldfield && $func)
				{
					$oldfields[$oldfield] = $field;
					$oldfuncs[$oldfield] = $func;
				}
				elseif($oldfield )
				{
					$oldfields[$oldfield] = $field;
				}
			}	
		}
		
		$result = $this->filter_fields($import_info, $offset, $keyid);
		@extract($result);
		
		$ddata = $data;

		$query= $this->sqldb->query("SELECT $selectfield FROM $table $condition ORDER BY $orderby $limit");
		$importnum = $this->sqldb->num_rows($query);
		while ($r = $this->sqldb->fetch_array($query))
		{
			$data = $ddata;
			$r = new_addslashes($r);
			@extract($r);
			foreach ($r as $k=>$v)
			{
				if(isset($oldfields[$k]) && $v)
				{
					if($oldfuncs[$k])
					{
						$data[$oldfields[$k]] = $oldfuncs[$k]($v);
						if(!$data[$k]) continue;
					}
					else
					{
						if(!$oldvalues[$k])	$data[$oldfields[$k]] = $v;
					}
				}
			}
			$maxid = max($maxid, $r[$keyid]);
			$s[] = $data;			
		}
		
		$this->sqldb->free_result($query);
		if(!$this->sameserver) $this->sqldb->close();
		if($this->sameserver)
		{
			if($import_info['charset'] != DB_CHARSET)
			{
				$dbclass = 'db_'.DB_DATABASE;
				$this->db = new $dbclass;
				$this->db->connect(DB_HOST, DB_USER, DB_PW, DB_NAME, DB_PCONNECT, DB_CHARSET);
			}
			else
			{
				$this->db->select_db(DB_NAME);
			}
		}
		foreach ($s as $val)
		{
			if($import_info['membercheck'])
			{
				if($member_api->check_email_user($val['username'], $val['email']))	continue;
			}
			if(DB_CHARSET == 'utf8' && $import_info['dbtype'] == 'access') $val = str_charset(CHARSET, 'gbk', $val);
			$userid = $member_api->add($val, 1);
			if($val['modelid'])
			{
				$modelinfo = array();
				$member_input = new member_input($val['modelid']);
				$member_update = new member_update($val['modelid'], $userid);
				$inputinfo = $member_input->get($val, 1);
				$modelinfo = $inputinfo['model'];
				if(is_array($modelinfo) && !empty($modelinfo))
				{					
					$member_update->update($modelinfo);
					$modelinfo['userid'] = $userid;
					$member_api->edit_model($val['modelid'], $modelinfo);
				}
			}
		}	
		$name = $import_info['name'];
        $finished = 0;
		if($number && ($importnum < $number))
	    {
			$finished = 1;		
		}
		$import_info['maxid'] = $maxid;
		$import_info['importtime'] = TIME;
		$this->setting($import_info, 'member');
		return $finished.'-'.$total;
	}

	function add_content($import_info, $offset)
	{
		global $content;
		$data = array();
		$keyid = $import_info['contentid']['field'];
		if(!$keyid)
		{
			$this->msg = 'the_keyid_not_exists';
			return false;
		}
		$import_info['defaultcatid'] = intval($import_info['defaultcatid']);
		if(!$import_info['defaultcatid'])
		{
			return false;
		}
		$number = $import_info['number'];
		$data['catid'] = $import_info['defaultcatid'];
		$this->connect_db($import_info['dbtype'], $import_info['dbhost'], $import_info['dbuser'], $import_info['dbpw'], $import_info['dbname'], $import_info['charset']);
		$fields = cache_read($import_info['modelid'].'_fields.inc.php', CACHE_MODEL_PATH);
		foreach ($fields as $field=>$val_field)
		{
			if($field == 'contentid') continue;
			$oldfield = trim($import_info[$field]['field']);
			$func = trim($import_info[$field]['func']);
			$value = trim($import_info[$field]['value']);
			if($value)
			{
				$data[$field] = $value;
			}
			else
			{
				if($oldfield && $func)
				{
					$oldfields[$oldfield] = $field;
					$oldfuncs[$oldfield] = $func;
				}
				elseif($oldfield )
				{
					$oldfields[$oldfield] = $field;
				}
			}	
		}
		$result = $this->filter_fields($import_info, $offset, $keyid);
		@extract($result);
		$ddata = $data;
		$query = $this->sqldb->query("SELECT $selectfield FROM $table $condition ORDER BY $orderby $limit");
		$importnum = $this->sqldb->num_rows($query);
		while ($r = $this->sqldb->fetch_array($query))
		{
			$data = $ddata;
			$r = new_addslashes($r);
			foreach ($r as $k=>$v)
			{
				if(isset($oldfields[$k]) && $v)
				{
					if($oldfuncs[$k])
					{
						$data[$oldfields[$k]] = $oldfuncs[$k]($v);
						if(!$data[$k]) continue;
					}
					else
					{
						if(!$oldvalues[$k])	$data[$oldfields[$k]] = $v;
					}
				}
			}
			$maxid = max($maxid, $r[$keyid]);
			$s[] = $data;
		}
		$this->sqldb->free_result($query);
		if(!$this->sameserver) $this->sqldb->close();
		if($this->sameserver)
		{
			if($import_info['charset'] != DB_CHARSET)
			{
				$dbclass = 'db_'.DB_DATABASE;
				$this->db = new $dbclass;
				$this->db->connect(DB_HOST, DB_USER, DB_PW, DB_NAME, DB_PCONNECT, DB_CHARSET);
			}
			else
			{
				$this->db->select_db(DB_NAME);
			}
		}
		foreach ($s as $val)
		{
			if($val['url']) $val['islink'] = 1;
			if(DB_CHARSET == 'utf8' && $import_info['dbtype'] == 'access') $val = str_charset(CHARSET, 'gbk', $val);
			$contentid = $content->add($val, 0, 1);
		}
        $finished = 0;
		if($number && ($importnum < $number))
	    {
			$finished = 1;			
		}
		$import_info['maxid'] = $maxid;
		$import_info['importtime'] = TIME;
		$this->setting($import_info);
		return $finished.'-'.$total;
	}
	
	function _db_content($import_info, $offset)
    {
		global $attachment;
        $data = array();
        $mails = '';
        $dbinfo = cache_read('db_'.$import_info['dataname'].'.php');
        @extract($dbinfo);
		$this->connect_db('mysql', $dbhost, $dbuser, $dbpw, $dbname);
        $result = $this->filter_fields($import_info, $offset);
        @extract($result);
        $query = $this->sqldb->query("SELECT $selectfield FROM $table $condition $limit");
        $i = 0;
		while ($r = $this->sqldb->fetch_array($query))
		{
            if(!empty($r[$import_info['email']]))
            {
                $mails.= $r[$import_info['email']]."\n";
                $i++;
            }
        }
        file_put_contents($this->mail_datadir.$import_info['mailname'].'.txt', $mails, FILE_APPEND);
        return $i.'-'.$offset.'-'.$total;
    }
	
	/**
	 * 取得某个导入设置的信息
	 *
	 * @param unknown_type $name
	 * @return unknown
	 */
	function view($name, $type = 'content')
	{
		if(!$name) return false;
		if(!$type)
		{
			return false;
		}
		$array = new_stripslashes(cache_read($name.'.php', CACHE_IMPORT_PATH.$type.'/'));
		return $array[$name];
	}

	function delete($name, $type)
	{
		if(!isset($name)) return false;
		cache_delete($name.'.php', CACHE_IMPORT_PATH.$type.'/');
		return true;
	}

	/**
	 * 更新用户模型配置文件
	 *
	 * @param array $setting
	 * @param strong $type
	 * @return true
	 */
	function setting($setting, $type = 'content')
	{
		if(empty($setting) || !is_array($setting)) return false;
		$setting['edittime'] = TIME;
		$array[$setting['name']] = $setting;
		cache_write($setting['name'].'.php', $array, CACHE_IMPORT_PATH.$type.'/');
		return true;
	}


	function manage($type)
	{
		$files = glob(CACHE_IMPORT_PATH.$type.'/*.php');
	    $settings = array();
		if(is_array($files))
		{
			foreach($files as $f)
			{
				$array[] = include($f);
			}
		}
		return $array;
	}

	function msg()
	{
		global $LANG;
		return $LANG[$this->msg];
	}
}

function catstr($str)
{
	return substr($str,0,80);
}
?>
