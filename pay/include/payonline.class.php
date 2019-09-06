<?php
class payonline
{
	var $_db;
	var $_table = '';
	var $_pay_online_table = '';
	var $_pay_account_table = '';
	var $exchange_table = '';
	var $error = '';
	function __construct()
	{
		$this->payonline();
	}
	function payonline()
	{
		global $db;
		$this->_db = $db;
		$this->table = DB_PRE.'pay_payment';
		$this->table_exchange = DB_PRE.'pay_exchange';
		$this->table_t	= DB_PRE.'pay_pointcard_type';
		$this->table_pay_account = DB_PRE.'pay_user_account';
		$this->member = load('member_api.class.php', 'member', 'api');
	}

	function get_list()
	{
		$sql = "SELECT `pay_id`, `pay_code`, `pay_name` FROM `$this->table` payment WHERE `enabled` = '1' AND `is_online` = '1'";
		$result = $this->_db->query($sql);
		while ( $row = $this->_db->fetch_array($result) )
		{
			$list[] = $row;
		}
		$out =  $out = "<select name='payid'>\n";
		foreach ($list as $key => $value)
		{
			$out .= "<option value='{$value['pay_id']}' name ='{$value['pay_code']}'>{$value['pay_name']}</option>\n" ;
		}
		$out .= "</select>&nbsp;";
		return $out;
	}
    function buypoint()
    {
        $sql = "SELECT * FROM `$this->table_t`";
        return $this->_db->select($sql);
    }
    function setBuyPoint($pid)
    {
        global $_userid,$_username;
        $pid = intval($pid);
        $sql = "SELECT `point`, `amount` FROM `$this->table_t` WHERE `ptypeid` = $pid";
        $row = $this->_db->get_one($sql);
        if(!empty($row))
        {
            $pay = load('pay_api.class.php', 'pay', 'api');
            $note = '充值点数';
			$userid		= $_userid;
			$username	= $_username;
			if($pay->update_exchange('pay', 'amount', '-'.$row['amount'], $note, $userid))
            {
                if(!$pay->update_exchange('pay', 'point', $row['point'], $note, $userid))
                {
                    showmessage($pay->error());
                }
            }
            else
            {
                showmessage($pay->error());
            }
        }
    }
	/**
	 *
	 *	@params
	 *	@return
	 */
	function get_offline()
	{
		$sql = "SELECT `pay_id`, `pay_code`, `pay_name` , `pay_desc` FROM `$this->table` WHERE `enabled` = '1' AND `is_online` = '0'";
		$result = $this->_db->query($sql);
		$offlines = array();
		while ( $row = $this->_db->fetch_array($result) )
		{
			$offlines['info'][] = $row;
		}
        $radio = "";
		if(!empty($offlines['info'])) {
            foreach ($offlines['info'] as $key => $value)
            {
                if($key == 0)
                {
                    $radio .= "<input type=\"radio\" checked=\"true\" value='{$value['pay_name']}' name=\"setting[payment]\"/>&nbsp;{$value['pay_name']}<br />";
                }
                else
                {
                    $radio .= "<input type=\"radio\" value='{$value['pay_name']}' name=\"setting[payment]\"/>&nbsp;{$value['pay_name']}<br />";
                }
            }
        }
        else
        {
            $radio .= "<span style=\"color:red;\">请联系管理员启动支付功能</span>";
        }
		$offlines['option'] = $radio;
		return $offlines;
	}

	/**
	 *
	 *	@params array $data
	 *	@return
	 */

	function set_offline($data)
	{
        global $_userid, $_username;
        $data['ispay'] = '0';
        $data['userid'] =   $_userid;
        $data['username'] = $_username;
        $data['ip'] = IP;
        $data['addtime'] = TIME;
        $data['sn'] = create_sn();
		$this->_db->insert( $this->table_pay_account, $data);
        return $this->_db->insert_id();
	}

	function get_online()
	{
		$sql = "SELECT `pay_id`, `pay_code`, `pay_name` , `pay_desc` FROM `$this->table` WHERE `enabled` = '1' AND `is_online` = '1'";
		$result = $this->_db->query($sql);
		$onlines = array();
		while ( $row = $this->_db->fetch_array($result) )
		{
			//$row['config'] = unserialize($row['config']);
			$onlines['info'][] = $row;
		}
		$radio = "";
        if(!empty($onlines['info'])) {
            foreach ($onlines['info'] as $key => $value)
            {
                if($key == 0)
                {
                    $radio .= "<input type=\"radio\" checked=\"true\" value='{$value['pay_id']}' name=\"paymentid\"/>&nbsp;{$value['pay_name']}<br />";
                }
                else
                {
                    $radio .= "<input type=\"radio\" value='{$value['pay_id']}' name=\"paymentid\"/>&nbsp;{$value['pay_name']}<br />";
                }
            }
        }
        else
        {
            $radio .= "<span style=\"color:red;\">请联系管理员启动支付功能</span>";
        }
		$onlines['option'] = $radio;
		return $onlines;
	}

	function set_online($data)
	{
		return $this->_db->insert($this->table_pay_account, $data);
	}
	/**
	 *	充值卡充值
	 *	@params
	 *	@return
	 */
	function set_card($cardid, $cardtype)
	{
		global $_userid, $_username;
		$sql = "SELECT `id` ,`point`, `amount` FROM ".DB_PRE."pay_card WHERE `cardid` = '{$cardid}' AND `status` = '0' ";
		$row = $this->_db->get_one($sql);
		if (!$row)
		{
			$this->error = 0;
			return false;
		}
		else
		{
			$ip = IP;
			$time = date('Y-m-d H-i-s');
			$module = 'pay';
			$type = $cardtype;
			$number = $row[$cardtype];
			$sql = "UPDATE ".DB_PRE."pay_card SET  `userid` = '{$_userid}', `username` = '{$_username}', `regtime` = '{$time}', `regip` = '{$ip}', `status` ='1' WHERE `cardid` = '{$cardid}' ";
			if ($this->_db->query($sql))
			{
                if('point' == $cardtype) {
                    $note = '充值卡充值点数';
                }
                else
                {
                    $note = '充值卡充值金钱';
                }
				$this->update_exchange( $module, $type, $number, $note );
			}
			return true;
		}
	}

	function update_exchange($module, $type, $number, $note = '')
	{
		global $MODULE, $_userid, $_username, $_point, $_amount;
		if(!isset($MODULE[$module])) showmessage('模块不存在！');
		$field = $type == 'point' ? 'point' : 'amount';
		if(!is_numeric($number)) showmessage('金额不对！');
		$number = floatval($number);
		$time = date('Y-m-d H:i:s' ,TIME);
		$ip = IP;
		if ('amount' == $type)
		{
			$blance = $_amount + $number;
		}
		else
		{
			$blance = $_point + $number;
		}
		$this->member->set($_userid, array($field=>$blance));

		$sql = "INSERT INTO `$this->table_exchange` (`module` ,`type`,`number`,`blance` ,`userid`,`username`, `time`, `ip`, `note`) VALUES('{$module}' ,'{$type}','{$number}','{$blance}' ,'{$_userid}','{$_username}', '{$time}', '{$ip}', '{$note}')";
		if ($this->_db->query($sql)) return true;
	}

	/**
	 * 插入会员账目明细
	 *
	 * @access  public
	 * @param   array     $surplus  会员余额信息
	 * @param   string    $amount   余额
	 *
	 * @return  int
	 */
	function insert_user_account($surplus, $amount)
	{
		$sql = 'INSERT INTO '.DB_PRE.'user_account'.
			   ' (user_id, sn,admin_user, amount, add_time, paid_time, admin_note, user_note, process_type, payment, ispay)'.
				" VALUES ('$surplus[user_id]','$surplus[sn]', '', '$amount', '".time()."', 0, '', '$surplus[user_note]', '$surplus[process_type]', '$surplus[payment_name]', 0)";
		$this->_db->query($sql);

		return $this->_db->insert_id();
	}

	/**
	 *
	 *	@params
	 *	@return
	 */
	function get_payment($id , $code = '')
	{
		$cfg = array();
		if (!empty($id))
		{
			$sql = "SELECT * FROM `$this->table` WHERE `pay_id` = '$id'";
		}
		else
		{
			$sql = "SELECT * FROM `$this->table` WHERE 'pay_code' = '$code'";
		}
		return $this->_db->get_one($sql);
	}

	/**
	 *	记录支付日志
	 *	@params
	 *	@return
	 */
	function set_payment_log( $data )
	{
		$this->_db->insert("`$this->_pay_online_table`", $data );
	}
	/**
	 * 处理序列化的支付、配送的配置参数
	 * 返回一个以name为索引的数组
	 *
	 * @access  public
	 * @param   string       $cfg
	 * @return  void
	 */
	function unserialize_config($cfg)
	{
        if (is_string($cfg) )
		{
            $arr = string2array($cfg);
			$config = array();

			foreach ($arr AS $key => $val)
			{
				$config[$key] = $val['value'];
			}

			return $config;
		}
		else
		{
			return false;
		}
	}

	function error()
	{
		$ERRORMSG = array(0=>'卡号不存在',
			              1=>'请选择订阅类别',
			             );
		return $ERRORMSG[$this->error];
	}
}
?>