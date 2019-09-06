<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$files2 = '|index|login|logout|author|copyfrom|keywords|menu|upload|uppic|file_select|';
$files1 = $files2.'|channel|category|field|keylink|reword|attachment|position|special|type|template|';

if($_grade == 1)
{
	if(strpos($files1, '|'.$file.'|') === FALSE) showmessage($LANG['you_have_no_permission']);
}
elseif(strpos($files2, '|'.$file.'|') === FALSE)
{
	showmessage($LANG['you_have_no_permission']);
}
unset($files1, $files2);

if(isset($keyid) && $keyid) 
{
	if(!in_array($keyid, $_modules) && !in_array($keyid, $_channelids)) showmessage($LANG['you_have_no_permission']);
}
elseif($channelid && !in_array($channelid, $_channelids))
{
	 showmessage($LANG['you_have_no_permission']);
}
?>