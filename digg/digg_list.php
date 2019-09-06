<?php
require_once './include/common.inc.php';
if ($digg_catid)
{
    $catid_where = " AND `digg_catid`='$digg_catid' ";
} 
if ($digg_mod && $list_num && $title_text)
{
    $digg_setting = cache_read('digg_setting.php');
    extract($digg_setting);
    unset($digg_setting);
    if ($digg_defind != 0)
    {
        $digg_defind = $digg_defind?$digg_defind:0;
        $digg_date = date("Ymd", mktime(0, 0, 0, date('m', $PHP_TIME), date('d', $PHP_TIME) - intval($digg_defind), date('Y', $PHP_TIME)));
        $digg_defind = "AND `digg_date`>'" . date("Ymd", mktime(0, 0, 0, date('m', $PHP_TIME), date('d', $PHP_TIME) - intval($digg_defind), date('Y', $PHP_TIME))) . "'";
    } 
    else
    {
        $digg_defind = '';
    } 
    // 分页
    if ($page_on == 1 && $page)
    {
        $url = "list.php?digg_mod=$digg_mod&digg_catid=$digg_catid";
        $sql = "SELECT COUNT(*) AS num FROM " . TABLE_DIGG_DATA . " WHERE `mod`='$digg_mod'" . $catid_where . $digg_defind;
        $res = $db->get_one($sql);
        $page = $page ? intval($page) : 1;
        $pageend = ($page-1) * $list_num;
        $pages = phppages($res['num'], $page, $list_num, $url);
    } 
    else
    {
        $pageend = 0;
    } 
    $sql = "SELECT * FROM " . TABLE_DIGG_DATA . " WHERE `mod`='$digg_mod' " . $catid_where . $digg_defind . " LIMIT $pageend ,$list_num";
    $res = $db->query($sql);
    while ($rows = $db->fetch_array($res))
    { 
        // 评论数
        if ($comment_on == 1)
        {
            $sql = "SELECT count(cid) AS totalnumber FROM " . TABLE_COMMENT . " WHERE keyid='$rows[digg_channel]' AND itemid='$rows[text_id]' AND passed=1";
            $r = $db->get_one($sql);

            $rows['digg_comment'] = $r['totalnumber'];
        } 
        // 点击数
        if ($hits_on == 1)
        {
            $table_end = $rows['digg_channel'] != 0?'_' . $rows['digg_channel']:'';
            $sql = "SELECT hits FROM `" . $CONFIG['tablepre'] . $digg_mod . $table_end . "` WHERE `" . $digg_mod . "id`='$rows[text_id]'";
            $r = $db->get_one($sql);
            $rows['hits'] = $r['hits'] ;
        } 
        $rows['digg_hits'] = getDiggCount($rows['mod'], $rows['digg_channel'], $rows['text_id'], $digg_date, '1');
        $rows['digg_title'] = str_cut($rows['digg_title'], $title_text, '..');
        $rows['digg_text'] = str_cut($rows['digg_text'], $text_num, '..');
        $digg_list[] = $rows;
    } 
    if (is_array($digg_list))
    {
        foreach ($digg_list as $key => $row)
        {
            $volume[$key] = $row['digg_hits'];
        } 
        @array_multisort($volume, SORT_DESC, $digg_list);
    } 
    $cat_file = "category_" . $digg_catid . ".php";
    $all_cats = cache_read($cat_file);
    $templateid = $templateid ? $templateid : 'digg_list';
    include template('digg', $templateid);
} 
else
{
    exit($LANG['illegal_parameters']);
} 

?>

