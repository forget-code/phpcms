<?php
/**
*	用户注册文件
* 	Writer :Robertvvv
**/
	require './include/common.inc.php';
	$license = format_textarea($M['reglicense']);
	include template($mod, 'regagreement');
?>