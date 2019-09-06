<?php 
defined('IN_PHPCMS') or exit('Access Denied');

if($dosubmit)
{
	require_once PHPCMS_ROOT."/include/charset.func.php";

	$maxdaynumber = intval($maxdaynumber);
	$maxnumber = intval($maxnumber);

	$maxdaynumber = $maxdaynumber ? $maxdaynumber : 90;
	$maxnumber = $maxnumber ? $maxnumber : 500;

	$siteurl = 'http://'.$PHP_DOMAIN;
	$baseurl = 'http://'.$PHP_DOMAIN.PHPCMS_PATH;

	$data = '<?xml version="1.0" encoding="UTF-8"?>
			 <urlset xmlns="http://www.google.com/schemas/sitemap/0.84">';
    $today = date('Y-m-d');
	$urls[0] = array('url'=>$baseurl , 'updatetime'=>$today , 'frequency'=>'daily' , 'priority'=>'1.0');
	foreach($CHANNEL as $channel)
	{
		if(!$channel['islink'])
		{
			$module = $channel['module'];
			$channelid = $channel['channelid'];
			$channelurl = $channel['linkurl'];
			$urls[] = array('url'=>linkurl($channelurl, 1) , 'updatetime'=>$today , 'frequency'=>'daily' , 'priority'=>'0.8');
            $CATEGORY = cache_read("categorys_".$channelid.".php");
			if(is_array($CATEGORY))
			{
				foreach($CATEGORY as $cat)
				{
					$urls[] = array('url'=>linkurl($cat['linkurl'], 1), 'updatetime'=>$today , 'frequency'=>'daily' , 'priority'=>'0.7');
					$itemid = $module."id";
					$query = "SELECT $itemid,linkurl,addtime,arrposid,hits FROM ".channel_table($module, $channelid)." WHERE catid=$cat[catid] AND addtime>$PHP_TIME-86400*$maxdaynumber ORDER BY addtime DESC LIMIT 0,$maxnumber";

					$result = $db->query($query);
					while($r = $db->fetch_array($result))
					{
						if($r['arrposid']) $priority = "0.6";
						elseif($r['hits']>1000) $priority = "0.5";
						else $priority = "0.3";
						$urls[] = array('url'=>linkurl($r['linkurl'], 1) , 'updatetime'=>date('Y-m-d',$r['addtime']) , 'frequency'=>'yearly' , 'priority'=>$priority);
					}
				
				}
			}
		}
	}

	foreach($urls as $url)
	{
		$data .= '<url>
					<loc>'.htmlspecialchars($url['url']).'</loc>
					<lastmod>'.$url['updatetime'].'</lastmod>
					<changefreq>'.$url['frequency'].'</changefreq>
					<priority>'.$url['priority'].'</priority>
				  </url>';
	}
	$data .= '</urlset>';
	$data = convert_encoding('gbk','utf-8',$data);
	file_put_contents(PHPCMS_ROOT.'/sitemap.xml', $data);
	@chmod(PHPCMS_ROOT.'/sitemap.xml', 0777);
	showmessage($LANG['google_map_created_link_num'].count($urls));
}
else
{
	include admintpl('sitemap');
}
?>