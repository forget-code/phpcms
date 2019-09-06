<?php
function getDiggCount($module = 0, $channelid = 0, $contentid = 0, $date = 0 , $digg_hits_on = 0)
{
    global $db, $CONFIG;
    $channelid = $channelid?$channelid:0;
    $hits_on = $digg_hits_on != 0?TABLE_DIGG . ".digg_hits ='$digg_hits_on' AND ":'';
    if ($date != 0)$digg_date = TABLE_DIGG . ".digg_date >'$date'  AND ";
    $sql = "SELECT sum(digg_hits) AS digg_hits  FROM " . TABLE_DIGG . "," . TABLE_DIGG_DATA . " WHERE " . TABLE_DIGG_DATA . ".mod='$module' AND " . TABLE_DIGG_DATA . ".text_id='$contentid' AND " . TABLE_DIGG_DATA . ".digg_channel=" . "'$channelid'  AND " . $digg_date . $hits_on . TABLE_DIGG_DATA . ".digg_id=" . TABLE_DIGG . ".digg_id";
    $res = $db->get_one($sql);
    @extract($res);
    $digg_hits = $digg_hits?$digg_hits:0;
    return $digg_hits;
}

?>