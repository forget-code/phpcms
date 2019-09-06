<?php
/*
*####################################################
* PHPCMS v3.0.0 - Advanced Content Manage System.
* Copyright (c) 2005-2006 phpcms.cn
*
* For further information go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*####################################################
*/

$result=$db->query("SELECT * FROM ".TABLE_ADS_PLACE." order by placeid");
while($r=$db->fetch_array($result))
{
	$_adsplaces[$r[placeid]]=$r;
}

?>