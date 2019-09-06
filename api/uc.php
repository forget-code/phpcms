<?php
include '../include/common.inc.php';
if(!$PHPCMS['uc'])  exit('Ucenter client disabled !');
require PHPCMS_ROOT.'member/include/common.inc.php';
require PHPCMS_ROOT.'member/api/client/client.php';

parse_str(uc_authcode($code, 'DECODE', UC_KEY), $arr) ;

if(TIME - intval($arr['time']) > 3600) 	exit('Authracation has expiried');
if(empty($arr)) exit('Invalid Request');

$action = $arr['action'];

if ($action=='test') 	exit('1');

if ($action=='deleteuser')
{
	exit('1') ;
}

if($action=='updatepw')
{
	$password=md5(PASSWORD_KEY.$arr['password']) ;
	$username = $arr['username'] ;
	$db->query("update ".DB_PRE."member set password='$password' where username='$username'");
	$db->query("update ".DB_PRE."member_cache  set password='$password' where username='$username'");
	exit(API_RETURN_SUCCEED);
}

if($action == 'synlogin')
{
	$userid = $arr['uid'];
	$userinfo = $member->get($userid);
	if(!$userinfo) exit('0');
	extract($userinfo);
	if(!$cookietime) $get_cookietime = 86400 * 365;
	$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
	$cookietime = $_cookietime ? TIME + $_cookietime : 0;
	$phpcms_auth_key = md5(AUTH_KEY.$_SERVER['HTTP_USER_AGENT']);
	$phpcms_auth = phpcms_auth($userid."\t".$password, 'ENCODE', $phpcms_auth_key);
    ob_clean() ;
    header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
	set_cookie('auth', $phpcms_auth, $cookietime);
	set_cookie('cookietime', $_cookietime, $cookietime);
	exit(1);
}

if($action=='updatecredit')
{
	$arr_credit = array(
        1 => 'point',
        2 => 'amount',
	);
	$credit = $arr_credit[$arr['credit']];
	$amount=intval($arr['amount']);
	$uid = intval($arr['uid']);
	$userinfo = $member->get($uid);
	$username = $userinfo['username'];
	if(!$userinfo || !$amount)  exit(API_RETURN_SUCCEED);
	$db->query("update ".DB_PRE."member set $credit=$credit+$amount where username='$username' ");
	$db->query("update ".DB_PRE."member_cache set $credit=$credit+$amount where username='$username' ");
	exit(API_RETURN_SUCCEED);
}

if($action=='synlogout')
{
    header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
	set_cookie('auth', '', -3600);
	set_cookie('username', '', -3600);
}

if($action == 'getcreditsettings') 
{

	!API_GETCREDITSETTINGS && exit(API_RETURN_FORBIDDEN);
	$credits = array(
        1 => array('点数', '点'),
        2 => array('金钱', '元'),
	);
	echo uc_serialize($credits);
}

if($action == 'updatecreditsettings') {

	!API_UPDATECREDITSETTINGS && exit(API_RETURN_FORBIDDEN);
	$outextcredits = array();
	foreach($arr['credit'] as $appid => $credititems) {
		if($appid == UC_APPID) {
			foreach($credititems as $value) {
				$outextcredits[$value['appiddesc'].'|'.$value['creditdesc']] = array(
					'creditsrc' => $value['creditsrc'],
					'title' => $value['title'],
					'unit' => $value['unit'],
					'ratio' => $value['ratio']
				);
			}
		}
	}
	
	cache_write('creditsettings.php', $outextcredits);

	exit(API_RETURN_SUCCEED);

}
?>