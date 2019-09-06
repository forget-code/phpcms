<?php
function keyWord($url)
{
	$engine = array();
	$engine[] = array('google.com', 'q');
	$engine[] = array('baidu.com', 'wd');
	$engine[] = array('search.yahoo.com', 'p');
	$engine[] = array('search.cn.yahoo.com', 'p');
	$engine[] = array('search.live.com', 'q');
	$engine[] = array('search.msn.com.cn', 'q');
	$engine[] = array('cha.so.163.com', 'q');
	$engine[] = array('iask.com', 'k');
	$engine[] = array('sogou.com', 'query');
	$engine[] = array('soso.com', 'w');
	$engine[] = array('p.zhongsou.com', 'word');
	$engine[] = array('search.net2asp.com.cn', 'KeyWord');
	$engine[] = array('search.114.vnet.cn', 'kw');
	$engine[] = array('search.china.com', 'query');
    $varname = '';
	$arrtemp = parse_url($url);
	$domain = substr($arrtemp['host'], 0 , 4) == 'www.' ? substr($arrtemp['host'], 4) : $arrtemp['host'];
	foreach($engine as $e)
	{
		if($e[0] == $domain)
		{
			$varname = $e[1];
			break;
		}
	}
	if($varname)
	{
		parse_str($arrtemp['query']);
		$keyword = $$varname;
	    require_once PHPCMS_ROOT.'/include/charset.func.php';
		$value = urldecode($keyword);
		$value1 = convert_encoding('GB2312', 'UTF-8', $value);
		$value2 = convert_encoding('UTF-8', 'GB2312', $value1);
		$keyword = $value == $value2 ? $value : convert_encoding('UTF-8', 'GB2312', $value);
	}
	else
	{
		$keyword = '';
	}
	return $keyword;
}
?>