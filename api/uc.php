<?php
define('UC_VERSION', '1.0.0');		//UCenter 版本标识

define('API_DELETEUSER', 1);		//用户删除 API 接口开关
define('API_RENAMEUSER', 1);		//用户改名 API 接口开关
define('API_UPDATEPW', 1);		//用户改密码 API 接口开关
define('API_GETTAG', 1);		//获取标签 API 接口开关
define('API_SYNLOGIN', 1);		//同步登录 API 接口开关
define('API_SYNLOGOUT', 1);		//同步登出 API 接口开关
define('API_UPDATEBADWORDS', 1);	//更新关键字列表 开关
define('API_UPDATEHOSTS', 1);		//更新域名解析缓存 开关
define('API_UPDATEAPPS', 1);		//更新应用列表 开关
define('API_UPDATECLIENT', 1);		//更新客户端缓存 开关
define('API_UPDATECREDIT', 1);		//更新用户积分 开关
define('API_GETCREDITSETTINGS', 1);	//向 UCenter 提供积分设置 开关
define('API_UPDATECREDITSETTINGS', 1);	//更新应用积分设置 开关

define('API_RETURN_SUCCEED', '1');
define('API_RETURN_FAILED', '-1');
define('API_RETURN_FORBIDDEN', '-2');
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
	exit('Authracation has expiried');
}
if($action=='updatepw')
{
	!API_UPDATEPW && exit(API_RETURN_FORBIDDEN);
	//更改用户密码
	exit(API_RETURN_SUCCEED);
}

if($action == 'synlogin')
{
	$userid = $member->get_userid($arr['username']);
	$userinfo = $member->get($userid);
	if(!$userinfo){
		$uc_userinfo=uc_call('uc_get_user',array($arr['username'],0));
		if($uc_userinfo[0]>0){
			require_once MOD_ROOT.'api/member_api.class.php';
			$member_api = new member_api();
			$arr_member['touserid'] = $uc_userinfo[0];
			$arr_member['registertime'] = TIME;
			$arr_member['lastlogintime'] = TIME;
			$arr_member['username'] = $uc_userinfo[1];
			$arr_member['password'] = md5(PASSWORD_KEY.$password) ;
			$arr_member['email'] = $uc_userinfo[2];
			$arr_member['modelid'] = 10;
			$member_api->add($arr_member);
			$userid = $member->get_userid($arr['username']);
			$userinfo = $member->get($userid);
		}
	}
	if(!$userinfo){exit(0);}
	extract($userinfo);
	if(!$cookietime) $get_cookietime = 86400 * 365;
	$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
	$cookietime = $_cookietime ? TIME + $_cookietime : 0;
	$phpcms_auth_key = md5(AUTH_KEY.$_SERVER['HTTP_USER_AGENT']);
	$phpcms_auth = phpcms_auth($userid."\t".$password, 'ENCODE', $phpcms_auth_key);
    ob_clean() ;
    header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
	set_cookie('auth', $phpcms_auth, $cookietime);
	set_cookie('username', $member->escape($arr['username']), $cookietime);
	set_cookie('cookietime', $_cookietime, $cookietime);
	exit('1');
}

if($action=='updatecredit')
{
	$arr_credit = array(
        1 => '`point`',
        2 => '`amount`',
	);
	$credit = $arr['credit'];
	$creditField = $arr_credit[$credit];
	$amount=intval($arr['amount']);
	$uid = intval($arr['uid']);
	$userinfo = $member->get_by_touserid($uid);
	$username = $userinfo['username'];
	if(!$username || !$amount)  exit(API_RETURN_SUCCEED);
	$db->query("update ".DB_PRE."member set $creditField=$creditField+$amount where username='$username' ");
	$db->query("update ".DB_PRE."member_cache set $creditField=$creditField+$amount where username='$username' ");
	exit('1');
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

if($action == 'updateapps') 
{
	if(!API_UPDATEAPPS) {
		return API_RETURN_FORBIDDEN;
	}
	include_once PHPCMS_ROOT.'member/api/client/lib/xml.class.php';
	$post = xml_unserialize(file_get_contents('php://input'));

	$cachefile = PHPCMS_ROOT.'member/api/client/data/cache/apps.php';
	$fp = fopen($cachefile, 'w');
	$s = "<?php\r\n";
	$s .= '$_CACHE[\'apps\'] = '.var_export($post, TRUE).";\r\n";
	fwrite($fp, $s);
	fclose($fp);
	exit(API_RETURN_SUCCEED);
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

	exit('1');

}
?>