<?php
function getProvince($country)
{
	global $LANG;
	$province = array(
		$LANG['peking'],
		$LANG['shanghai'],
		$LANG['tientsin'],
		$LANG['Chongqing'],
		$LANG['hebei'],
		$LANG['shansi'],
		$LANG['mongolia'],
		$LANG['liaoning'],
		$LANG['jilin'],
		$LANG['heilongjiang'],
		$LANG['jiangsu'],
		$LANG['zhejiang'],
		$LANG['anhui'],
		$LANG['fukien'],
		$LANG['jiangxi'],
		$LANG['shandong'],
		$LANG['henan'],
		$LANG['hubei'],
		$LANG['hunan'],
		$LANG['kwangtung'],
		$LANG['guangxi'],
		$LANG['hainan'],
		$LANG['szechwan'],
		$LANG['guizhou'],
		$LANG['yunnan'],
		$LANG['tibet'],
		$LANG['shaanxi'],
		$LANG['gansu'],
		$LANG['ningxia'],
		$LANG['tsinghai'],
		$LANG['sinkiang'],
		$LANG['hongkong'],
		$LANG['macao'],
		$LANG['taiwan']
	);
	foreach($province as $p)
	{
		if(strpos($country, $p) !== false) return $p;
	}
	return false;
}
?>