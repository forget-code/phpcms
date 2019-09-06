<?php
defined('IN_PHPCMS') or exit('Access Denied');
include 'admin/sitemaps.class.php';
if($dosubmit)
{
    if($mark)
    {
        include 'admin/baidunews.class.php';
        $baidu = new baidunews($email, $time,$num);
        $baidu->set_xml();
    }
    $num = empty($num) ? $num : 20;
    $today = date('Y-m-d');
    $domain = SITE_URL;
    $sm     =& new google_sitemap();
    $smi    =& new google_sitemap_item($domain, $today, $content_changefreq, $content_priority);
    $sm->add_item($smi);
    $sql = "SELECT `url` FROM ".DB_PRE."category ";
    $result = $db->query($sql);
    while($r = $db->fetch_array($result))
    {
         $smi    =& new google_sitemap_item($domain.$r['url'], $today, $content_changefreq, $content_priority);
        $sm->add_item($smi);
    }

    $result1 = $db->query("SELECT `url` FROM ".DB_PRE."content ORDER BY `inputtime` DESC LIMIT 0 , $num ");
    while($r = $db->fetch_array($result1))
    {
        $smi    =& new google_sitemap_item($domain.$r['url'], $today, $content_changefreq, $content_priority);
        $sm->add_item($smi);
    }

    $sm_file = PHPCMS_ROOT.'sitemaps.xml';
    if($sm->build($sm_file))
    {
        showmessage('生成成功');
    }
}
else
{
    include admin_tpl('googlesitemap');
}
?>
