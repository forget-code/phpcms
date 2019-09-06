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
    $smi    =& new google_sitemap_item($domain, $today, 'daily', '1.0');
    $sm->add_item($smi);

    $result1 = $db->query("SELECT * FROM ".DB_PRE."content ORDER BY `inputtime` DESC LIMIT 0 , $num ");
    while($r = $db->fetch_array($result1))
    {
        $row = $db->get_one("SELECT * FROM ".DB_PRE."content_position AS a,".DB_PRE."content_count AS b WHERE a.contentid = b.contentid AND a.contentid = $r[contentid] AND b.hits > '100'");
        if($row)
        {
            $smi    =& new google_sitemap_item($domain.$r['url'], $today, $content_changefreq, '0.8');//推荐文件
            $sm->add_item($smi);
        }
        else
        {
            $row = $db->get_one("SELECT * FROM ".DB_PRE."content_position WHERE `contentid` = $r[contentid]");
            if($row)
            {
                $smi    =& new google_sitemap_item($domain.$r['url'], $today, $content_changefreq, '0.6');//推荐文件
                $sm->add_item($smi);
            }
            else
            {
                $row = $db->get_one("SELECT * FROM ".DB_PRE."content_count WHERE `contentid` = $r[contentid]");//热点文章
                if($row[hits] > 1000)
                {
                    $smi    =& new google_sitemap_item($domain.$r['url'], $today, $content_changefreq, '0.5');
                    $sm->add_item($smi);
                }
                else
                {
                    $smi    =& new google_sitemap_item($domain.$r['url'], $today, $content_changefreq, $content_priority);
                    $sm->add_item($smi);
                }
            }
        }
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
