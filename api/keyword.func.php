<?php
define('API_URL_GET_KEYWORDS', 'http://tool.phpcms.cn/api/get_keywords.php');

function get_keywords($data, $number = 2)
{
	$data = trim(strip_tags($data));
    if(empty($data)) return '';
	if(CHARSET != 'utf-8') $data = iconv('utf-8', CHARSET, $data);
	if(extension_loaded('scws'))
	{
		$scws = load('scws.class.php');
		$scws->set_text($data);
		return $scws->get_keywords($number, 'n,nr,ns,nt,nz,vn');
	}
	else
	{
		$http = load('http.class.php');
		$http->post(API_URL_GET_KEYWORDS, array('siteurl'=>SITE_URL, 'charset'=>CHARSET, 'data'=>$data, 'number'=>$number));
		return $http->is_ok() ? $http->get_data() : '';
	}
}
?>