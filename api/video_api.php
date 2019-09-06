<?php
/**
 * 视频通知接口
 */
defined('IN_PHPCMS') or exit('No permission resources.'); 

$video_setting = getcache('video','video');

if(empty($_POST['sn']) || $_POST['sn'] != $video_setting['sn']) {
	echo json_encode(array('msg'=>'Authentication Failed','code'=>'-1'));
	exit;
}
$xxtea = pc_base::load_app_class('xxtea', 'video');
$token = $_POST['token'];
$decode_token = $xxtea->decrypt($token,$video_setting['skey']);
if(empty($_POST['posttime']) || $decode_token != $_POST['posttime']) {
	echo json_encode(array('msg'=>'Authentication Failed','code'=>'-2'));
	exit;
}
$action = $_POST['action'];
if(isset($_GET['action'])) $action = 'ping';

if (!preg_match('/([^a-z_]+)/i',$action) && file_exists(PHPCMS_PATH.'api/video_api/'.$action.'.php')) {
	include PHPCMS_PATH.'api/video_api/'.$action.'.php';
} else {
	exit('Video action does not exist');
}
?>