<?php
class pay_api
{
	var $member ='';
	var $exchange_table = '';
	var $db ='';
	var $error = '';

	function pay_api()
	{
		global $db;
		$this->exchange_table = DB_PRE.'pay_exchange';
        $this->stat_table = DB_PRE.'pay_stat';
		$this->db = &$db;
		$this->member = load('member_api.class.php', 'member', 'api');
	}

	/**
	 *
	 *	@params string  $module moudel name
	 *	@params string  $type	( point or amount(money) )
	 *	@params float   $number (point or money) amount (如果减少 point(or money) 用'-'(减号)连接)
	 *	@params mixed   $note	note
	 *	@params mixed   $userid 为0表示为当前用户 int&array 使用array的时候建议对用户进行增加 point or amount
     *  @params string  $authid  文章权限
	 *	@return boolean
	 */

	function update_exchange($module, $type, $number, $note = '', $userid =0, $authid = '')
	{
		global $MODULE, $_userid, $_username, $_point, $_amount;
        $inputid = $_userid;
        $inputer = $_username;
		if(!isset($MODULE[$module])) showmessage('模块不存在！');
		$field = $type == 'point' ? 'point' : 'amount';
		if(!is_numeric($number)) showmessage('金额不对！');
        $number = floatval($number);
		$time = date('Y-m-d H:i:s', TIME);
		$ip = IP;
        $authid = trim($authid);
        if(!empty($authid))
        {
            $authid = md5(AUTH_KEY.$authid);
        }
        if(!is_array($userid))
        {
            $userid = intval($userid);
            if($userid < 1)
            {
                $userid = $_userid;
                $username = $_username;
                if ('amount' == $type)
                {
                    $blance = $_amount + $number;
                    if($blance<0)  {$this->error = 0; return false;} //showmessage('金额不足');
                }
                else
                {
                    $blance = $_point + $number;
                    if($blance < 0)  {$this->error = 1; return false;} //showmessage('点数不足');
                }
                $this->member->set($userid, array($field=>$blance));
                $value = "('{$module}' ,'{$type}','{$number}','{$blance}' ,'{$userid}','{$username}','{$inputid}','{$inputer}', '{$time}', '{$ip}', '{$note}', '{$authid}')";
            }
            else
            {
                $userinfo = $this->member->get($userid, array($field,'username'));
                $username = $userinfo['username'];
                if ('amount' == $type)
                {
                    $blance = $userinfo['amount'] + $number;
                    if($blance < 0)  {$this->error = 0; return false;} //showmessage('金额不足');
                }
                else
                {
                    $blance = $userinfo['point'] + $number;
                    if($blance < 0) {$this->error = 1;return false;} //showmessage('点数不足');
                }
                $this->member->set($userid, array($field=>$blance));
                $value = "('{$module}' ,'{$type}','{$number}','{$blance}' ,'{$userid}','{$username}','{$inputid}','{$inputer}', '{$time}', '{$ip}', '{$note}', '{$authid}')";
            }
            $this->setStat($type,$number);
        }
        else
        {
            $value = '';
            foreach($userid AS $k => $v)
            {
                if($v && !empty($v))
                {
                    $userinfo = $this->member->get($v, array($field,'username'));
                    $username = $userinfo['username'];
                    if ('amount' == $type)
                    {
                        $blance = $userinfo['amount'] + $number;
                        if($blance < 0)  {$this->error = 0; return false;} //showmessage('金额不足');
                    }
                    else
                    {
                        $blance = $userinfo['point'] + $number;
                        if($blance < 0) {$this->error = 1;return false;} //showmessage('点数不足');
                    }
                    $this->member->set($userid, array($field=>$blance));
                    $value .=  "('{$module}' ,'{$type}','{$number}','{$blance}' ,'{$v}','{$username}','{$inputid}','{$inputer}', '{$time}', '{$ip}', '{$note}', '{$authid}'),";
                    $this->setStat($type,$number);
                }
            }
            $value = substr($value, 0, -1);
        }
		$sql = "INSERT INTO `$this->exchange_table` (`module` ,`type`,`number`,`blance` ,`userid`,`username`,`inputid`,`inputer`, `time`, `ip`, `note`, `authid`) VALUES ".$value;
		if ($this->db->query($sql)) return true;
	}
	/**
	 *	判断文章查看是否过期
	 *	@params int $itemid
	 *	@params int $chargedays
	 *	@return boolean
	 */
    function setUserAmount($userid, $filed, $amount)
    {
        $userid = intval($userid);
        $this->member->set($userid, array($field=>$amount));
        return true;
    }
    function getUserAmount($userid, $type, $amount)
    {
        $type = trim($type);
        $userid = trim($userid);
        if(empty($type)) return false;
        if(empty($userid)) return false;
        $userinfo = $this->member->get($userid, array($type,'username'));
        switch($type)
        {
            case 'amount':
                $blance = $userinfo['amount'] + $amount;
                break;
            case 'point':
                $blance = $userinfo['amount'] + $amount;
                break;
        }
    }
	function is_exchanged($itemid, $chargedays = 0)
	{
		global $_userid;
		$itemid = intval($itemid);
		$chargedays = intval($chargedays);
        if($chargedays && $itemid)
		{
			$authid = md5(AUTH_KEY.$itemid.$chargedays);
			$r = $this->db->get_one("SELECT `time` FROM `$this->exchange_table` WHERE `authid`='$authid' AND `userid`='{$_userid}' ORDER BY `id` DESC LIMIT 1");
			if(!$r)
			{
				$this->error = 2;
				return FALSE;
			}
			elseif( TIME - ( strtotime($r['time']) + $chargedays*24*3600) )
			{
				return TRUE;
			}
			else
			{
				$this->error = 3;
				return FALSE;
			}
		}
		else
        {
            $this->error = 4;
            return FALSE;
        }
	}
    function setStat($type, $num)
    {
        if(!in_array($type,array('amount', 'point')))
        {
            $this->error = 5; return false;
        }
        $num = trim($num);

        $keyid = date('Y-m-d');
        $row = $this->db->get_one("SELECT * FROM `$this->stat_table` WHERE `date` = '$keyid' AND `type` = '$type'");
        if($num > 0)
        {
            if(empty($row))
            {
                $sql = "INSERT INTO `$this->stat_table` (`date`, `type` , `receipts`) VALUES ('$keyid','$type','$num')";
            }
            else
            {
                $sql = "UPDATE `$this->stat_table` SET `receipts` = receipts + $num WHERE `date` = '$keyid' AND `type`='$type'";
            }
        }
        else
        {
            $n = -$num;
            if(empty($row))
            {
                $sql = "INSERT INTO `$this->stat_table` (`date`, `type` , `advances`) VALUES ('$keyid','$type','$n')";
            }
            else
            {
                $sql = "UPDATE `$this->stat_table` SET `advances` = advances + $n WHERE `date` = '$keyid' AND `type`='$type'";
            }
        }
        return $this->db->query($sql);
    }

	function error()
    {
		$ERRORMSG = array(
					0 => '金额不足',
					1 => '点数不足',
					2 => '你没有权限查看,请支付后在查看',
					3 => '你的查看时间已过期',
                    4 => '参数设置出错',
                    5 => '错误的参数',
                    6 => '数量不能为空'
				);
		return $ERRORMSG[$this->error];
	}
}
?>