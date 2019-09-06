<?php
require dirname(__FILE__).'/include/common.inc.php';
$rssid = intval($rssid);
$head['title'] ='RSS订阅中心'.' - '.$PHPCMS['sitename'];
$head['keywords'] = $M['name'];
$head['description']  = $M['name'].' - '.$PHPCMS['sitename'];
if(!empty($rssid))
{
    require 'rss.class.php';
    $rssid = intval($rssid);
    $catname    =  $db->get_one("SELECT `catname`, `url`, `arrchildid` FROM ".DB_PRE."category WHERE `catid` = '$rssid'  LIMIT 1");
    $encoding   =  CHARSET;
    //$about      =  SITE_URL.$catname['url'];
    $about      =  SITE_URL;
    $title      =  $catname['catname'].'-'.$PHPCMS['sitename'];
    $description =  $PHPCMS['meta_description'];
    $image_link =  SITE_URL.'images/logo.gif';
    $category   =  $PHPCMS['sitename'];
    $cache      =  60;
    $rssfile    = new RSSBuilder($encoding, $about, $title, $description, $image_link, $category, $cache);
    $publisher  =  '';
    $creator    =  SITE_URL;
    $date       =  date('r');
    $rssfile->addDCdata($publisher, $creator, $date);
    $period     =  '';
    $frequency =  SITE_URL;
    $base =  date('Y');
    $rssfile->addSYdata($period, $frequency, $base);
    $sql = "SELECT `title`, `description`, `url`, `inputtime`, `thumb`, `keywords` FROM ".DB_PRE."content WHERE `status` = '99' ";
    $ids = explode(",",$catname['arrchildid']);
    if(count($ids) == 1 && in_array($rssid, $ids))
    {
        $sql .= "AND `catid` = '$rssid'";
    }
    else
    {
        $sql .= get_sql_catid($rssid);
    }
    $sql .= " ORDER BY `catid` DESC LIMIT 0 , 20";
    $result = $db->query($sql);
    while ( $r = $db->fetch_array($result) )
    {
        if(!empty($r['thumb'])) $img = "<img src=".thumb($r['thumb'], 150, 150)." border='0' /><br />";else $img = '';
        $tags = '';
        if(!empty($r['keywords']))
        {
            $tags .= "<br /><strong>Tags</strong>:";
            $keys = explode(" ", $r['keywords']);
            foreach ($keys AS $v)
            {
                $tags .= "<a href=tag.php?tag=".urlencode($v)." target='blank'>".$v."</a>&nbsp;&nbsp;";
            }
        }
        else
        {
            $tags = '';
        }
        $about          =  $link = preg_match('/^http:\/\//',$r['url']) ? $r['url'] : SITE_URL.$r['url'];
        $title          =  "<![CDATA[".$r['title']."]]>";
        $description    =  "<![CDATA[".$img.$r['description'].$tags."]]> ";
        $subject        =  '';
        $date           =  date('Y-m-d H:i:s' , $r['inputtime']);
        $author         =  $PHPCMS['sitename'].' '.SITE_URL;
        $comments       =  '';//注释
        $image          =  '';
        $rssfile->addItem($about, $title, $link, $description, $subject, $date,	$author, $comments, $image);
    }
    $version = '2.00';
    $rssfile->outputRSS($version);
}
elseif($respond == output)
{
    require 'rss.class.php';
    $encoding   =  CHARSET;
    $about      =  SITE_URL;
    $title      =  $catname['catname'].'-'.$PHPCMS['sitename'];
    $description =  $PHPCMS['meta_description'];
    $image_link =  SITE_URL.'images/logo.gif';
    $category   =  $PHPCMS['sitename'];
    $cache      =  60;
    $rssfile    = new RSSBuilder($encoding, $about, $title, $description, $image_link, $category, $cache);
    $publisher  =  '';
    $creator    =  SITE_URL;
    $date       =  date('r');
    $rssfile->addDCdata($publisher,	$creator, $date);
    $period     =  '';
    $frequency =  SITE_URL;
    $base =  date('Y');
    $rssfile->addSYdata($period, $frequency, $base);
    $sql = "SELECT `title`, `description`, `url`, `inputtime`, `thumb`, `keywords` FROM ".DB_PRE."content WHERE `status` = '99' ORDER BY `catid` DESC LIMIT 0 , 20";
    $result = $db->query($sql);
    while ( $r = $db->fetch_array($result) )
    {
        if(!empty($r['thumb'])) $img = "<img src=".thumb($r['thumb'], 150, 150)." border='0' /><br />";else $img = '';
        $tags = '';
        if(!empty($r['keywords']))
        {
            $tags .= "<br /><strong>Tags</strong>:";
            $keys = explode(" ", $r['keywords']);
            foreach ($keys AS $v)
            {
                $tags .= "<a href=tag.php?tag=".urlencode($v)." target='blank'>".$v."</a>&nbsp;&nbsp;";
            }
        }
        else
        {
            $tags = '';
        }
        $about          =  $link = preg_match('/^http:\/\//',$r['url']) ? $r['url'] : SITE_URL.$r['url'];
        $title          =  "<![CDATA[".$r['title']."]]>";
        $description    =  "<![CDATA[".$img.$r['description'].$tags."]]> ";
        $subject        =  '';
        $date           =  date('Y-m-d H:i:s' , $r['inputtime']);
        $author         =  $PHPCMS['sitename'].' '.SITE_URL;
        $comments       =  '';//注释
        $rssfile->addItem($about, $title, $link, $description, $subject, $date,	$author, $comments, $image);
    }
    $version = '2.00';
    $rssfile->outputRSS($version);
}
else
{
    $catid = intval($catid);
    if($catid)
    {
        $query = "SELECT `catname` FROM ".DB_PRE."category WHERE `catid` = $catid";
        $one = $db->get_one($query);
        $title = $one['catname'];
    }
    else
    {
        $title = 'RSS订阅列表';
    }
	if(!isset($CATEGORY[$catid])) $catid = 0;
    $categorys = subcat('phpcms', $catid, 0);
    include template('phpcms', 'rss');
}
?>