<?php 
class upgrade
{
	var $modules;
	var $update_url;
	var $http;

    function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->update_url = 'http://update.phpcms.cn/';
		$this->http = load('http.class.php');
    }

	function upgrade()
	{
		$this->__construct();
	}

	function check()
	{
		$url = $this->url('check');
        if(!$this->http->get($url)) return false;
		return $this->http->get_data();
	}

	function url($action = 'check')
	{
		global $MODULE, $PHPCMS, $_username, $_email;
        $modules = '';
		foreach($MODULE as $module=>$m)
		{
			$modules .= ','.$module.'|'.$m['version'];
		}
		$modules = substr($modules, 1);
		$pars = array(
			'action'=>$action,
			'phpcms_username'=>$PHPCMS['phpcms_username'],
			'sitename'=>urlencode($PHPCMS['sitename']),
			'siteurl'=>$PHPCMS['siteurl'],
			'charset'=>CHARSET,
			'version'=>PHPCMS_VERSION,
			'release'=>PHPCMS_RELEASE,
			'os'=>PHP_OS,
			'php'=>phpversion(),
			'mysql'=>$this->db->version(),
			'browser'=>urlencode($_SERVER['HTTP_USER_AGENT']),
			'username'=>urlencode($_username),
			'email'=>$_email,
			'modules'=>$modules,
			);
		$data = http_build_query($pars);
		$verify = md5($data.$PHPCMS['phpcms_password']);
		return $this->update_url.'?'.$data.'&verify='.$verify;
	}

	function notice()
	{
		return $this->url('notice');
	}

	function download()
	{
		@set_time_limit(600);
		$url = $this->url('download');
        if(!$this->http->get($url)) return false;
		$data = $this->http->get_data();
		return file_put_contents(PHPCMS_ROOT.'data/upgrade.php', $data);
	}
}
?>