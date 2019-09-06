<?php
/**
 * 视频状态接收接口
 *			
 * @author				phpip(wangcanjia@phpip.com)
 * @link				http://www.phpcms.cn http://www.ku6.cn
 * @copyright			2005-2010 PHPCMS/KU6 Software LLCS
 * @license				http://www.phpcms.cn/license/
 * @datetime			2009-12-8
 * @lastmodify			2009-12-8
 * ------------------------------------------------------------
 * 
 */

$mod = 'video';/*定义默认要读取的模块信息*/

require '../include/common.inc.php';
//'vid, picpath, size, timelen, status
$size = intval($size);
$timelen = intval($timelen);
$status = intval($status);

/* 验证vid */
if(!$vid) exit(json_encode(array('status'=>'101','msg'=>'vid not allowed to be empty')));
/* 验证图片地址 */
if(!preg_match('/http:\/\//',$picpath)) exit(json_encode(array('status'=>'102','msg'=>'picpath incorrect')));
/* 验证视频大小 */
if($size<100) exit(json_encode(array('status'=>'103','msg'=>'size incorrect')));
/* 验证视频时长 */
if($timelen<1) exit(json_encode(array('status'=>'104','msg'=>'timelen incorrect')));
/* 验证md5 */
if(!$md5) exit(json_encode(array('status'=>'105','msg'=>'md5 incorrect')));

$sn = $M['sn'];
unset($M);

/*切勿更改顺序*/
$md5pass = strtoupper(md5($vid.$picpath.$size.$timelen.$status.$sn));
if($md5 != $md5pass) exit(json_encode(array('status'=>'106','msg'=>'Authentication Failed')));
$table = DB_PRE.$mod;
$table_data = DB_PRE.$mod.'_data';
$r = $db->get_one("SELECT `vid`,`vmsvid` FROM `$table_data` WHERE `vmsvid`='$vid'");
if($r)
{
	/*查询是否存在数据*/
	$rv = $db->get_one("SELECT `vid`,`thumb` FROM `$table` WHERE `vid`='$r[vid]'");
	/*判断是否手动增加过缩略图 、存在缩略图则不更新现有的*/
	if($rv['thumb'])
	{
		$db->query("UPDATE `$table` SET `status`=99,`timelen`='$timelen' WHERE `vid`='$r[vid]'");
	}
	else
	{
		$db->query("UPDATE `$table` SET `thumb`='$picpath',`status`=99,`timelen`='$timelen' WHERE `vid`='$r[vid]'");
	}
	exit(json_encode(array('status'=>'200','msg'=>'Success')));
}
else
{
	exit(json_encode(array('status'=>'107','msg'=>'Data is empty!')));
}
exit;
//http://phpip.com/__video/api/ku6vms.php?vid=Av2TzW-9nUs.&size=200&timelen=12&picpath=http://ddd&md5=04D8F2CF572AC79E26EFCF494F0515BB


?>