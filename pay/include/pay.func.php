<?php
defined('IN_PHPCMS') or exit('Access Denied');


/**
 * 取得返回信息地址
 * @param   string  $code   支付方式代码
 */
function return_url($code)
{
	global $MODULE;
    return $MODULE['pay']['url'].'respond.php?code='.$code;
}
function changeorder($sn)
{
	global $db;
	$sql = "UPDATE ".DB_PRE."pay_user_account SET `ispay` = '1' WHERE `sn` = '$sn'";
	return $db->query($sql);
}
/**
 *  取得某支付方式信息
 *  @param  string  $code   支付方式代码
 */
function get_payment($code)
{
	global $db;
    $sql = "SELECT * FROM " .DB_PRE."payment WHERE `pay_code` = '$code' AND `enabled` = '1'";
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
	return date( "Ymd" ).str_pad( mt_rand( 1, 99999 ), 5, "0", STR_PAD_LEFT );
}
?>