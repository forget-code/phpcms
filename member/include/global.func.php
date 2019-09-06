<?php
defined('IN_PHPCMS') or exit('Access Denied');

if (!function_exists('is_badword'))
{
	function is_badword($string)
	{
		$badwords = array("\\",'&',' ',"'",'"','/','*',',','<','>',"\r","\t","\n","#");
		foreach($badwords as $value)
		{
		    if(strpos($string,$value) !== FALSE)
			{ 
		        return TRUE; 
		    }
		}
		return FALSE;
	}
}

function uc_call($func, $params=null)
{
    restore_error_handler();

    if (!function_exists($func))
    {
        include_once(MOD_ROOT.'api/client/client.php');
    }

    $res = call_user_func_array($func, $params);
    set_error_handler('exception_handler');

    return $res;
}

function uc_post($url, $limit = 0, $post = '', $cookie = '', $ip = '', $timeout = 15, $block = true)
{
	$return = '';
	$matches = parse_url($url);
	$host = $matches['host'];
	$path = $matches['path'] ? $matches['path'].($matches['query'] ? '?'.$matches['query'] : '') : '/';
	$port = !empty($matches['port']) ? $matches['port'] : 80;
	
	if($post) {
		$out = "POST $path HTTP/1.1\r\n";
		$out .= "Accept: */*\r\n";
		$out .= "Referer: ".SITE_URL."\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$out .= "Host: $host\r\n" ;
		$out .= 'Content-Length: '.strlen($post)."\r\n" ;
		$out .= "Connection: Close\r\n" ;
		$out .= "Cache-Control: no-cache\r\n" ;
		$out .= "Cookie: $cookie\r\n\r\n" ;
		$out .= $post ;
	} else {
		$out = "GET $path HTTP/1.1\r\n";
		$out .= "Accept: */*\r\n";
		$out .= "Referer: ".SITE_URL."\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$out .= "Host: $host\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Cookie: $cookie\r\n\r\n";
	}
	$fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
	if(!$fp) 	return '';
	
	stream_set_blocking($fp, $block);
	stream_set_timeout($fp, $timeout);
	@fwrite($fp, $out);
	$status = stream_get_meta_data($fp);
	
	if($status['timed_out']) return '';	
	while (!feof($fp))
	{
			if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n"))  break;				
	}
	
	$stop = false;
	while(!feof($fp) && !$stop)
	{
		$data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
		$return .= $data;
		if($limit) 
		{
			$limit -= strlen($data);
			$stop = $limit <= 0;
		}
	}
	@fclose($fp);
	return $return;
}


?>