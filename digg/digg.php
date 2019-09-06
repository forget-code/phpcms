<?php
require_once './include/common.inc.php';
defined('IN_PHPCMS') or exit('Access Denied');
$digg_setting = cache_read('digg_setting.php');
@extract($digg_setting);
if ($digg_mod && $channelid && $id && $con)
{
    if ($hits_on == 1)
    {
        if ($con == 6) echo getDiggCount($digg_mod, $channelid, $id , '', '1');
        if ($con == 7) echo abs(getDiggCount($digg_mod, $channelid, $id , '', '-1'));
    } 
    else
    {
        echo getDiggCount($digg_mod, $channelid, $id , '', '');
    } 
} 
else
{
    echo '0';
} 

?>