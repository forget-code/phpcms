<?php
function digg_add($digg_on, $digg_down_on, $style)
{
    global $CONFIG, $db, $MOD, $LANG, $channelid, $mod, $itemid, $skindir, $catid;
    switch ($mod)
    {
        case 'article':
            global $articleid;
            $id = $articleid;
            break;
        case 'down':
            global $downid;
            $id = $downid;
            break;
        case 'product':
            global $productid;
            $id = $productid;
            break;
        case 'picture':
            global $pictureid;
            $id = $pictureid;
            break;
        case 'info':
            global $infoid;
            $id = $infoid;
            break;
        case 'movie':
            global $movieid;
            $id = $movieid;
            break;
    }
    $templateid = $templateid ? $templateid : 'tag_digg';
    include template('digg', $templateid);
}
function digg_list($list_num, $title_text, $text_num, $digg_catid, $digg_defind, $templateid, $digg_channelid, $page_on = 1, $comment_on, $hits_on, $index_on)
{
    global $CONFIG, $db, $MODULE, $LANG, $CHA, $MOD, $digg_mod, $CHANNEL, $page;
    if ($index_on == 0)
    {
        global $catid;
        $digg_catid = $catid;
    }
    if ($digg_catid == 0) global $digg_catid;
    $digg_mod = $digg_channelid?$CHANNEL[$digg_channelid]['module']:$digg_mod;
    $templateid = $templateid ? $templateid : 'tag_digg_list';
    include template('digg', 'digg_list');
}

?>