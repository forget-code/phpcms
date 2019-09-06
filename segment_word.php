<?php 
$actions = array('get_keywords');
$charsets = array('gbk','gb2312','utf-8');
$maxstrlen = 200;
$authkey = 'phpcms_segment_word';

@extract($_GET);
$charset = strtolower($charset);
if(!$string || strlen($string) > $maxstrlen || !in_array($action, $actions) || !in_array($charset, $charsets)) exit;
header('Content-type: text/html;charset='.$charset);
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8>">
</head>
<body>
<script type="text/javascript">
<?php 
if(!@get_cfg_var('allow_url_fopen'))
{
	echo 'alert("无法使用自动提取关键词功能！allow_url_fopen关闭状态，请修改php.ini开启！");';
}
elseif(!preg_match("/^[0-9.]{7,15}$/", @gethostbyname('www.phpcms.cn')))
{
	echo 'alert("无法使用自动提取关键词功能！不能进行DNS解析，请设置好服务器DNS！");';
}
else
{
	$query_string = 'domain='.$_SERVER['SERVER_NAME'].'&'.$_SERVER['QUERY_STRING'];
	$verify = md5($query_string.$authkey);
	$data = @file_get_contents('http://www.phpcms.cn/segment_word.php?'.$query_string.'&verify='.$verify);
	echo 'parent.document.myform.keywords.value = "'.$data.'"';
}
?>
</script>
</body>
</html>