<?php
defined('IN_PHPCMS') or exit('Access Denied');

function phpcms_encode($txt, $key)
{
	srand((double)microtime() * 1000000);
	$encrypt_key = md5(rand(0, 32000));
	$ctr = 0;
	$tmp = '';
	for($i = 0;$i < strlen($txt); $i++) 
	{
		$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		$tmp .= $encrypt_key[$ctr].($txt[$i] ^ $encrypt_key[$ctr++]);
	}
	return base64_encode(phpcms_key($tmp, $key));
}

function phpcms_decode($txt, $key) 
{
	$txt = phpcms_key(base64_decode($txt), $key);
	$tmp = '';
	for ($i = 0;$i < strlen($txt); $i++)
	{
		$md5 = $txt[$i];
		$tmp .= $txt[++$i] ^ $md5;
	}
	return $tmp;
}

function phpcms_key($txt, $encrypt_key)
{
	$encrypt_key = md5($encrypt_key);
	$ctr = 0;
	$tmp = '';
	for($i = 0; $i < strlen($txt); $i++)
	{
		$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		$tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
	}
	return $tmp;
}
?>