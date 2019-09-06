<?php
defined('IN_PHPCMS') or exit('Access Denied');

/**
* Mysql 数据库类，支持Cache功能
*/
class db_mysql
{
	/**
	* MySQL 连接标识
	* @var resource
	*/
	var $connid;
	var $search = array('/union(\s*(\/\*.*\*\/)?\s*)+select/i', '/load_file(\s*(\/\*.*\*\/)?\s*)+\(/i', '/into(\s*(\/\*.*\*\/)?\s*)+outfile/i');
	var $replace = array('union &nbsp; select', 'load_file &nbsp; (', 'into &nbsp; outfile');

	/**
	* 整型变量用来计算被执行的sql语句数量
	* @var int
	*/
	var $querynum = 0;

	/**
	* 数据库连接，返回数据库连接标识符
	* @param string 数据库服务器主机
	* @param string 数据库服务器帐号
	* @param string 数据库服务器密码
	* @param string 数据库名
	* @param bool 是否保持持续连接，1为持续连接，0为非持续连接
	* @return link_identifier
	*/
	function connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect = 0) 
	{
		global $CONFIG;
		$func = $pconnect == 1 ? 'mysql_pconnect' : 'mysql_connect';
		if(!$this->connid = @$func($dbhost, $dbuser, $dbpw))
		{
			$this->halt('Can not connect to MySQL server');
		}
		// 当mysql版本为4.1以上时，启用数据库字符集设置
		if($this->version() > '4.1' && $CONFIG['dbcharset'])
        {
			$serverset = $CONFIG['dbcharset'] ? "character_set_connection='$CONFIG[dbcharset]',character_set_results='$CONFIG[dbcharset]',character_set_client=binary" : '';
			$serverset .= $this->version() > '5.0.1' ? ((empty($serverset) ? '' : ',')." sql_mode='' ") : '';
			$serverset && mysql_query("SET $serverset", $this->connid);
		}
		// 当mysql版本为5.0以上时，设置sql mode
		if($this->version() > '5.0') 
		{
			mysql_query("SET sql_mode=''" , $this->connid);
		}
		if($dbname) 
		{
			if(!@mysql_select_db($dbname , $this->connid))
			{
				$this->halt('Cannot use database '.$dbname);
			}
		}
		return $this->connid;
	}

	/**
	* 选择数据库
	* @param string 数据库名
	*/
	function select_db($dbname) 
	{
		return mysql_select_db($dbname , $this->connid);
	}

	/**
	* 执行sql语句
	* @param string sql语句
	* @param string 默认为空，可选值为 CACHE UNBUFFERED
	* @param int Cache以秒为单位的生命周期
	* @return resource
	*/
	function query($sql , $type = '' , $expires = 3600, $dbname = '') 
	{
		$func = $type == 'UNBUFFERED' ? 'mysql_unbuffered_query' : 'mysql_query';
		if(!($query = $func($sql , $this->connid)) && $type != 'SILENT')
		{
			$this->halt('MySQL Query Error', $sql);
		}
		$this->querynum++;
		return $query;
	}

	/**
	* 执行sql语句，只得到一条记录
	* @param string sql语句
	* @param string 默认为空，可选值为 CACHE UNBUFFERED
	* @param int Cache以秒为单位的生命周期
	* @return array
	*/
	function get_one($sql, $type = '', $expires = 3600, $dbname = '')
	{
		$query = $this->query($sql, $type, $expires, $dbname);
		$rs = $this->fetch_array($query);
		$this->free_result($query);
		return $rs ;
	}

	/**
	* 从结果集中取得一行作为关联数组
	* @param resource 数据库查询结果资源
	* @param string 定义返回类型
	* @return array
	*/
	function fetch_array($query, $result_type = MYSQL_ASSOC) 
	{
		return mysql_fetch_array($query, $result_type);
	}

	/**
	* 取得前一次 MySQL 操作所影响的记录行数
	* @return int
	*/
	function affected_rows() 
	{
		return mysql_affected_rows($this->connid);
	}

	/**
	* 取得结果集中行的数目
	* @return int
	*/
	function num_rows($query) 
	{
		return mysql_num_rows($query);
	}

	function escape($string)
	{
		if(!is_array($string)) return str_replace(array('\n', '\r'), array(chr(10), chr(13)), mysql_real_escape_string(preg_replace($this->search, $this->replace, $string), $this->connid));
		foreach($string as $key=>$val) $string[$key] = $this->escape($val);
		return $string;
	}

	/**
	* 返回结果集中字段的数目
	* @return int
	*/
	function num_fields($query) 
	{
		return mysql_num_fields($query);
	}

    /**
	* @return array
	*/
	function result($query, $row) 
	{
		return @mysql_result($query, $row);
	}

	function free_result($query) 
	{
		return mysql_free_result($query);
	}

	/**
	* 取得上一步 INSERT 操作产生的 ID 
	* @return int
	*/
	function insert_id() 
	{
		return mysql_insert_id($this->connid);
	}

    /**
	* @return array
	*/
	function fetch_row($query) 
	{
		return mysql_fetch_row($query);
	}

    /**
	* @return string
	*/
	function version() 
	{
		return mysql_get_server_info($this->connid);
	}

	function close() 
	{
		return mysql_close($this->connid);
	}

    /**
	* @return string
	*/
	function error()
	{
		return @mysql_error($this->connid);
	}

    /**
	* @return int
	*/
	function errno()
	{
		return intval(@mysql_errno($this->connid)) ;
	}

    /**
	* 显示mysql错误信息
	*/
	function halt($message = '', $sql = '')
	{
		exit("MySQL Query:$sql <br> MySQL Error:".$this->error()." <br> MySQL Errno:".$this->errno()." <br> Message:$message");
	}
}
?>