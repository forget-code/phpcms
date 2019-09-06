<?php
defined('IN_PHPCMS') or exit('Access Denied');


/**
 * 取得返回信息地址
 * @param   string  $code   支付方式代码
 */
function return_url($code, $is_api = 0)
{
	global $PHPCMS;
	if($is_api)
	{
		return $PHPCMS['siteurl'].'pay/api/AutoReceive.'.$code.'.php';
	}
	else
	{
		return $PHPCMS['siteurl'].'pay/respond.php?code='.$code;
	}
}

function changeorder($sn)
{
	global $db;
    $sn = trim($sn);
    $row = $db->get_one("SELECT * FROM ".DB_PRE."pay_user_account WHERE `sn` = '$sn' AND `ispay` = '1'");
    if(empty($row))
    {
        $sql = "UPDATE ".DB_PRE."pay_user_account SET `ispay` = '1', `paytime` =".TIME." WHERE `sn` = '$sn'";
	    if( $db->query($sql) )
        {
            $info = get_order($sn);
			//print_r($sn);
            $pay = load('pay_api.class.php', 'pay', 'api');
            $note = '用户网上充值';
            if($pay->update_exchange('pay', 'amount', $info['quantity'], $note, $info['userid']))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
    else
    {
        return false;
    }
}

function get_order($sn)
{
    global $db;
    $sn = trim($sn);
    return $db->get_one("SELECT * FROM ".DB_PRE."pay_user_account WHERE `sn` = '$sn' ");
}

/**
 *  取得某支付方式信息
 *  @param  string  $code   支付方式代码
 */
function get_payment($code)
{
	global $db;
    $sql = "SELECT * FROM " .DB_PRE."pay_payment WHERE `pay_code` = '$code' AND `enabled` = '1'";
    $info= $db->get_one($sql);
	$cfg = $info['config'];
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
function pay_fee( $amount, $fee)
{
    $pay_fee = 0;
    if (strpos($fee, '%') !== false)
    {
        /* 支付费用是一个比例 */
        $val     = floatval($fee) / 100;
        $pay_fee = $val > 0 ? $amount * $val : 0;
    }
    else
    {
        $pay_fee = floatval($fee);
    }
    return round($pay_fee, 2);
}

/**
 *	根据用户id或用户名称 得出用户的信息
 *	@params
 *	@return
 */

function get_user($userid , $username='')
{
	global $db;
	if ('0' == $userid) {
		$sql = "SELECT `username` , `userid`, `amount`, `point` FROM ".DB_PRE."member_cache WHERE `username` = '{$username}'" ;
	}else {
		$userid = intval($userid);
		$sql = "SELECT `username` , `userid`, `amount`, `point` FROM ".DB_PRE."member_cache WHERE `userid` = '{$userid}'" ;
	}
	return $db->get_one($sql);
}


/**
 *	生成一个号码
 *	@params
 *	@return
 */

function create_sn()
{
	mt_srand( ( double )microtime( ) * 1000000 );
	return date( "YmdHis" ).str_pad( mt_rand( 1, 99999 ), 5, "0", STR_PAD_LEFT );
}
?>