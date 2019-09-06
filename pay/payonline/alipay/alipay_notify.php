<?php
defined('IN_PHPCMS') or exit('Access Denied');
class alipay_notify
{
	var $gateway;
	var $security_code;  	//安全校验码
	var $partner;
	var $sign_type;
	var $mysign;
	var $_input_charset ;
	var $transport;
	function alipay_notify($partner,$security_code,$sign_type = 'MD5',$_input_charset = 'GBK',$transport= 'https') 
	{
		$this->partner     =   $partner;
		$this->security_code = $security_code;
		$this->sign_type = $sign_type;
		$this->mysign = "";
		$this->_input_charset = $_input_charset ;
		$this->transport = $transport;
		if($this->transport == 'https')
		{
			$this->gateway = 'https://www.alipay.com/cooperate/gateway.do?';
		}
		else 
		{
			$this->gateway = 'http://notify.alipay.com/trade/notify_query.do?';
		}
	
	}
	function notify_verify() 
	{   //对notify_url的认证
		if($this->transport == 'https')
		{
			$veryfy_url = $this->gateway. 'service=notify_verify' .'&partner=' .$this->partner. '&notify_id='.$_POST['notify_id'];
		}
		else
		{
			$veryfy_url = $this->gateway. 'notify_id='.$_POST['notify_id'].'&partner=' .$this->partner;
		}
		$veryfy_result = $this->get_verify($veryfy_url);
		$post = $this->para_filter($_POST);
		$sort_post = $this->arg_sort($post);
		while (list ($key, $val) = each ($sort_post))
		{
			$arg.=$key.'='.$val.'&';
		}
		$prestr = substr($arg,0,count($arg)-2);  //去掉最后一个&号
		$this->mysign = $this->sign($prestr.$this->security_code);
		if (eregi('true$',$veryfy_result) && $this->mysign == $_POST['sign'])
		{
			return true;
		}
		else return false;
	}
	//对return_url的认证
	function return_verify()
	{
		$GET = $this->para_filter($this->partner);
		$sort_get= $this->arg_sort($GET);
		while (list ($key, $val) = each ($sort_get))
		{
			if($key != 'sign' && $key != 'sign_type')
			$arg.=$key.'='.$val.'&';
		}
		$prestr = substr($arg,0,count($arg)-2);  //去掉最后一个&号
		$mysign=$this->mysign = $this->sign($prestr.$this->security_code);
		if ($this->mysign ==$this->partner['sign'])
		{
			return true;
		}
		else return false;
	}
	
	function get_verify($url,$time_out = '60') 
	{
		$urlarr = parse_url($url);
		$errno = "";
		$errstr = "";
		$transports = "";
		if($urlarr['scheme'] == 'https') 
		{
			$transports = 'ssl://';
			$urlarr['port'] = '443';
		} 
		else 
		{
			$transports = 'tcp://';
			$urlarr['port'] = '80';
		}
		$fp=@fsockopen($transports . $urlarr['host'],$urlarr['port'],$errno,$errstr,$time_out);
		if($fp) 
		{
			die('ERROR: $errno - $errstr<br />\n');
		} 
		else 
		{
			fputs($fp, 'POST '.$urlarr['path'].' HTTP/1.1\r\n');
			fputs($fp, 'Host: '.$urlarr['host'].'\r\n');
			fputs($fp, 'Content-type: application/x-www-form-urlencoded\r\n');
			fputs($fp, 'Content-length: '.strlen($urlarr['query']).'\r\n');
			fputs($fp, 'Connection: close\r\n\r\n');
			fputs($fp, $urlarr['query'] . '\r\n\r\n');
			while(!feof($fp)) 
			{
				$info[]=@fgets($fp, 1024);
			}
			fclose($fp);
			$info = implode(',',$info);
			while (list ($key, $val) = each ($_POST)) 
			{
				$arg.=$key.'='.$val.'&';
			}
			log_result('return_url_log='.$url.$this->charset_decode($info,$this->_input_charset));
			log_result('return_url_log='.$this->charset_decode($arg,$this->_input_charset));
			return $info;
		}
	}
	function arg_sort($array) 
	{
		ksort($array);
		reset($array);
		return $array;
	}
	
	function sign($prestr) 
	{
		$sign="";
		if($this->sign_type == 'MD5') 
		{
			$sign = md5($prestr);
		}
		elseif($this->sign_type =='DSA') 
		{
			die('DSA 签名方法待后续开发，请先使用MD5签名方式');
		}else {
			die('支付宝暂不支持'.$this->sign_type.'类型的签名方式');
		}
		return $sign;
	}
	function para_filter($parameter) 
	{ //除去数组中的空值和签名模式
		$para = array();
		while (list ($key, $val) = each ($parameter)) 
		{
			if($key == 'sign' || $key == 'sign_type' || $val == '')continue;
			else	$para[$key] = $parameter[$key];
		}
		return $para;
	}
	//实现多种字符编码方式
	function charset_encode($input,$_output_charset ,$_input_charset ='GBK' ) 
	{
		$output = '';
		if(!isset($_output_charset) )$_output_charset  = $this->parameter['_input_charset '];
		if($_input_charset == $_output_charset || $input ==null ) 
		{
			$output = $input;
		} elseif (function_exists('mb_convert_encoding'))
		{
			$output = mb_convert_encoding($input,$_output_charset,$_input_charset);
		} elseif(function_exists('iconv')) 
		{
			$output = iconv($_input_charset,$_output_charset,$input);
		} 
		else die('sorry, you have no libs support for charset change.');
		return $output;
	}
	
	//实现多种字符解码方式
	function charset_decode($input,$_input_charset ,$_output_charset='GBK') 
	{
		$output = '';
		if(!isset($_input_charset) )$_input_charset  = $this->_input_charset ;
		if($_input_charset == $_output_charset || $input ==null ) 
		{
			$output = $input;
		} 
		elseif (function_exists('mb_convert_encoding'))
		{
			$output = mb_convert_encoding($input,$_output_charset,$_input_charset);
		} 
		elseif(function_exists('iconv')) 
		{
			$output = iconv($_input_charset,$_output_charset,$input);
		} 
		else die('sorry, you have no libs support for charset changes.');
		return $output;
	}
}

?>
