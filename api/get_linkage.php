<?php
/**
 * 获取联动菜单接口
 */
defined('IN_PHPCMS') or exit('No permission resources.'); 
if(!$_GET['callback'] || !$_GET['act'])  showmessage(L('error'));

switch($_GET['act']) {
	case 'ajax_getlist':
		ajax_getlist();
	break;
	
	case 'ajax_getpath':
		ajax_getpath($_GET['parentid'],$_GET['keyid'],$_GET['callback']);
	break;		
}


/**
 * 获取地区列表
 */
function ajax_getlist() {

	$keyid = intval($_GET['keyid']);
	$datas = getcache($keyid,'linkage');
	$infos = $datas['data'];
	$where_id = isset($_GET['parentid']) ? $_GET['parentid'] : intval($infos[$_GET['linkageid']]['parentid']);
	$parent_menu_name = ($where_id==0) ? $datas['title'] :$infos[$where_id]['name'];
	foreach($infos AS $k=>$v) {
		if($v['parentid'] == $where_id) {
			$s[]=iconv(CHARSET,'utf-8',$v['linkageid'].','.$v['name'].','.$v['parentid'].','.$parent_menu_name);
		}
	}
	if(count($s)>0) {
		$jsonstr = json_encode($s);
		echo $_GET['callback'].'(',$jsonstr,')';
		exit;			
	} else {
		echo $_GET['callback'].'()';exit;			
	}
}

/**
 * 获取地区父级路径路径
 * @param $parentid 父级ID
 * @param $keyid 菜单keyid
 * @param $callback json生成callback变量
 * @param $result 递归返回结果数组
 * @param $infos
 */
function ajax_getpath($parentid,$keyid,$callback,$result = array(),$infos = array()) {
	$keyid = intval($keyid);
	$parentid = intval($parentid);
	if(!$infos) {
		$datas = getcache($keyid,'linkage');
		$infos = $datas['data'];
	}
	if(array_key_exists($parentid,$infos)) {
		$result[]=iconv(CHARSET,'utf-8',$infos[$parentid]['name']);
		return ajax_getpath($infos[$parentid]['parentid'],$keyid,$callback,$result,$infos);
	} else {
		if(count($result)>0) {
			krsort($result);
			$jsonstr = json_encode($result);
			echo $callback.'(',$jsonstr,')';
			exit;			
		} else {
			$result[]=iconv(CHARSET,'utf-8',$datas['title']);
			$jsonstr = json_encode($result);
			echo $callback.'(',$jsonstr,')';
			exit;
		}
	}
}

?>