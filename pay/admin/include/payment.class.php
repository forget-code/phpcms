<?php
class payment
{
	var $_payment_table = '';
	var $_db;
	function __construct()
	{
		$this->payment();
	}

	function payment()
	{
		global $db , $LANG;
		$this->table_payment = DB_PRE.'pay_payment';
		$this->_db = $db;
	}

	/**
	 *	取得支付类型列表
	 *	@params
	 *	@return
	 */
	function get_list()
	{
		$list = $this->get_payment();
		$install = $this->get_intallpayment();
		foreach ($list as $code => $payment )
		{
			if (isset($install[$code]))
			{
				unset($list[$code]);
			}
		}
		$all = array_merge( $install, $list);
		return array('data' => $all,
						array(
								'all' => count($all),
								'install' => count($install)
								)
					);
	 }

	 /**
	  *
	  *	@params
	  *	@return
	  */
	 function read_modules( $directory = "." )
	 {
		 $dir = @opendir( $directory );
		 $set_modules = true;
		 $modules = array();
		 while ( false !== ( $file = @readdir( $dir ) ) )
		 {
			 if ( preg_match( "/^.*?\\.php\$/", $file ) )
			 {
				 include_once( $directory."/".$file );
			 }
		 }
		 @closedir( $dir );
		 unset( $set_modules );
		 foreach ( $modules as $key => $value )
		 {
			ksort( $modules[$key] );
		 }
		 ksort( $modules );
		 return $modules;
	 }

	 /**
	  *	卸载支付插件
	  *	@params int $id
	  *	@return boolean
	  */
	function drop($id)
	{
		$sql = "UPDATE `$this->table_payment` SET `enabled` = '0' WHERE `pay_id` = '{$id}'";
		return $this->_db->query($sql);
	 }

	 /**
	  *	编辑支付插件
	  *	@params int $id
	  *	@return
	  */
	function edit( $id )
	{
		$sql = "SELECT * FROM `$this->table_payment` WHERE `pay_id` = '{$id}'";
		$data = array();
		$data = $this->_db->get_one($sql);
		if( !empty($data) )
		{
             $data['config'] = string2array($data['config']);
			 //$data['config'] = unserialize($data['config']);
		}
		return $data;
	 }

	 /**
	  *	更新支付插件
	  *	@params array $data
	  * @params string $where
	  *	@return boolean
	  */
	function update($data = array(),$where)
	{
		return $this->_db->update($this->table_payment,$data,$where);
	}
	 /**
	  *	添加支付插件
	  *	@params array $data
	  *	@return boolean
	  */
	function add( $data =array() )
	{
		return $this->_db->insert($this->table_payment, $data);
	}
	/**
	 *	取得支付插件列表
	 *	@params string $code
	 *	@return array
	 */
	function get_payment( $code = '')
	{
		$modules = $this->read_modules(MOD_ROOT.'include/payment');
        $config = array();
		foreach ($modules as $payment)
		{
			if ( empty($code) || $payment['code'])
			{
				include_once ($this->load_lang( $payment['code']));
				$config = array();
				foreach ($payment['config'] as $conf)
				{
					$name = $conf['name'];
					$conf['name'] = $LANG[$name];//echo $conf['name'];
					if ( 'select' == $conf['type'])
					{
						//$config
						$conf['range'] = $LANG[$name.'_range'];
					}
					$config[$name] = $conf;
				}
			}
			$payment_info[$payment['code']] = array(
				"pay_id" => 0,
				"pay_code" => $payment['code'],
				"pay_name" => $LANG[$payment['code']],//支付中文名字
				"pay_desc" => $LANG[$payment['desc']],
				"pay_fee" => '0',
				"config" => $config,
				"is_cod" => $payment['is_cod'],
				"is_online" => $payment['is_online'],
				"enabled" => '0',
				"sort_order" => "",
				"author" => $payment['author'],
				"website" => $payment['website'],
				"version" => $payment['version']
				);
		}
		if (empty($code))
		{
			return $payment_info;
		}
		else
		{
			return empty($payment['code'])? array() : $payment_info[$code];
		}
	 }

	 /**
	  *	取得数据库中的支付列表
	  *	@params string $code
	  *	@return array
	  */
	function get_intallpayment( $code = '')
	{
		if (empty($code)) {
			$intallpayment = array();
			$sql = "SELECT * FROM `$this->table_payment` WHERE `enabled` = '1' ORDER BY `pay_order` ASC";
			$resule = $this->_db->query($sql);
			while ($row = $this->_db->fetch_array($resule))
			{
				$intallpayment[$row['pay_code']] = $row;
			}
			return $intallpayment;
		}
		else
		{
			$sql = "SELECT * FROM `$this->table_payment` WHERE `pay_code` = '{$code}'";
			return $this->_db->get_one($sql);
		}

	}

	function load_lang($filename = '')
	{
		return PHPCMS_ROOT.'languages/'.LANG.'/payment/'.$filename.'.php';
	}
}
?>