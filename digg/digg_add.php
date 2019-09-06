<?php
require_once './include/common.inc.php';
require_once MOD_ROOT . '/include/html_trim.class.php';
$mod = $digg_mod;
$digg_setting = cache_read('digg_setting.php');
@extract($digg_setting);
unset($digg_setting);
if ($mod && $id)
{
	if($id) $id = intval($id);
    $table_end = $channelid == 0?'':'_' . $channelid;
    $table_name = $CONFIG['tablepre'] . $mod . $table_end;
    $mod_id = $mod . 'id';
    // 因为文章特殊,在这里做特别处理
    if ($mod == 'article')
    {
        $table_name_date = $CONFIG['tablepre'] . $mod . '_data_' . $channelid;
        $sql = "SELECT title,catid,content AS introduce ,linkurl,editor from $table_name ,$table_name_date WHERE $table_name.articleid='$id' AND $table_name_date.articleid='$id'";
    }
    // 因为商城特殊,在这里做特别处理
    elseif ($mod == 'product')
    {
        $sql = "SELECT pdt_name AS title , introduce , pdt_description AS productid, linkurl from $table_name  WHERE productid='$id'";
    }
    else
    {
        $sql = "SELECT * FROM $table_name WHERE $mod_id='$id'";
    }
    $res = $db->get_one($sql);
	unset($res['credit_on']);
    @extract($res);
	
    unset($res);
    // 去除HTML标签
    $str = new Html_Trim;
    $introduce = $str->HtmlTrim($introduce, 0);
    $introduce = addslashes($introduce);
    $title = addslashes($title);
    if ($con && $con != 5 && $con != 0)
    {
        $digg_con = $con == '3'?intval(-1):intval(1);
        $sql = "SELECT `digg_id` FROM " . TABLE_DIGG_DATA . " WHERE `mod`='$mod' AND `text_id`='$id' and  `digg_channel`='$channelid'";
        $res = $db->get_one($sql);
        $digg_id = $res['digg_id'];
        if (!$digg_id)
        {
            $sql = 'INSERT INTO ' . TABLE_DIGG_DATA . " (`digg_channel` ,`mod` ,`text_id`  ,`digg_title`,`digg_text`,`digg_link` ,`digg_catid`,`digg_date` )VALUES ( '$channelid', '$mod', '$id','$title','$introduce', '$linkurl','$catid','" . date('Ymd', $PHP_TIME) . "');";
            $db->query($sql);
            $digg_id = $digg_id?'':$db->insert_id();
        }
        else
        {
            $sql = "UPDATE " . TABLE_DIGG_DATA . " SET `digg_date`=" . date('Ymd', $PHP_TIME) . " WHERE `digg_id`='$digg_id'";
            $db->query($sql);
        }
        $sql = "SELECT `digg_id` FROM " . TABLE_DIGG . " WHERE `mod`='$mod' AND `text_id`='$id' AND  `digg_channel`='$channelid' AND `digg_ip`='$PHP_IP' AND `digg_hits`='$digg_con'  AND `digg_date`>'" . date("Ymd", mktime(0, 0, 0, date('m', $PHP_TIME), date('d', $PHP_TIME) - intval($digg_cookie), date('Y', $PHP_TIME))) . "'";
        $res = $db->get_one($sql);
        if (!$res)
        {
            $sql = "INSERT INTO " . TABLE_DIGG . " (`digg_channel` ,`mod` ,`text_id` ,`digg_id` ,`digg_hits` ,`digg_date` ,`digg_ip` ,`digg_catid`) VALUES ('$channelid', '$mod', '$id','$digg_id', '$digg_con', '" . date('Ymd', $PHP_TIME) . "','$PHP_IP','$catid');";
            $db->query($sql);
        }
        else
        {
            exit($LANG['already_hits']);
        }
        $cookie_con = $con == 3?'down':'';
        if ($con != '5' || $con != '0')
        {
            $cookie_name = $mod . $channelid . $id . trim($cookie_con);
            mkcookie("$cookie_name", $id, $PHP_TIME + 3600 * 24 * intval($digg_cookie));
        }
    }
    if ($hits_on == 1)
    {
        if ($con == 3 || $con == 5) $digg_hits_down = abs(getDiggCount($mod , $channelid , $id , '', '-1'));
        if ($con == 1 || $con == 0 || $con == 2) $digg_hits_up = getDiggCount($mod , $channelid , $id , '', '1');
    }
    else
    {
        $digg_hits_down = $digg_hits_up = getDiggCount($mod , $channelid , $id , '', '');
    }
	
    if ($credit_on == 1 && $con && $con != 5 && $con != 0)
    {
        $sql = "SELECT `credit` FROM " . TABLE_MEMBER . " WHERE `username`='$editor'";

        $res_member = $db->get_one($sql);

        if ($res_member)
        {
            if ($con == 3)
            {
                $credit = $res_member['credit'] - $credit_num;
            }
            if ($con == 1 || $con == 2)
            {
                $credit = $res_member['credit'] + $credit_num;
            }

            $db->query("UPDATE " . TABLE_MEMBER . " SET `credit`='$credit' WHERE `username`='$editor'");
        }
    }
}
else
{
    showmessage($LANG['illegal_operation']);
}
if ($con == 0 || $con == 1)
{
    include template('digg', 'digg_up_last');
}
if ($con == 5 || $con == 3)
{
    include template('digg', 'digg_down_last');
}
if ($con == 2)
{
    include template('digg', 'digg_list_up_last');
}

?>

