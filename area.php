<?php 
require './include/common.inc.php'; 
require PHPCMS_ROOT.'/include/area.func.php'; 

if(!isset($action)) $action = 'province';

switch($action)
{
    case 'province':
		$provinces = province();
		if($provinces) array_unshift($provinces, $LANG['unrestricted']);
	    $provinces = implode(',', $provinces);
	    include template('phpcms', 'province');
		break;

    case 'city':
		if(!isset($province)) $province = '北京市';

		$citys = city($province);
		if($citys) array_unshift($citys, $LANG['unrestricted']);
	    $citys = implode(',', $citys);
        include template('phpcms', 'city');
		break;

    case 'area':
		if(!isset($province)) $province = '北京市';
		if(!isset($city)) $city = '海淀区';

		$areas = area($province, $city);
		if($areas && count($areas) > 1) array_unshift($areas, $LANG['unrestricted']);
	    $areas = implode(',', $areas);
        include template('phpcms', 'area');
		break;

    default :
}
?>