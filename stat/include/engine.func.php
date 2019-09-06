<?php
function getEngine($domain) {
	global $LANG;
	$engine = array();
	$engine[] = array('google.com', 'Google');
	$engine[] = array('baidu.com', $LANG['baidu']);
	$engine[] = array('search.yahoo.com', $LANG['yahoo']);
	$engine[] = array('search.cn.yahoo.com', $LANG['yahoo']);
	$engine[] = array('search.live.com', $LANG['microsoft']);
	$engine[] = array('search.msn.com.cn', $LANG['microsoft']);
	$engine[] = array('cha.so.163.com', $LANG['netease']);
	$engine[] = array('iask.com', $LANG['iask']);
	$engine[] = array('sogou.com', $LANG['sogou']);
	$engine[] = array('soso.com', $LANG['soso']);
	$engine[] = array('p.zhongsou.com', $LANG['zhongsou']);
	$engine[] = array('search.114.vnet.cn', $LANG['114_vnet_cn']);
	$engine[] = array('search.china.com', $LANG['sou_china']);
	for ($i = 0; $i < count($engine); $i++) {
		if ($domain == $engine[$i][0]) {
			$value = $engine[$i][1];
			break;
		} else {
			$value = '&nbsp;';
		}
	}
	return $value;
}
?>