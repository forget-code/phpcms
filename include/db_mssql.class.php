<?php
defined('IN_PHPCMS') or exit('Access Denied');

class db_mssql
{
	var $querynum = 0;
	var $connid = 0;
	var $insertid = 0;
	var $cursor = 0;

	function connect($dbhost = 'localhost', $dbuser, $dbpw, $dbname, $pconnect = 0)
	{
		$func = $pconnect == 1 ? 'mssql_pconnect' : 'mssql_connect';
		if(!$this->connid = @$func($dbhost, $dbuser, $dbpw))
		{
        	$this->halt('Can not connect to MsSQL server');
		}
		if($dbname) 
		{
			if(!@mssql_select_db($dbname , $this->connid))
			{
				$this->halt('Cannot use database '.$dbname);
			}
		}
		return $this->connid;
	}

	function select_db($dbname)
	{
		return mssql_select_db($dbname , $this->connid);
	}

	function query($sql, $type = '', $expires = 3600, $dbname = '')
	{
		$this->querynum++;
		$sql = trim($sql);
		if(preg_match("/^(select.*)limit ([0-9]+)(,([0-9]+))?$/i", $sql, $matchs))
		{
			$sql = $matchs[1];
			$offset = $matchs[2];
			$pagesize = $matchs[4];
			$query = mssql_query($sql, $this->connid) or $this->halt('MsSQL Query Error', $sql);
			return $this->limit($query, $offset, $pagesize);
		}
		elseif(preg_match("/^insert into/i", $sql))
		{
			$sql = "$sql; SELECT @@identity as insertid";
			$query = mssql_query($sql, $this->connid) or $this->halt('MsSQL Query Error', $sql);
			$insid = $this->fetch_row($query);
			$this->insertid = $insid[0];
			return $query;
		}
		else
		{
			$query = mssql_query($sql, $this->connid) or $this->halt('MsSQL Query Error', $sql);
			return $query;
		}
	}

	function get_one($sql, $type = '', $expires = 3600, $dbname = '')
	{
		$query = $this->query($sql, $type, $expires, $dbname);
		$rs = $this->fetch_array($query);
		$this->free_result($query);
		return $rs ;
	}

	function select($sql, $keyfield = '')
	{
		$array = array();
		$result = $this->query($sql);
		while($r = $this->fetch_array($result))
		{
			if($keyfield)
			{
				$key = $r[$keyfield];
				$array[$key] = $r;
			}
			else
			{
				$array[] = $r;
			}
		}
		$this->free_result($result);
		return $array;
	}

	function fetch_array($query, $type = MSSQL_ASSOC)
	{
		if(is_resource($query)) return mssql_fetch_array($query, $type);
		if($this->cursor < count($query))
		{ 
			return $query[$this->cursor++]; 
		}
		return FALSE; 
	}

	function affected_rows() 
	{
		return mssql_rows_affected($this->connid);
	}

	function num_rows($query) 
	{
		return is_array($query) ? count($query) : mssql_num_rows($query);
	}
	
	function num_fields($query) 
	{
		return mssql_num_fields($query);
	}

	function result($query, $row)
	{
		return @mssql_result($query, $row);
	}

	function free_result($query)
	{
		if(is_resource($query)) mssql_free_result($query);
	}

	function insert_id()
	{
		return $this->insertid;
	}
	
	function fetch_row($query)
	{
		return mssql_fetch_row($query);
	}

	function close()
	{
		return mssql_close($this->connid);
	}

	function error()
	{
		return TRUE;
	}

	function errno()
	{
		return TRUE;
	}

	function halt($message = '', $sql = '')
	{
		exit("MsSQL Query:$sql <br> MsSQL Error:".$this->error()." <br> MsSQL Errno:".$this->errno()." <br> Message:$message");
	}

	function limit($query, $offset, $pagesize = 0)
	{
		if($pagesize > 0)
		{
			mssql_data_seek($query, $offset);
		}
		else
		{
			$pagesize = $offset;
		}
		$info = array();
		for($i = 0; $i < $pagesize; $i++)
		{
			$r = $this->fetch_array($query);
			if(!$r) break;
			$info[] = $r;
		}
		$this->free_result($query);
		$this->cursor = 0;
		return $info;
	}
}
?>