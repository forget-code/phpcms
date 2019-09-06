<?php 
require dirname(__FILE__).'/include/common.inc.php';
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

	case 'ajax':
		if(!$keyid || (!array_key_exists($keyid, $MODULE) && !array_key_exists($keyid, $CHANNEL))) exit;
		$areaid = isset($areaid) ? intval($areaid) :  0;
		$AREA = cache_read('areas_'.$keyid.'.php');
		$str = '<select onchange="$(\'areaid\').value=this.value;this.disabled=true;areaload(this.value);"><option value="s">'.$LANG['please_select'].'</option>';
		$opt = '';
		foreach($AREA as $i=>$v)
		{
			if($v['parentid'] == $areaid)  $opt .= '<option value="'.$i.'">'.$v['areaname'].'</option>';
		}
		if(!$opt) exit;
		$str = $str.$opt.'</select>';
		echo $str;
		break;

    default :
}
?>